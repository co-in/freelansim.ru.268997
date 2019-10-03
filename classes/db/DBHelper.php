<?php

namespace classes\db;

use classes\parsers\Mapper;

/** TODO Сделать универсальные методы и убрать зависимости */
class DBHelper extends DBConnection implements IDb {

	public function increaseScore(string $ip, int $port, int $typeEnum) {
		$query = "	UPDATE proxy_list 
					SET `score`= score + IF(ping = 0, 5, 1) -- Увеличить бан, если прокси до этого не подключался
					WHERE `ip`= :ip 
					      AND `port`= :port
					      AND `type_enum` = :typeEnum";

		$this->prepare($query)
			->execute([
				':ip' => $ip,
				':port' => $port,
				':typeEnum' => $typeEnum,
			]);
	}

	public function updatePing(string $ip, int $port, int $typeEnum, int $ping) {
		$query = "	UPDATE proxy_list 
					SET ping = :ping
					WHERE `ip`= :ip 
					      AND `port`= :port
					      AND `type_enum` = :typeEnum";

		$this->prepare($query)
			->execute([
				':ip' => $ip,
				':port' => $port,
				':typeEnum' => $typeEnum,
				':ping' => $ping,
			]);
	}

	public function select() {
		$query = "  SELECT
						CONCAT(l.ip,':', l.port) AS address,
         				l.ping,
         				l.hide_enum,
         				l.country_enum,
         				l.type_enum,
         				l.score,
         				l.date_update
					FROM proxy_list l";

		$data = $this
			->query($query)
			->fetchAll(self::FETCH_ASSOC);

		$hideEnum = Mapper::getConstantGroup("HIDE_", false);
		$typeEnum = Mapper::getConstantGroup("TYPE_", true);
		$countryEnum = array_flip(Mapper::$country_enumMap);

		foreach ($data as $index => $row) {

			$data[$index] = [
				'address' => $row['address'],
				'ping' => (int)$row['ping'],
				'score' => (int)$row['score'],
				'date_update' => $row['date_update'] === '0000-00-00 00:00:00' ? null : $row['date_update'],

				//TODO Дублирование кода
				'hide_enum' => array_key_exists($row['hide_enum'], $hideEnum) ? $hideEnum[$row['hide_enum']] : null,
				'country_enum' => array_key_exists($row['country_enum'], $countryEnum) ? $countryEnum[$row['country_enum']] : null,
				'type_enum' => array_key_exists($row['type_enum'], $typeEnum) ? $typeEnum[$row['type_enum']] : null,
			];
		}

		return array_values($data);
	}

	public function findBest(int $type): ?array {
		$query = "  SELECT
						l.ip,
						l.port
					FROM proxy_list l
  					WHERE l.type_enum = :typeEnum
  					ORDER BY l.score, l.ping, RAND() -- Добавим немного случайности, чтоб не долбить один хороший прокси
					LIMIT 1";

		$sth = $this->prepare($query);
		$sth->execute([
			':typeEnum' => $type,
		]);

		$best = $sth->fetch(self::FETCH_ASSOC);

		return $best === false ? null : $best;
	}

	public function batchInsert(array $data) {
		$dataChunk = array_chunk($data, 1000);
		$columns = [];

		foreach ($dataChunk as $data) {
			$values = [];
			$binds = [];

			foreach ($data as $index => $columns) {
				$placeholders = [];
				ksort($columns);

				foreach ($columns as $key => $value) {
					$placeholder = ":{$key}_{$index}";

					if (is_null($value)) {
						$placeholder = 'NULL';
					} else {
						$binds[$placeholder] = $value;
					}

					$placeholders[] = $placeholder;
				}

				$values[] = '(' . implode(",\n ", $placeholders) . ')';
			}

			$values = implode(',', $values);
			$columns = implode(',', array_keys($columns));

			//Пропускаем дубликаты
			$query = "	INSERT 
						INTO proxy_list 
						    ({$columns})
						VALUES {$values}
						ON DUPLICATE KEY UPDATE 
							ip = ip,
							port = port,
						    type_enum = type_enum";

			$this->prepare($query)
				->execute($binds);
		}
	}
}