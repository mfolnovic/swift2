<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Utilities;

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
	var $knapsack = array();

	function __construct($data = array()) {
		$this -> knapsack = (array)$data;
	}

	function get($index) {
		return $this -> knapsack[$index];
	}

	function __get($index) {
		return $this -> get($index);
	}

	function set($index, $value) {
		return $this -> knapsack[$index] = $value;
	}

	function __set($index, $value) {
		$this -> set($index, $value);
	}

	function isset($index) {
		return isset($this- > knapsack[$index]);
	}

	function __isset($index) {
		return $this -> isset($index);
	}
}

?>
