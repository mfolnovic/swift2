<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\Cache;

use Swift\Config\Config;

/**
 * Cache class
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Cache
 */
class Cache {
	/**
	 * Instance of Frontend Cache
	 */
	static $frontend = NULL;
	/**
	 * Instance of Backend Cache (apc, memcache etc.)
	 */
	static $backend  = NULL;
	/**
	 * Configuration for Cache
	 */
	static $config   = NULL;

	/**
	 * Gets configuration for Cache
	 *
	 * @access private
	 * @static
	 * @return array
	 */
	private static function &getConfig() {
		if(empty(self::$config)) {
			self::$config = Config::get('cache');
		}

		return self::$config;
	}

	/**
	 * Gets Frontend instance
	 *
	 * @access public
	 * @static
	 * @return object
	 */
	public static function &getFrontend($config = NULL) {
		if(!$config) {
			$config = self::getConfig();
			$config = isset($config['frontend']) ? $config['frontend'] : array();
		}

		if(empty(self::$frontend)) {
			$frontend = 'Swift\\Cache\\Frontend\\File';
			self::$frontend = new $frontend($config);
		}

		return self::$frontend;
	}

	/**
	 * Gets Backend instance
	 *
	 * @access public
	 * @static
	 * @return object
	 */
	public static function &getBackend($config = NULL) {
		if(!$config) {
			$config = self::getConfig();
			$config = isset($config['backend']) ? $config['backend'] : array();
		}

		if(empty(self::$backend)) {
			$backend = 'Swift\\Cache\\Backend\\' . $config['adapter'];
			self::$backend = new $backend($config);
		}

		return self::$backend;
	}
}

?>
