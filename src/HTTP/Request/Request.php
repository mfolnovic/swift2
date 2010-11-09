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

/**
 * Request represents a HTTP request.
 *
 * @author     Matija Folnovic <matijafolnovic@gmail.com>
 * @package    Swift
 * @subpackage HTTP
 */

class Request {
	public $get;
	public $post;
	public $cookies;

	private $url;
	private $code = 200;

	public function __construct($get = array(), $post = array(), $cookies = array(), $files = array()) {
		$this -> get = $get;
		$this -> post = $post;
		$this -> cookies = $cookies;
		$this -> files = $files;
	}

	public function getStatusCode() {
		return $this -> code;
	}

	public function setStatusCode($code) {
		$this -> code = (int)$code;
	}
}

?>
