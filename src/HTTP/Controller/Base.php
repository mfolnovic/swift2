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
	var $request;
	var $response;

	function __construct(Request $request, Response $response) {
		$this -> request  = $request;
		$this -> response = $response;
	}
}

?>
