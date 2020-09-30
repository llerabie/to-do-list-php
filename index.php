<?php

session_start();

define("ROOT_DIR",dirname(__FILE__).'/');

require_once "vendor/autoload.php";
require_once "vendor/main.php"; //основной класс приложения

$application = new Application();
$application->run();
