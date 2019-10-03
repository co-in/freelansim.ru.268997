<?php

use classes\db\DBHelper;
use classes\output\ConsoleOutput;

//Автозагрузчик классов
require __DIR__ . '/autoload.php';

$output = new ConsoleOutput();
$db = new DBHelper(require __DIR__ . '/../config/db.php');

//Вытащить список прокси
$output->info(print_r($db->select(), true));