<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\Utilities\Compiler;

class Compiler {
	var $content = '';
	var $file;
	var $tab = 1;
	var $blocks = array(
		'foreach' => 'foreach($1 as $$2 => $$3)',
		'if'      => 'if($1)',
		'elseif'  => 'else if($1)',
		'else'    => 'else'
	);

	public function __construct($file = '') {
		$this -> file = $file;
	}

	public function __destruct() {
		if(empty($this -> file)) {
			return;
		}

		$content = "<?php\n{$this -> content}?>" . PHP_EOL;

		file_put_contents($this -> file, $content);
	}

	public function startFunction() {
		$arguments = func_get_args();
		$function  = array_shift($arguments);

		foreach($arguments as &$arg) {
			$arg = "\$" . $arg;
		}

		$arguments = implode(', ', $arguments);

		$this -> pushContent("function $function($arguments) {");
		$this -> tab ++;

		return $this;
	}

	public function endFunction() {
		$this -> tab --;
		$this -> pushContent("}");
	}

	public function __call($function, $arguments) {
		if(isset($this -> blocks[$function])) {
			$content = $this -> blocks[$function];
			foreach($arguments as $id => $val) {
				$content = str_replace('$' . ($id + 1), $val, $content);
			}

			if($function == 'elseif' || $function == 'else') {
				-- $this -> tab;
				$this -> pushContent("}");
			}

			$this -> pushContent($content . " {");
			$this -> tab ++;
		} else if(substr($function, 0, 3) == 'end' && isset($this -> blocks[strtolower(substr($function, 3))])) {
			$this -> tab --;
			$this -> pushContent("}");
		} else {
			$arguments = $this -> compileArguments($arguments);

			$this -> pushContent("$function($arguments);");
		}

		return $this;
	}

	private function compileArguments($arguments) {
		foreach($arguments as &$arg) {
			if(!is_int($arg)) {
				$arg = '"' . $arg . '"';
			}
		}

		return implode(', ', $arguments);
	}

	private function pushContent($content) {
		$this -> content .= str_repeat("\t", $this -> tab) . "$content\n";
	}

	private function compileArray($array) {
		$return = '';

		foreach($array as $id => $val) {
			if(is_array($val)) {
				$val = $this -> compileArray($val);
			} else if(!is_int($val)) {
				$val ="'" . $val . "'"; 
			}

			if(!is_int($id)) {
				$id = "'" . $id . "'";
			}

			if(!empty($return)) {
				$return .= ', ';
			}

			$return .= "$id => $val";
		}

		return "array($return)";
	}
}

?>
