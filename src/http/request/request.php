<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\HTTP\Request;

use Swift\Utilities\Knapsack as Knapsack;
use Swift\HTTP\Router\Router as Router;
use Swift\HTTP\Cookies\Cookies as Cookies;
use Swift\HTTP\Session\Session as Session;

/**
 * Request represents a HTTP request.
 *
 * @author     Matija Folnovic <matijafolnovic@gmail.com>
 * @package    Swift
 * @subpackage HTTP
 */

class Request {
	/**
	 * $_GET
	 */
	public $get;
	/**
	 * $_POST
	 */
	public $post;
	/**
	 * $_COOKIES
	 */
	public $cookies;
	/**
	 * $_FILES
	 */
	public $files;
	/**
	 * $_SERVER
	 */
	public $server;
	public $controller_data = array();

	/**
	 * Constructor
	 *
	 * @access public
	 * @param  array $get     $_GET
	 * @param  array $post    $_POST
	 * @param  array $cookies $_COOKIES
	 * @param  array $files   $_FILES
	 * @param  array $server  $_SERVER
	 * @return void
	 */
	public function __construct($get = null, $post = null, $cookies = null, $files = null, $server = null) {
		$this -> get     = new Knapsack($get ?: $_GET);
		$this -> post    = new Knapsack($post ?: $_POST);
		$this -> files   = new Knapsack($files ?: $_FILES);
		$this -> server  = new Knapsack($server ?: $_SERVER);
		$this -> cookies = new Cookies();
		$this -> session = new Session();

		$headers = array();
		foreach($this -> server -> knapsack as $index => $value) {
			if(substr($index, 0, 5) === 'HTTP_') {
				$headers[substr($index, 5)] = $value;
			}
		}

		$this -> headers = new Knapsack($headers);

		$router = new Router;
		$data = $router -> run($this -> getRequestUrl());
		$this -> get -> knapsack = array_merge($this -> get -> knapsack, $data);
	}

	/**
	 * Returns request method, e.g. GET, POST, DELETE, PUT
	 *
	 * @access public
	 * @return string
	 */
	public function getMethod() {
		return strtoupper($this -> get -> method) ?: $this -> server -> request_method;
	}

	/**
	 * Redirection
	 *
	 * @access public
	 * @param  string $url Redirect to $url
	 * @return void
	 */
	public function redirectTo($url) {
		header("Location: $url");
	}

	/**
	 * Returns Request's URL
	 *
	 * @access public
	 * @return string
	 */
	public function getUrl() {
		if(isset($this -> server -> request_uri)) {
			return $this -> server -> request_uri;
		} else {
			/** Root */
			return '/';
		}
	}

	/**
	 * Separates real request url from $_SERVER's request url
	 * 
	 * E.g. request is http://localhost/your_project/hello/world
	 * This method will get hello/world (if your project lies in www_root/your_project/)
	 *
	 * @access public
	 * @return string
	 */
	public function getRequestUrl() {
		$url  = $this -> getUrl();
		if(empty($url)) return '/';
		$self = $this -> server -> script_name;
		$pos  = 0;
		$n    = (strpos($url, '?') ?: strlen($url)) - 1;

		while(isset($url[$pos]) && isset($self[$pos]) && $url[$pos] == $self[$pos]) {
			++ $pos;
		}

		while($url[$n] == '/' && $n > $pos) $n --;
		return substr($url, $pos, $n - $pos + 1) ?: '/';
	}
}

?>
