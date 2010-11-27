<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\HTTP\Controller;

use Swift\HTTP\Request\Request;
use Swift\HTTP\Response\Response;

/**
 * This is base controller which is inherited by all other controllers
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Controller
 */

class Base {
	/**
	 * Request instance
	 */
	private $request;
	/**
	 * Response instance
	 */
	private $response;

	/**
	 * Constructor
	 *
	 * @access public
	 * @param  object $request  Request instance
	 * @param  object $response Response instance
	 * @return return
	 */
	function __construct(Request $request, Response $response) {
		$this -> request  = $request;
		$this -> response = $response;
	}

	/**
	 * Shortcut function to get controller name of current request
	 *
	 * @access public
	 * @return string
	 */
	public function controller_name() {
		return $this -> request -> get -> controller;
	}

	/**
	 * Shortcut function to get action name of current request
	 *
	 * @access public
	 * @return string
	 */
	public function action_name() {
		return $this -> request -> get -> action;
	}

	/**
	 * Shortcut function to redirect
	 *
	 * @access public
	 * @param  string $url Redirect to $url
	 * @return void
	 */
	public function redirect_to($url) {
		$this -> request -> redirectTo($url);
	}

	/**
	 * Sets template which should be rendered to $template
	 *
	 * @access public
	 * @param  string $template New template to render
	 * @return return
	 */
	public function render($template) {
		$this -> response -> template = $template;
	}

	public function &__get($index) {
		return isset($this -> request -> controller_data[$index]) ? $this -> request -> controller_data[$index] : NULL;
	}

	public function __set($index, $value) {
		$this -> request -> controller_data[$index] = $value;
	}

	public function __isset($index) {
		return isset($this -> request -> controller_data[$index]);
	}
}

?>
