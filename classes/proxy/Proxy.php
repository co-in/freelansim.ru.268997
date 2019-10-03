<?php

namespace classes\proxy;

use classes\db\IDb;
use classes\output\IOutput;
use classes\parsers\Mapper;

class Proxy {

	/**@var string $userAgent */
	protected $userAgent;

	/**@var IDb $db */
	protected $db;

	/**@var IOutput $output */
	protected $output;

	/**
	 * Количество переключений прокси
	 *
	 * @var int $jump
	 */
	protected $jump = 0;

	/**
	 * Таймаут ожидания прокси
	 *
	 * @var int $timeout
	 */
	protected $timeout = 5;

	/**
	 * Последняя ошибка прокси
	 *
	 * @var string $lastError
	 */
	protected $lastError;

	/**
	 * Билдер прокси запросов
	 *
	 * @param IDb $db
	 * @param IOutput $output
	 */
	public function __construct(IDb $db, IOutput $output) {
		$this->db = $db;
		$this->output = $output;

		//UserAgent по умолчанию
		$this->userAgent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36";
	}

	/**
	 * Произвольный UserAgent
	 *
	 * @param string $userAgent
	 * @return $this
	 */
	public function setUserAgent(string $userAgent): self {
		$this->userAgent = $userAgent;

		return $this;
	}

	/**
	 * Реализация перехода через CURL
	 *
	 * @param string $url
	 * @param array $proxy
	 * @param int $typeEnum
	 * @return string|null
	 */
	protected function getByCurl(string $url, array $proxy, int $typeEnum): ?string {
		if (!$ch = curl_init($url)) {
			return null;
		}

		//TODO Другие параметры
		curl_setopt($ch, CURLOPT_PROXY, "{$proxy['ip']}:{$proxy['port']}");
		curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//TODO Небезопасно(MenInTheMiddle), но может решить проблемы с сертификатом
		if ($typeEnum === Mapper::TYPE_HTTPS) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		$output = curl_exec($ch);

		if (!$error = curl_error($ch)) {
			$error = null;
		}

		$this->lastError = $error;

		curl_close($ch);

		return $output === false ? null : $output;
	}

	/**
	 * Реализация перехода через file_get_contents
	 *
	 * @param string $url
	 * @param array $proxy
	 * @param int $typeEnum
	 * @return string|null
	 */
	protected function getByFileGetContent(string $url, array $proxy, int $typeEnum): ?string {
		//TODO Другие параметры
		$aContext = [
			'http' => [
				'timeout' => $this->timeout, //5 Секунд на ответ.
				'request_fulluri' => true,
				'method' => "GET",
				'header' => "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3\r\n" .
					"Referer: https://site-to-open.example/\r\n" .
					"Cookie: foo=bar\r\n" .
					"Cookie: foo=bar\r\n" .
					"User-Agent: {$this->userAgent}\r\n",
			],
		];

		if ($typeEnum === Mapper::TYPE_HTTPS) {
			//TODO Небезопасно(MenInTheMiddle), но может решить проблемы с сертификатом
			$aContext["ssl"] = [
				"verify_peer" => false,
				"verify_peer_name" => false,
			];
		}

		//Если прокси есть, значит подключаемся через него
		if (!is_null($proxy)) {
			$aContext['http']['proxy'] = "tcp://{$proxy['ip']}:{$proxy['port']}";
		}

		$cxContext = stream_context_create($aContext);

		//TODO Глушим принудительно Warning
		$output = @file_get_contents($url, false, $cxContext);

		if ($error = error_get_last()) {
			$error = $error['message'];
		}

		$this->lastError = $error;

		return $output === false ? null : $output;
	}

	/**
	 * Переключение на следующий прокси, в случае недоступности текущего
	 *
	 * @param string $url
	 * @param int $typeEnum
	 * @return array
	 */
	protected function recursiveProxyJump(string $url, int $typeEnum): array {
		$bestProxy = $this->db->findBest($typeEnum);

		$ping = microtime(true);
		//TODO Тут бы фабрику прикрутить
		$searchResult = $this->getByCurl($url, $bestProxy, $typeEnum);
		//Считаем время потраченное на запрос
		$ping = microtime(true) - $ping;

		if (is_null($searchResult)) {

			//Прокси больше нет, и без прокси не смогли получить результат
			if (is_null($bestProxy)) {
				return [null, null];
			}

			//Пометить прокси как не ответивший
			$this->db->increaseScore($bestProxy['ip'], $bestProxy['port'], $typeEnum);

			$this->jump++;

			$this->output->warning("#{$this->jump} {$bestProxy['ip']}:{$bestProxy['port']} {$this->lastError}");

			//Повторить попытку с новым прокси
			return $this->recursiveProxyJump($url, $typeEnum);
		}

		return [
			$searchResult,
			$bestProxy,
			(int)($ping * 1000),
		];
	}

	/**
	 * Получить контент, с помощью прокси
	 *
	 * @param string $url
	 * @return string|null
	 */
	public function getContentProxy(string $url): ?string {
		if (!preg_match('/^http(s)?:/', $url, $matches)) {
			$this->output->error("URL must be started at http?:");

			return null;
		}

		$typeEnum = isset($matches[1]) ? Mapper::TYPE_HTTPS : Mapper::TYPE_HTTP;

		list($searchResult, $bestProxy, $ping) = $this->recursiveProxyJump($url, $typeEnum);

		if ($bestProxy) {
			$this->db->updatePing($bestProxy['ip'], $bestProxy['port'], $typeEnum, $ping);
			$this->output->info("{$bestProxy['ip']}:{$bestProxy['port']} completed after {$this->jump} jumps with ping {$ping}ms");
		} else {
			$this->output->error("Proxy list is empty");
		}

		return $searchResult;
	}
}