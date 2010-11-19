<?php

use HTTP\Session\Session;

class SessionTest extends \PHPUnit_Framework_TestCase {
	var $session;

	public function setUp() {
		$this -> session = new Session(array('type' => 'native'));
	}

	public function tearDown() {
		unset($this -> session);
	}

	public function testWrite() {
		$this -> session -> set('foo', 'bar');
		$this -> session -> set('bar', 'foo');

		$this -> assertEquals($this -> session -> get('foo'), 'bar');
		$this -> assertEquals($this -> session -> get('bar'), 'foo');
	}

	public function testIsset() {
		$this -> assertFalse($this -> session -> exists('foo'));

		$this -> session -> set('foo', 'bar');
		$this -> assertTrue($this -> session -> exists('foo'));
	}
}

?>
