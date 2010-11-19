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
 * This class is used for routing urls to right controllers.
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage HTTP
 */

class Router {
	/**
	 * Collection of routes
	 */
	var $routes        = array();
	/**
	 * Content of routes.yml
	 */
	var $configuration = array();

	/**
	 * Goes through all routes and tries to match each route to $url
	 *
	 * @access public
	 * @param  string $url Url
	 * @return array
	 */
	public function run($url) {
		$this -> loadRoutes();

		foreach($this -> routes as &$route) {
			$compiled = $route -> compile();
			$params   = array();
			$matched  = $this -> matchRoute($compiled, $url, $params) > 0;

			if($matched) {
				$params += $route -> route['default'];
				return $params;
			}
		}

		return array();
	}

	/**
	 * Matches route and current url using compiled route
	 *
	 * @access public
	 * @param  array  $route  Route
	 * @param  string $url    Current URL
	 * @param  array  $params Params taken from the route
	 * @param  int    $taken  Number of characters taken from the $url
	 * @return array
	 */
	public function matchRoute($route, $url, &$params, $taken = 0) {
		if($taken == strlen($url)) {
			return 0;
		}

		$first  = array_shift($route);

		$offset = 0;
		for($len = strlen($first); $offset < $len; ++ $offset) {
			if($first[$offset] == ':') {
				preg_match("/[\w]+/", substr($url, $offset + $taken), $matches);
				preg_match("/[\w]+/", substr($first, $offset), $param);

				if(!empty($matches)) {
					$params[$param[0]] = $matches[0];
					$offset += strlen($matches[0]);
				}

				break;
			} else if($first[$offset] != $url[$taken + $offset]) {
				return 0;
			}
		}

		$return = $offset;

		foreach($route as $part) {
			$return += $this -> matchRoute($part, $url, $params, $taken + $return);
		}

		return $return;
	}

	/**
	 * Loades route from path $path.
	 * If $path is not specified, it'll load from app/config/routes.yml
	 *
	 * @access public
	 * @param  string $path Path from where it should load.
	 * @return void
	 */
	public function loadRoutes($path = '') {
		if(!empty($this -> routes)) {
			return;
		}

		if(empty($path)) {
			$path = APP_DIR . 'config/routes.yml';
		}

		$conf = yaml_parse_file($path);
		foreach($conf as $name => $route) {
			$this -> routes[$name] = new Route($route);
		}
	}
}

?>
