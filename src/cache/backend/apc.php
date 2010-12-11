<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\Cache\Backend;

/**
 * APC as backend adapter for cache class
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Cache
 */
class Apc {
	/**
	 * Gets stored variable from APC
	 *
	 * @access public
	 * @param  string $key The key under variable is stored in cache
	 * @return mixed
	 */
	public function get($key) {
		return apc_fetch($key) ?: NULL;
	}

	/**
	 * Sets variable with key $key to value $value in APC
	 *
	 * @access public
	 * @param  string $key   Store variable under this key
	 * @param  mixed  $value The variable to store
	 * @param  int    $ttl   Time to live. Expire cache after $ttl second
	 * @return bool
	 */
	public function set($key, $value, $ttl = 0) {
		return apc_store($key, $value, $ttl);
	}

	/**
	 * Deletes variable with key $key from cache
	 *
	 * @access public
	 * @param  string $key Delete variable with key $Key
	 * @return return
	 */
	public function delete($key) {
		apc_delete($key);
	}

	/**
	 * Tests if variable with key $key exists
	 *
	 * @access public
	 * @param  string $key Check for variable with key $key if it exists
	 * @return return
	 */
	public function exists($key) {
		return apc_exists($key);
	}

	/**
	 * Clears the cache
	 *
	 * @access public
	 * @return void
	 */
	public function clear() {
		apc_clear_cache();
	}
}


?>
