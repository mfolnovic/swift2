<?php

use HTTP\Router\Router;

class RouterTest extends \PHPUnit_Framework_TestCase {
	var $router;

	function setUp() {
		$this -> router = new Router();
	}

	function testLoadRoutes() {
		$this -> router -> loadRoutes(__DIR__ . '/fixtures/routes.yml');
		$this -> assertTrue(isset($this -> router -> routes['default']));
		var_dump($this -> router -> routes);
	}

	function testMatchRoute() {
		$this -> router -> loadRoutes(__DIR__ . '/fixtures/routes.yml');
		$return = $this -> router -> run('hello');
		$this -> assertEquals($return, array('controller' => 'hello', 'action' => 'index'));
	}
}

?>
