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
		$content  = file_get_contents($file);
		$lexer    = new Lexer();
		$parsed   = $lexer -> parse($content);
		$compiler = new Compiler($parsed, $compile);
		$name = "\Application\Templates\\" . $compiler -> hash;
		$this -> instance = new $name;
	}

	public function run($data, $response) {
		$this -> instance -> display($data, $response);
	}
}


?>
