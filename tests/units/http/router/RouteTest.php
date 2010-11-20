<?php

use Swift\HTTP\Router\Route;

class RouteTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider GetCompileProvider
	 */
	function testCompile($pattern, $match) {
		$route = new Route(array('pattern' => $pattern));

		$compiled = $route -> compile();
		$this -> assertEquals($compiled, $match);
	}

	/**
	 * @codeCoverageIgnore
	 */
	public function GetCompileProvider() {
		return array(
			array(':controller(/:action(/:id))(.format)', array(':controller', array('/:action', array('/:id')), array('.format')))
		);
	}
}

?>
