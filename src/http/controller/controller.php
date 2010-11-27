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
use Swift\Loader\Loader;

/**
 * Controller class is used for running controllers (part of MVC)
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Controller
 */

class Controller {
	/**
	 * Constructor
	 * Get's controller and action name from $request, prepares arguments,
	 * create new instance of app's controller and calls specific method.
	 *
	 * @access public
	 * @param  object $request  Instance of Request
	 * @param  object $response Instance of Response
	 * @return void
	 */
	public function __construct(Request &$request, Response &$response) {
		$controller = $request -> get -> controller;
		$action     = $request -> get -> action;

		$response -> template = $controller . '/' . $action;

		$class_name = 'Application\\Controllers\\' . ucfirst($controller) . 'Controller';
		Loader::load($class_name);
		$instance = new $class_name($request, $response);

		$arguments = $this -> prepareArguments($instance, $action, $request, $response);
		call_user_func_array(array($instance, $action), $arguments);

		$response -> render($request -> controller_data);
	}

	/**
	 * Takes argument list of method $method from class instance $instance
	 * and creates array which would be perfect to call that method with.
	 * e.g. let's say we have method (in class UsersController):
	 * function edit($id, $user, $request, $response)
	 * and let's say we request it with:
	 * /users/show/1
	 * $id would get value 1, $user would be index 'user' from $_POST
	 * $request would be instance of Request, and $response would be
	 * instance of Response
	 *
	 * @access public
	 * @param  object $instance Instance
	 * @param  string $method   Method name
	 * @param  object $request  Instance of Request
	 * @param  object $response Instance of Response
	 * @return array
	 */
	public function prepareArguments($instance, $method, &$request, &$response) {
		$reflection = new \ReflectionMethod($instance, $method);
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
