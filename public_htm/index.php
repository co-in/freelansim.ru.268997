<?php

//Автозагрузчик классов
use classes\db\DBHelper;

require __DIR__ . '/autoload.php';

$db = new DBHelper(require __DIR__ . '/../config/db.php');

//Вытащить список прокси
print_r($db->select());