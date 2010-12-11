<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\HTTP\Response;

class Response {
	/**
	 * Current template to render
	 */
	var $template;
	/**
	 * Current layout
	 */
	var $layout  = 'application';
	/**
	 * Storage used for storing outputs from templates
	 */
	var $storage = array();
	/**
	 * HTTP Status Code
	 */
	private $code = 200;

	/**
	 * Runs template $template with $data and stores output in storage under $name
	 *
	 * @param  string $template Run template $template
	 * @param  array  $data     Data passed to template
	 * @param  string $storage  Store output under $storage name
	 * @return string
	 * @todo   Support for multiple template parsers
	 */
	public function &runTemplate($template, &$data, $storage) {
		ob_start();

		$object   = new Adapters\Haml\Haml(APP_DIR . 'views/' . $template . '.haml', APP_DIR . 'tmp/views/' . $template . '.php');
		$this -> loadHelpers(APP_DIR . 'helpers/', __DIR__ . '/helpers/');
		$object -> instance -> display($data, $this);

		$this -> storage[$storage] = ob_get_clean();
		return $this -> storage[$storage];
	}

	/**
	 * Runs template passed from Controller
	 *
	 * @param  array $data Data passed to template
	 * @return void
	 */
	public function render(&$data) {
		$this -> runTemplate($this -> template, $data, 'template');
	}

	/**
	 * Runs layout
	 *
	 * @param  array $data Data passed to layout
	 * @return void
	 */
	public function renderLayout(&$data) {
		echo $this -> runTemplate('layouts/' . $this -> layout, $data, 'layout');
	}

	/**
	 * Loads all helpers from $dir
	 *
	 * @access public
	 * @param  string $dir Directory where helpers are
	 * @return void
	 * @todo   Benchmark DirectoryIterator
	 * @todo   Cache it somehow, so we can avoid loading all helpers
	 */
	public function loadHelpers() {
		foreach(func_get_args() as $dir) {
			$iterator = new \DirectoryIterator($dir);

			foreach($iterator as $file) {
				if($file -> isFile()) {
					include $file -> getPathname();
				}
			}
		}
	}

	/**
	 * Returns current HTTP Status Code
	 *
	 * @access public
	 * @return int
	 */
	public function getStatusCode() {
		return $this -> code;
	}

	/**
	 * Changes HTTP Status Code to $code
	 *
	 * @access public
	 * @param  int $code New HTTP Status Code
	 * @return void
	 */
	public function setStatusCode($code) {
		$this -> code = (int)$code;
	}
}


?>
