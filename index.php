<?php

define("APP_DIR", __DIR__ . '/app/');

include './src/loader/loader.php';

Swift\Loader\Loader::addNamespace('Swift', __DIR__ . '/src/');
Swift\Loader\Loader::addNamespace('Application', __DIR__ . '/app/');

$request    = new Swift\HTTP\Request\Request;
$response   = new Swift\HTTP\Response\Response;
$controller = new Swift\HTTP\Controller\Controller($request, $response);

$response -> renderLayout($request -> controller_data);

?>
