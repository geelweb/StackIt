<?php


require_once('external/predis/lib/Predis/Autoloader.php');
Predis\Autoloader::register();

require_once 'library/StackIt/Autoloader.php';
StackIt\Autoloader::register();

StackIt\Daemon::setConfig(__DIR__ . '/config.ini');
$d = StackIt\Daemon::singleton();
$d->run();
//$d->daemonize();
