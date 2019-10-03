<?php

use classes\db\DBHelper;
use classes\output\ConsoleOutput;
use classes\proxy\Proxy;

require __DIR__ . '/autoload.php';

try {
	$result = (new Proxy(
		new DBHelper(require __DIR__ . '/../config/db.php'),
		new ConsoleOutput()
	))
		//Выставляем произвольный UserAgent
		->setUserAgent("Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:66.0) Gecko/20100101 Firefox/66.0")
		//Получаем контент страницы с использованием прокси
		->getContentProxy("https://api.ipify.org?format=json");
} catch (Exception $exception) {
	$result = $exception->getMessage();
}

echo "{$result}\n";
