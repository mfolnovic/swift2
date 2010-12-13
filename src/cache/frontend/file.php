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
	/**
	 * Used for storing caching keys
	 */
	var $stack   = array();
	/**
	 * Used for storing all caches
	 */
	var $storage = array();

	/**
	 * Starts frontend caching
	 *
	 * @access public
	 * @param  string $key Key
	 * @return void
	 */
	public function start($key) {
		ob_start();

		$this -> stack[] = $key;
	}

	/**
	 * End frontend caching and stores content in the storage
	 *
	 * @access public
	 * @return string
	 */
	public function end() {
		return $this -> storage[array_pop($this -> stack)] = ob_get_clean();
	}
}

?>
