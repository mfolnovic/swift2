<?php

use Swift\Cache\Cache;

class FrontendTest extends \PHPUnit_Framework_TestCase {
	var $frontend;

	public function setUp() {
		$this -> frontend = Cache::getFrontend();
		$this -> assertFalse(empty($this -> frontend));
	}

	public function testFrontendCache() {
		$this -> frontend -> start('test');
		echo 'hello';
		echo 'buu';
		$this -> assertEquals($this -> frontend -> end(), 'hellobuu');
		$this -> assertEquals($this -> frontend -> storage['test'], 'hellobuu');
	}
}

?>
