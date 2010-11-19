<?php

use HTTP\Router\Route as Route;

class RouteTest extends \PHPUnit_Framework_TestCase {
	function testCompile() {
		$route = new Route(array('pattern' => ':controller(/:action(/:id))(.format)'));

		$compiled = $route -> compile();
		$this -> assertEquals($compiled, array(':controller', array('/:action', array('/:id')), array('.format')));
	}
}

?>
