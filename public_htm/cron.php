<?php

use classes\db\DBHelper;
use classes\parsers\transport\ProxyListDownloadParserHTTP;
use classes\parsers\transport\ProxyListDownloadParserHTTPS;
use classes\output\ConsoleOutput;
use classes\proxy\Processor;

//Автозагрузчик классов
require __DIR__ . '/autoload.php';

$output = new ConsoleOutput();

//Передаем подлкючение к базе в компоновщик
$missing = (new Processor(
	new DBHelper(require __DIR__ . '/../config/db.php')
))
	//Добавляем сколько нужно парсеров
	->addParser(new ProxyListDownloadParserHTTP($output))
	->addParser(new ProxyListDownloadParserHTTPS($output))
	//Получаем и сохраняем данные в базу
	->execute();

if (!empty($missing)) {
	$output->warning("Missing values '" . json_encode($missing) . "'");
}