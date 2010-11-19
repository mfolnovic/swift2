<?php

define('SRC_DIR', realpath(__DIR__ . '/../src') . '/'); 
define('APP_DIR', realpath(__DIR__ . '/fixtures/') . '/');

include SRC_DIR . 'loader/loader.php';

$loader = new Swift\Loader\Loader;
$loader -> addNamespace('Swift', SRC_DIR);

?>
