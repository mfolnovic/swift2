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
use Loader\Loader;

/**
 * Controller class is used for running controllers (part of MVC)
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Controller
 */

class Controller {
	function __construct(Request &$request, Response &$response) {
		$controller = $request -> get -> controller;
		$action     = $request -> get -> action;

		$class_name = ucfirst($controller) . 'Controller';
		Loader::load('controller', $class_name);

		$class_name = 'Application\\Controllers\\' . $class_name;
		$instance = new $class_name($request, $response);

		$arguments = $this -> prepareArguments($instance, $action, $request, $response);
		call_user_func_array(array($class_name, $action), $arguments);
	}

	public function prepareArguments($instance, $action, &$request, &$response) {
		$reflection = new \ReflectionMethod($instance, $action);
		$params     = $reflection -> getParameters();
		$return     = array();

		foreach($params as $param) {
			if($request -> get -> exists($param -> name)) {
				$return[$param -> name] =& $request -> get -> knapsack[$param -> name];
			} else if($param -> name == 'request') {
				$return[$param -> name] =& $request;
			} else if($param -> name == 'response') {
				$return[$param -> name] =& $response;
			} else {
				$return[$param -> name] = $param -> getDefaultValue();
			}
		}

		return $return;
	}
}

?>
