<?php

use Swift\Cache\Cache;

class ApcTest extends \PHPUnit_Framework_TestCase {
	var $backend;

	public function setUp() {
		$this -> backend = Cache::getBackend(array('adapter' => 'apc'));
		$this -> assertFalse(empty($this -> backend));

		$this -> backend -> clear();
	}

	public function testSet() {
		$this -> assertFalse($this -> backend -> exists('foo'));
		$this -> backend -> set('foo', 'bar');
		$this -> assertTrue($this -> backend -> exists('foo'));
		$this -> assertEquals($this -> backend -> get('foo'), 'bar');
	}

	public function testTtl() {
/*		$this -> backend -> set('bar', 'foo', 1);
		sleep(2);
		$this -> assertFalse($this -> backend -> exists('bar'));*/
	}
}

?>
