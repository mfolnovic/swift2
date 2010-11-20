<?php

use Swift\HTTP\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {
	public function testGet() {
		$request = new Request(array('url' => 'home/'));

		$this -> assertEquals($request -> get -> url, 'home/');

		$request = new Request(array(), array('user' => array('username' => 'test', 'password' => 'simple'), 'sth' => 'something'));

		$this -> assertEquals($request -> post -> user, array('username' => 'test', 'password' => 'simple'));
		$this -> assertEquals($request -> post -> sth, 'something');
	}

	public function testStatusCode() {
		$request = new Request();

		$this -> assertEquals($request -> getStatusCode(), 200);

		$request -> setStatusCode(404);
		$this -> assertEquals($request -> getStatusCode(), 404);

		$request -> setStatusCode('500');
		$this -> assertEquals($request -> getStatusCode(), 500);
	}

	public function testRequestMethod() {
		$request = new Request(null, null, null, null, array('REQUEST_METHOD' => 'GET'));

		$this -> assertEquals($request -> getMethod(), 'GET');

		$request = new Request(array('method' => 'put'), null, null, null, array('REQUEST_METHOD' => 'GET'));

		$this -> assertEquals($request -> getMethod(), 'PUT');

	}

	public function testGetUrl() {
		$request = new Request(null, null, null, null, array('REQUEST_URI' => '/index.php', 'SCRIPT_NAME' => 'index.php'));

		$this -> assertEquals($request -> getUrl(), '/index.php');

		$request = new Request();
		$this -> assertEquals($request -> getUrl(), '/');
	}

	/**
	 * @dataProvider GetRequestUrlProvider
	 */
	public function testGetRequestUrl($url, $match) {
		$request = new Request(null, null, null, null, array('REQUEST_URI' => $url, 'SCRIPT_NAME' => '/swift/index.php'));

		$this -> assertEquals($request -> getRequestUrl(), $match);
	}

	/**
	 * @codeCoverageIgnore
	 */
	public function GetRequestUrlProvider() {
		return array(
			array('/swift/hello/world', 'hello/world'),
			array('/swift/hello///', 'hello')
		);
	}
}

?>
