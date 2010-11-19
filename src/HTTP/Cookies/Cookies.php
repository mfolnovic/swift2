<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace HTTP\Cookies;

use Utilities\Knapsack;

/**
 * This class is used for handling cookies
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage HTTP
 */

class Cookies {
	/**
	 * Gets cokie value with index $index
	 *
	 * @access public
	 * @param  string $index Index of cookie
	 * @return mixed
	 */
	public function get($index) {
		return $_COOKIE[$index];
	}

	/**
	 * Sets cookie value with index $index to value $value
	 * Also, can make value expire in $ttl seconds (if $ttl > 0)
	 *
	 * @access public
	 * @param  string $index Index of cookie
	 * @param  mixed  $value New value of cookie
	 * @param  int    $ttl   The time cookie expires (in seconds).
	 * @return void
	 * @todo   Support $ttl
	 */
	public function set($index, $value, $ttl = 0) {
		$_COOKIE[$index] = $value;
	}

	/**
	 * Deletes cookie with index $index
	 *
	 * @access public
	 * @param  string $index Index of cookie
	 * @return void
	 */
	public function delete($index) {
		unset($_COOKIE[$index]);
	}
}

?>
