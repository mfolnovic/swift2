<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\Utilities;

/**
 * Knapsack
 *
 * Knapsack is used for storing some data
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Utilities
 */

class Knapsack {
	/**
	 * Knapsack's data is stored here
	 */
	var $knapsack = array();

	/**
	 * Constructor
	 *
	 * @access public
	 * @param  array $data Knapsack's data
	 * @return void
	 */
	function __construct($data = array()) {
		foreach((array)$data as $id => $value) {
			$this -> knapsack[strtolower($id)] = $value;
		}
	}

	/**
	 * Gets element from knapsack with index $index
	 *
	 * @access public
	 * @param  string $index Index from Knapsack
	 * @return mixed
	 */
	function get($index) {
		return $this -> exists($index) ? $this -> knapsack[strtolower($index)] : null;
	}

	/**
	 * Magic method for get
	 *
	 * @access public
	 * @param  string $index Index from Knapsack
	 * @return mixed
	 */
	function __get($index) {
		return $this -> get($index);
	}

	/**
	 * Sets element in Knapsack with index $index to value $value
	 *
	 * @access public
	 * @param  string $index Index from Knapsack
	 * @param  mixed  $value New value for element with index $index in Knapsack
	 * @return mixed
	 */
	function set($index, $value) {
		return $this -> knapsack[strtolower($index)] = $value;
	}

	/**
	 * Magic method for set
	 *
	 * @access public
	 * @param  string $index Index from Knapsack
	 * @param  mixed  $value New value for element with index $index in Knapsack
	 * @return mixed
	 */
	function __set($index, $value) {
		$this -> set($index, $value);
	}

	/**
	 * Returns TRUE if element with index $index exists in Knapsack
	 *
	 * @access public
	 * @param  string $index Index from Knapsack
	 * @return mixed
	 */
	function exists($index) {
		return isset($this -> knapsack[strtolower($index)]);
	}

	/**
	 * Magic method for isset
	 *
	 * @access public
	 * @param  string $index Index from Knapsack
	 * @return mixed
	 */
	function __isset($index) {
		return $this -> exists($index);
	}
}

?>
