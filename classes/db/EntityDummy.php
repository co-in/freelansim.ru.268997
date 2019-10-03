<?php

namespace classes\db;

use ArrayObject;
use classes\parsers\Mapper;

class EntityDummy extends ArrayObject {

	protected $missing = [];

	public function getMissing(): array {
		return $this->missing;
	}

	public function add(string $key, $value): self {
		//Проверяем есть ли у нашего ArrayObject ключ
		if (!$this->offsetExists($key)) {
			$this->missing[$key][$value] = null;

			//Игнорируем левые свойства
			return $this;
		}

		$propertyName = "{$key}Map";

		//Проверяем значение в мапе
		if (property_exists(Mapper::class, $propertyName)) {
			if (!array_key_exists($value, Mapper::$$propertyName)) {
				//Недостающие значения заносим в специальный массив
				if (!empty($value)) {
					$this->missing[$key][$value] = null;
				}

				//Если значение нет в мапе, тогда оставляем пустоту
				$value = null;
			} else {
				//Достаем значение из мапа
				$value = Mapper::$$propertyName[$value];
			}
		}

		//Обновляем у сущности значение
		$this[$key] = $value;

		return $this;
	}
}