<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace HTTP\Request;

use Utilities\Knapsack as Knapsack;

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
	public function __construct($get = array(), $post = array(), $cookies = array(), $files = array(), $server = array()) {
		$this -> get     = new Knapsack($get);
		$this -> post    = new Knapsack($post);
		$this -> cookies = new Knapsack($cookies);
		$this -> files   = new Knapsack($files);
		$this -> server  = new Knapsack($server);
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
}

?>
