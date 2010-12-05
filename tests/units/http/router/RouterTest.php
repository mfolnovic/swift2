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

	/**
	 * @dataProvider GetMatchRouteProvider
	 */
	public function testMatchRouter($url, $match) {
		$return = $this -> router  -> run($url);

		$this -> assertEquals($return, $match);
	}

	/**
	 * @codeCoverageIgnore
	 */
	public function GetMatchRouteProvider() {
		return array(
			array('/', array('controller' => 'foo', 'action' => 'bar')),
			array('hello', array('controller' => 'hello', 'action' => 'bar')),
			array('hello/world', array('controller' => 'hello', 'action' => 'world')),
			array('hello/world/1', array('controller' => 'hello', 'action' => 'world', 'id' => 1)),
			array('hello/world/1.xml', array('controller' => 'hello', 'action' => 'world', 'id' => 1, 'format' => 'xml')),
			array('bar', array('controller' => 'bar', 'action' => 'bar')),
			array('bar.json', array('controller' => 'bar', 'action' => 'bar', 'format' => 'json')),
			array('bar/show.rss', array('controller' => 'bar', 'action' => 'show', 'format' => 'rss')),
			array('archive/2009/11', array('controller' => 'archive', 'action' => 'index', 'month' => '11', 'year' => '2009'))
		);
	}
}

?>
