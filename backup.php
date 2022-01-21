<?php

use Dotenv\Dotenv;
require_once __DIR__ . '/vendor/autoload.php';
define('ABSPATH', __DIR__);
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$current_date = new DateTime('now', new DateTimeZone('Europe/Paris'));

require_once __DIR__ . '/src/autoload.php';