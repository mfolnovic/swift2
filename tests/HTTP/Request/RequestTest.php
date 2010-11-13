<?php

namespace HTTP\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {
	public function testGet() {
		$request = new Request(array('url' => 'home/'));

		$this -> assertEquals($request -> get -> url, 'home/');
	}

	public function testStatusCode() {
		$request = new Request();

		$this -> assertEquals($request -> getStatusCode(), 200);

		$request -> setStatusCode(404);
		$this -> assertEquals($request -> getStatusCode(), 404);

		$request -> setStatusCode('500');
		$this -> assertEquals($request -> getStatusCode(), 500);
	}

	public function testGetUrl() {
		$request = new Request(array(),array(),array(),array(),array('REQUEST_URI' => '/index.php'));

		$this -> assertEquals($request -> getUrl(), '/index.php');

		$request = new Request();
		$this -> assertEquals($request -> getUrl(), '/');
	}
}

?>
