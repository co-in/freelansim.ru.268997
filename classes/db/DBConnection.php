<?php

namespace classes\db;

use PDO;

class DBConnection extends PDO {

	public function __construct(array $dbConfig) {
		parent::__construct("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}", $dbConfig['user'], $dbConfig['pass']);

		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$this->query("set names utf8");
		$this->query("SET sql_mode = ''");
	}
}