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
	var $template;
	var $layout = 'application';

	function __construct() {
		$this -> loadHelpers(APP_DIR . 'helpers/', __DIR__ . '/helpers/');
	}

	public function runTemplate($template, $data = array()) {
		$object   = new Adapters\Haml\Haml(APP_DIR . 'views/' . $template . '.haml', APP_DIR . 'tmp/views/' . $template . '.php');
		$object -> run($data);
	}

	public function render($data) {
		$this -> runTemplate($this -> template, $data);
	}

	public function renderLayout($data) {
		$this -> runTemplate('layouts/' . $this -> layout, $data);
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
}


?>
