<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogHandler;
use Monolog\Logger;

function init_logger() {
    $dateformat = "d/m/Y - H:i:s";
    $stream_output = "[%datetime%] %level_name% > %message% %context% %extra%\n";
    $syslog_output = "%level_name% > %message% %context% %extra%\n";
    $stream_formater = new LineFormatter($stream_output, $dateformat);
    $syslog_formater = new LineFormatter($syslog_output, $dateformat);

    $log = new Logger('backup_logger');

    $stream_handler = new StreamHandler(ABSPATH . '/backup.log');
    $stream_handler->setFormatter($stream_formater);

    $syslog_handler = new SyslogHandler('minecraft-logger');
    $syslog_handler->setFormatter($syslog_formater);

    $log->pushHandler($stream_handler);
    $log->pushHandler($syslog_handler);
    $log->info('======================================');
    $log->info('Démarrage du script de sauvegarde');

    return $log;
}

$log = init_logger();