<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

class Loader {
	var $namespaces = array();

	function __construct() {
		spl_autoload_register(array($this, 'load'));
	}

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

	public function addNamespace($type, $directory) {
		if(!isset($this -> namespaces[$type])) {
			$this -> namespaces[$type] = array();
		}

		$this -> namespaces[$type][] = realpath($directory);
	}
}

?>
