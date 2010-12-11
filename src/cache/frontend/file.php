<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\Cache\Frontend;

/**
 * Frontend cache class - files
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Cache
 */
class File {
	var $stack   = array();
	var $storage = array();

	public function start($key) {
		ob_start();

		$this -> stack[] = $key;
	}

	public function end() {
		$key                   = array_pop($this -> stack);
		return $this -> storage[$key] = ob_get_clean();
	}
}

?>
