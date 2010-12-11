<?php

use Swift\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider getGetProvider
	 */
	public function testGet($search, $value) {
		$this -> assertEquals(Config::get($search), $value);
	}

	/**
	 * @codeCoverageIgnore
	 */
	public function getGetProvider() {
		return array(
			array('cache.backend.adapter', 'apc'),
			array('cache', array('backend' => array('adapter' => 'apc'))),
			array('database.default.adapter', 'mysql'),
			array('database.default.hostname', 'localhost'),
			array('application.locale', 'en'),
			array('application.timezone', 'GMT+1'),
		);
	}
}

?>
