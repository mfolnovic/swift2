<?php

use Swift\HTTP\Response\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase {
	public function testStatusCode() {
		$response = new Response();

		$this -> assertEquals($response -> getStatusCode(), 200);

		$response -> setStatusCode(404);
		$this -> assertEquals($response -> getStatusCode(), 404);

		$response -> setStatusCode('500');
		$this -> assertEquals($response -> getStatusCode(), 500);
	}
}

?>
