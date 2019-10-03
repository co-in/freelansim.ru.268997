<?php

use classes\db\DBHelper;
use classes\output\ConsoleOutput;
use classes\proxy\Proxy;

//Автозагрузчик классов
require __DIR__ . '/autoload.php';

$output = new ConsoleOutput();
$output->info((new Proxy(
	new DBHelper(require __DIR__ . '/../config/db.php'),
	$output
))
	//Выставляем произвольный UserAgent
	->setUserAgent("Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:66.0) Gecko/20100101 Firefox/66.0")
	//Получаем контент страницы с использованием прокси
	->getContentProxy("https://api.ipify.org?format=json"));


