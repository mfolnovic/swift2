<?php

define('SRC_DIR', realpath(__DIR__ . '/../src') . '/'); 

function autoload($function) {
	$function = strtr($function, '\\', '/');
	include SRC_DIR . $function . '.php';
}


spl_autoload_register('autoload');
?>
