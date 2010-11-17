<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace HTTP\Controller;

use HTTP\Request\Request;
use HTTP\Response\Response;

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
	var $request;
	/**
	 * Response instance
	 */
	var $response;

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
}

?>
