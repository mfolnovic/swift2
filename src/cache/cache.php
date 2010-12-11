<?php

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
	static $frontend = NULL;
	static $backend  = NULL;
	static $config   = NULL;

	static function &getConfig() {
		if(empty(self::$config)) {
			self::$config = Config::get('cache');
		}

		return self::$config;
	}

	static function &getFrontend($config = NULL) {
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

	static function &getBackend($config = NULL) {
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
