<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace HTTP\Router;

/**
 * This class represents one route, and is used for compiling it
 * in format that's easier to understand to Router
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage HTTP
 */

class Route {
	/**
	 * Route data
	 */
	var $route;
	/**
	 * Compiled route
	 */
	var $compiled = array();

	/**
	 * Constructor
	 *
	 * @access public
	 * @param  array $route Route data
	 * @return void
	 */
	public function __construct($route) {
		$this -> route = $route;
	}

	/**
	 * Compiles route to more understanding form
	 *
	 * @access public
	 * @return array
	 */
	public function &compile() {
		if(empty($this -> compiled)) {
			$path     =  $this -> route['pattern'];
			$compiled =& $this -> compiled;

			preg_match_all("/[(]|[)]|[^\(\)]+/", $path, $parts);
			foreach($parts[0] as $part) {
				if($part == ')') {
					$push = array();
					while(($current = array_pop($compiled)) != '(') {
						$push[] = $current;
					}
					$compiled[] = array_reverse($push);
				} else {
					$compiled[] = $part;
				}
			}
		}

		return $compiled;
	}
}

?>
