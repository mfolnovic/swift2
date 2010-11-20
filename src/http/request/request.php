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
	/**
	 * HTTP Status Code
	 */
	private $code = 200;

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
		$this -> get     = new Knapsack($get === null ? $_GET : $get);
		$this -> post    = new Knapsack($post === null ? $_POST : $post);
		$this -> files   = new Knapsack($files === null ? $_FILES : $files);
		$this -> server  = new Knapsack($server === null ? $_SERVER : $server);
		$this -> cookies = new Cookies();
		$this -> session = new Session();

		$router = new Router;
		$data = $router -> run($this -> getRequestUrl());
		$this -> get -> knapsack = array_merge($this -> get -> knapsack, $data);
	}

	/**
	 * Returns current HTTP Status Code
	 *
	 * @access public
	 * @return int
	 */
	public function getStatusCode() {
		return $this -> code;
	}

	/**
	 * Changes HTTP Status Code to $code
	 *
	 * @access public
	 * @param  int $code New HTTP Status Code
	 * @return void
	 */
	public function setStatusCode($code) {
		$this -> code = (int)$code;
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
		$n    = strlen($url) - 1;

		while(isset($url[$pos]) && isset($self[$pos]) && $url[$pos] == $self[$pos]) {
			++ $pos;
		}

		while($url[$n] == '/' && $n > $pos) $n --;
		return substr($url, $pos, $n - $pos + 1) ?: '/';
	}
}

?>
