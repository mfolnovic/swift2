<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

/**
 * HAML parser
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage HAML
 */

namespace Swift\HTTP\Response\Adapters\Haml;

/**
 * Haml parser
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Haml
 */
class Haml {
	var $instance;

	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct($file, $compile) {
		$hash = $this -> getHash($file);

		if(filemtime($file) < filemtime($compile)) {
			include $compile;
		} else {
			$content  = file_get_contents($file);
			$lexer    = new Lexer();
			$parsed   = $lexer -> parse($content);
			$compiler = new Compiler($parsed, $compile, $hash);
		}

		$name = "\Application\Templates\\" . $hash;
		$this -> instance = new $name;
	}

	public function run($data, $response) {
		$this -> instance -> display($data, $response);
	}

	public function getHash($path) {
		return substr(preg_replace("/[0-9]/", '', md5($path)), 0, 6);
	}
}


?>
