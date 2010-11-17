<?php

define("APP_DIR", __DIR__ . '/app/');

include './src/Loader/Loader.php';

Loader\Loader::addNamespace('src', __DIR__ . '/src/');
Loader\Loader::addNamespace('controller', __DIR__ . '/app/controllers/');

$request = new HTTP\Request\Request;
$response = new HTTP\Response\Response;
$controller = new HTTP\Controller\Controller($request, $response);

?>
