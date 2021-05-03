<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use \Monolog\Handler\FilterHandler;
use \Monolog\Handler\BrowserConsoleHandler;
use \Monolog\Handler\NativeMailerHandler;

$message = $_GET['message'];
$to = 'martedeleeuw@hotmail.com';
$from = 'martedeleeuw1@gmail.com';

$logger = new Logger('my_logger');

$infoHandler = new StreamHandler(__DIR__ . '/info.log', Logger::DEBUG);
$warningHandler = new StreamHandler(__DIR__ . '/warning.log', Logger::WARNING);
$emergencyHandler = new StreamHandler(__DIR__ . '/emergency.log', Logger::EMERGENCY);
$consoleHandler = new BrowserConsoleHandler();

$logger->pushHandler(new FilterHandler($infoHandler, Logger::DEBUG,
    Logger::NOTICE));
$logger->pushHandler(new FilterHandler($warningHandler, Logger::WARNING,
    Logger::ALERT));
$logger->pushHandler(new FilterHandler($emergencyHandler, Logger::EMERGENCY,
    Logger::EMERGENCY));
$logger->pushHandler(new FilterHandler($consoleHandler, Logger::DEBUG,
    Logger::NOTICE));
$logger->pushHandler(new NativeMailerHandler($to, $message, $from, Logger::ERROR));


switch ($_GET['type']){
    case 'DEBUG':
    case 'INFO':
    case 'NOTICE':
        $logger->info($message);
        break;
    case 'WARNING':
    case 'ERROR':
    CASE 'CRITICAL':
    CASE 'ALERT':
        $logger->warning($message);
        break;
    CASE 'EMERGENCY':
        $logger->emergency($message);
        break;
}

require 'buttons.php';