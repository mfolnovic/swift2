<?php

namespace Swift\Config;

/**
 * This class is used for loading configuration files
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Config
 */
class Config {
	static $loaded = NULL;

	static function &get($index) {
		if(empty(self::$loaded)) {
			self::init();
		}

		$ret     =& self::$loaded;
		$indices =  explode('.', $index);

		foreach($indices as $index) {
			if(!isset($ret[$index])) {
				return NULL;
			}

			$ret =& $ret[$index];
		}

		return $ret;
	}

	static function init() {
		$ret =& self::$loaded;

		/** Load application configuration */
		$ret = self::loadFromFile(APP_DIR . 'config/application.yml');
	}

	static function loadFromFile($file) {
		return yaml_parse_file($file);
	}

	static function injectConfiguration($config) {
		self::$loaded = $config;
	}
}


?>
