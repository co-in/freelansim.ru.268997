<?php

namespace classes\proxy;

use classes\db\IDB;
use classes\parsers\IParser;

class Processor {

	/**@var IParser[] $parsers */
	protected $parsers = [];

	/**@var IDb */
	protected $db;

	/**
	 * Processor constructor.
	 *
	 * @param IDB $db
	 */
	public function __construct(IDb $db) {
		$this->db = $db;
	}

	/**
	 * Добавляет парсер в очередь
	 *
	 * @param IParser $parser
	 * @return $this
	 */
	public function addParser(IParser $parser): self {
		$this->parsers[] = $parser;

		return $this;
	}

	/**
	 * Получает данные по всем парсерам, и сохраняет/обновляет их в базе
	 *
	 * @return array Возвращает список недостающих ключей в мапе
	 */
	public function execute(): array {
		$batchInsert = [];
		$missingKeys = [];

		foreach ($this->parsers as $parser) {
			//Парсим данные
			$batchInsert = array_replace_recursive($batchInsert, $parser->parse());

			//Получаем список недостающих в мапе значений
			$missingKeys = array_replace_recursive($missingKeys, $parser->getMissing());
		}

		//Вставляем/Обновляем записи в базе
		$this->db->batchInsert($batchInsert);
		unset($batchInsert);

		$missing = [];

		//Форматируем значения с недостающими полями
		foreach ($missingKeys as $key => $values) {
			$missing[$key] = array_keys($values);
		}

		unset($missingKeys);

		return $missing;
	}
}