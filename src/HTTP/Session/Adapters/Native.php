<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace HTTP\Session\Adapters;

/**
 * This class is used for manipulating sessions
 *
 * @author     Matija Folnovic <matijafolnovic@gmail.com>
 * @package    Swift
 * @subpackage HTTP
 */

class Native {
	public function __construct() {
		session_start();
	}

	public function write($properties) {
		foreach($properties as $index => &$value) {
			$_SESSION[$index] = $value;
		}
	}
}

?>
