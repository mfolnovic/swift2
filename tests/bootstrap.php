<?php

define('SRC_DIR', realpath(__DIR__ . '/../src') . '/'); 
define('APP_DIR', realpath(__DIR__ . '/fixtures/') . '/');

include SRC_DIR . 'Loader/Loader.php';

$loader = new Loader\Loader;
$loader -> addNamespace('src', SRC_DIR);

?>
