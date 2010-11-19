<?php

use Swift\HTTP\Router\Router;

class RouterTest extends \PHPUnit_Framework_TestCase {
	var $router;

	function setUp() {
		$this -> router = new Router();
	}

	function testLoadRoutes() {
		$this -> router -> loadRoutes();
		$this -> assertTrue(isset($this -> router -> routes['default']));
	}

	function testMatchRoute() {
		$return = $this -> router -> run('hello');
		$this -> assertEquals($return, array('controller' => 'hello', 'action' => 'index'));
	}
}

?>
