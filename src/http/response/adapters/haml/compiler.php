<?php

/**
 * Swift
 *
 * @author    Matija Folnovic
 * @copyright Copyright (c), Matija Folnovic <matijafolnovic@gmail.com>
 * @license   GPLv3
 * @package   Swift
 */

namespace Swift\HTTP\Response\Adapters\Haml;

class Compiler {
	private $closing  = array('area', 'base', 'br', 'col', 'hr', 'img', 'input', 'link', 'meta', 'param');
	private $blocks = array('foreach', 'if', 'else', 'for', 'while');

	function __construct(State $tree, $path, $hash) {
		$content      = "<?php\nnamespace Application\Templates;\nclass $hash{\n\tfunction display(\$data, \$response) {global \$response;\n";

		$content .= $this -> compile($tree, "\t\t");

		$content .= "\t}\n}\n?>";

		if(!is_writeable($path)) {
			mkdir(dirname($path), 0777, true);
		}

		file_put_contents($path, $content);

		include $path;
	}

	public function compile($node, $tab) {
		$tag    = $node -> getTag();
		$return = '';
		$block  = false;

		if($node -> tab >= 0 && !empty($tag)) {
			$return .= "{$tab}echo '<$tag";

			foreach($node -> attributes as $name => $value) {
				if($value[0] == '[') {
					$value = "' . implode(' ', array(" . substr($value, 1, -1) . ") ) . '";
				} else if($value[0] == '$') {
					$value = "' . $value . '";
				} else {
					$value = $this -> phpContent($value);
				}

				$return .= " $name=\"$value\"";
			}

			$return .= '>' . ($this -> phpContent($node -> html)) . "';\n";

			if($node -> command !== false) {
				$block = $this -> isBlock($node -> command);
				$return .= $tab . $this -> phpContent($node -> command) . ($block ? " { " : ";") .  "\n";
			}
		}

		foreach($node -> children as $child) {
			$return .= $this -> compile($child, $tab . ($block ? "\t" : ""));
		}

		if($node -> tab >= 0 && !empty($tag)) {
			if($block) {
				$return .= "{$tab}}\n";
			} else if(!in_array($tag, $this -> closing)) {
				$return .= "{$tab}echo '</$tag>';\n";
			}
		}

		return $return;
	}

	public function phpContent($content) {
		$content = preg_replace("/(\\\$)([a-zA-Z]*)/", '($data[\'${2}\'])', $content);
		return preg_replace("/(#{)(.*)(})/", '\' . ${2} . \'', $content);
	}


	public function isBlock($command) {
		$word = array();
		preg_match("/[A-Za-z0-9_]*/", $command, $word);
		return in_array($word[0], $this -> blocks);
	}
}

?>
