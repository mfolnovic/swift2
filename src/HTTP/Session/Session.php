<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace HTTP\Session;

use HTTP\Session\Adapters;

/**
 * This class is used for manipulating sessions
 *
 * @author     Matija Folnovic <matijafolnovic@gmail.com>
 * @package    Swift
 * @subpackage HTTP
 */

class Session {
	var $storage;
	var $properties;
	var $options;

	public function __construct($options) {
		$this -> options = $options;
	}

	public function start() {
		$type            = 'HTTP\Session\Adapters\\' . ucfirst($this -> options['type']);
		$this -> storage = new $type($this -> options);
	}

	public function get($index) {
		return $this -> properties[$index];
	}

	public function set($index, $value) {
		$this -> properties[$index] = $value;
	}

	public function exists($index) {
		return isset($this -> properties[$index]);
	}

	public function __destruct() {
		if(empty($this -> storage)) {
			$this -> start();
		}

		$this -> storage -> write(array(
																		'_session' => &$this -> properties,
		));
	}
}

?>
