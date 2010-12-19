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

class Filters {
	/**
	 * This is used for storing filters
	 *
	 * @access private
	 */
	private $filters = array('before' => array(), 'after' => array());

	/**
	 * Used for adding before filter
	 *
	 * @access public
	 * @param  string $func1, $func2,... List of functions
	 * @param  array  $options           Options, for example, except and only
	 * @return void
	 */
	public function beforeFilter() {
		$this -> add(func_get_args(), 'before');
	}

	/**
	 * Used for adding after filter
	 *
	 * @access public
	 * @param  string $func1, $func2,... List of functions
	 * @param  array  $options           Options, for example, except and only
	 * @return void
	 */
	public function afterFilter() {
		$this -> add(func_get_args(), 'after');
	}

	/**
	 * Called when adding before and after filter
	 *
	 * @access private
	 * @param  array $arguments List of functions
	 * @param  array $type      Type of filter, can be before and after
	 * @return void
	 */
	private function add($arguments, $type) {
		$options = $this -> getOptions($arguments);

		$this -> filters[$type][] = array('arguments' => $arguments, 'options' => $options);
	}

	/**
	 * With passed arguments, checks if last element is array
	 * If it is, it assumes those should be options, so it divides it from arguments
	 *
	 * @access private
	 * @param  array $arguments Passed arguments
	 * @return array Options
	 */
	private function getOptions(&$arguments) {
		if(is_array(end($arguments))) {
			return array_pop($arguments);
		} else {
			return array();
		}
	}

	/**
	 * Goes through all filters of type $type and all filters it should call
	 *
	 * @access private
	 * @param  string $type   Type of filter
	 * @param  string $action Action name
	 * @return void
	 */
	private function call($type, $action) {
		foreach($this -> filters[$type] as $filter) {
			$only   = $filter['options']['only'] ?: array();
			$except = $filter['options']['except'] ?: array();
			if(in_array($action, $only) && !in_array($action, $except)) {
				$this -> $action();
			}
		}
	}
}

?>
