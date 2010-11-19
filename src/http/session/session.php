<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\HTTP\Session;

/**
 * This class is used for manipulating sessions
 *
 * @author     Matija Folnovic <matijafolnovic@gmail.com>
 * @package    Swift
 * @subpackage HTTP
 */

class Session {
	/**
	 * Session storage
	 * Mysql, Native etc.
	 */
	var $storage;
	/**
	 * Updated properties
	 */
	var $properties;
	/**
	 * Options from configuration file
	 */
	var $options;

	/**
	 * Constructor
	 *
	 * @access public
	 * @param  string $options Options
	 * @return void
	 * @todo   Import current session data
	 */
	public function __construct($options = array()) {
		$this -> options = array_merge(array('type' => 'native'), $options);
	}

	/**
	 * Destructor
	 * Writes data to session storage
	 *
	 * @access public
	 * @param  string $index Index
	 * @return mixed
	 */
	public function __destruct() {
		if(empty($this -> properties)) {
			return;
		}

		if(empty($this -> storage)) {
			$this -> start();
		}

		$this -> storage -> write(array(
																		'_session' => &$this -> properties,
		));
	}

	/**
	 * Starts session
	 * Initializes session storage too
	 
	 * @access public
	 * @return void
	 */
	public function start() {
		$type            = 'HTTP\Session\Adapters\\' . ucfirst($this -> options['type']);
		$this -> storage = new $type($this -> options);
	}

	/**
	 * Gets property from session storage
	 *
	 * @access public
	 * @param  string $index Index
	 * @return mixed
	 */
	public function get($index) {
		return $this -> properties[$index];
	}

	/**
	 * Set property from session storage with index $index to value $value
	 *
	 * @access public
	 * @param  string $index Index
	 * @param  mixed  $value New value
	 * @return void
	 */
	public function set($index, $value) {
		$this -> properties[$index] = $value;
	}

	/**
	 * Returns TRUE if property with index $index exists in session storage
	 *
	 * @access public
	 * @param  string $index Index
	 * @return bool
	 */
	public function exists($index) {
		return isset($this -> properties[$index]);
	}
}

?>
