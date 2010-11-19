<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\HTTP\Session\Adapters;

/**
 * This class is used for manipulating sessions natively
 *
 * @author     Matija Folnovic <matijafolnovic@gmail.com>
 * @package    Swift
 * @subpackage HTTP
 */

class Native {
	/**
	 * Constructor
	 * Starts native session
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		session_start();
	}

	/**
	 * Writes $properties to session
	 *
	 * @access public
	 * @param  string $properties Properties to write
	 * @return void
	 */
	public function write($properties) {
		foreach($properties as $index => &$value) {
			$_SESSION[$index] = $value;
		}
	}
}

?>
