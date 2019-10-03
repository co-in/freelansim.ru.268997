<?php

namespace classes\db;

class ProxyListEntity {

	protected $data = [];

	protected $missing = [];

	public function prepare(string $ip, string $port): EntityDummy {
		$entity = new EntityDummy([
			'ip' => $ip,
			'port' => $port,
			'type_enum' => null,
			'hide_enum' => null,
			'country_enum' => null,
			'ping' => null,
			'score' => null,
			'date_update' => null,
		]);

		return $entity;
	}

	public function insert(EntityDummy $entityDummy) {
		//Добавляем в уникальный ключ
		$this->data["{$entityDummy['ip']}|{$entityDummy['port']}|{$entityDummy['type_enum']}"] = (array)$entityDummy;

		//Обновляем список недостающих ключей
		$this->missing = array_replace_recursive($this->missing, $entityDummy->getMissing());
	}

	public function getData(): array {
		return $this->data;
	}

	public function getMissing(): array {
		return $this->missing;
	}
}