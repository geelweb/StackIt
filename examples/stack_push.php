<?php


require_once('external/predis/lib/Predis/Autoloader.php');
Predis\Autoloader::register();

require_once 'library/StackIt/Autoloader.php';
StackIt\Autoloader::register();

StackIt\Stack::setConfig(__DIR__ . '/config.ini');
StackIt\Stack::push('my-stack', array(
    'foo' => 'v1',
    'bar' => 'v2',
    'id_cli' => 1,
    'log_date' => date('Y-m-d H:i:s'),
));
StackIt\Stack::push('my-stack', array(
    'bar' => 'v3',
    'foo' => 'v4',
    'id_cli' => 2,
    'log_date' => date('Y-m-d H:i:s'),
));
