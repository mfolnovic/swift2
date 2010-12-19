<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\Loader;

/**
 * Loader class
 *
 * This class is used for loading all libraries, controllers etc.
 * Also, it's used for autoloading
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Loader
 */

class Loader {
	/**
	 * Namespaces (type => directories)
	 */
	static $namespaces = array();

	/**
	 * Used for loading classes
	 *
	 * @param string $type         Type (src,controller etc.)
	 * @param string $library1,... Library
	 * @return void
	 */
	public static function load() {
		$libraries = func_get_args();
		foreach($libraries as $library) {
			$pos       = strpos($library, '\\');
			$namespace = substr($library, 0, $pos);
			$library   = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', strtr(substr($library, $pos + 1), '\\', '/')));

			foreach(self::$namespaces[$namespace] as $directory) {
				$dir = $directory . '/' . $library . '.php';
				include $dir;
			}
		}
	}

	/**
	 * Adds directory $directory to namespace $namespace
	 *
	 * @access public
	 * @param  string $name description
	 * @return return
	 */
	public function addNamespace($namespace, $directory) {
		if(!isset(self::$namespaces[$namespace])) {
			self::$namespaces[$namespace] = array();
		}

		self::$namespaces[$namespace][] = realpath($directory);
	}
}

spl_autoload_register('Swift\Loader\Loader::load');

?>
