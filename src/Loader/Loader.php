<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Loader;

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
	 * Constructor
	 * Registeres autoloader
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
	}

	/**
	 * Used for loading classes
	 *
	 * @param string $type         Type (src,controller etc.)
	 * @param string $library1,... Library
	 * @return void
	 */
	public static function load() {
		$libraries = func_get_args();
		if(isset(self::$namespaces[reset($libraries)])) {
			$type      = array_shift($libraries);
		} else {
			$type = 'src';
		}

		foreach($libraries as $library) {
			$library = strtr($library, '\\', '/');
			foreach(self::$namespaces[$type] as $directory) {
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

spl_autoload_register('Loader\Loader::load');

?>
