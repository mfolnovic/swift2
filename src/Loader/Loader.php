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
	var $namespaces = array();

	/**
	 * Constructor
	 * Registeres autoloader
	 *
	 * @access public
	 * @return void
	 */
	function __construct() {
		spl_autoload_register(array($this, 'load'));
	}

	/**
	 * Used for loading classes
	 *
	 * @param string $type         Type (src,controller etc.)
	 * @param string $library1,... Library
	 * @return void
	 */
	function load() {
		$libraries = func_get_args();
		if(in_array(reset($libraries), $this -> namespaces)) {
			$type      = array_shift($libraries);
		} else {
			$type = 'src';
		}

		foreach($libraries as $library) {
			$library = strtr($library, '\\', '/');
			foreach($this -> namespaces[$type] as $directory) {
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
		if(!isset($this -> namespaces[$namespace])) {
			$this -> namespaces[$namespace] = array();
		}

		$this -> namespaces[$namespace][] = realpath($directory);
	}
}

?>
