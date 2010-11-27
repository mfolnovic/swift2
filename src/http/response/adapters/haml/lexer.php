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
 * Haml parser - lexer
 *
 * @author     Matija Folnovic
 * @package    Swift
 * @subpackage Haml
 * @todo Escaping HTML &=
 * @todo Unespacing HTML !=
 * @todo Filters:
 *         javascript: <script></script>
 *         css: <style></style>
 *         cdata
 *         php
 *         
 * @todo Multiline |
 * @todo Blocks (for, foreach, if, custom)
 */
class Lexer {
	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	const T_TAB = "\t";
	const T_NEWLINE = "\n";
	const T_TAG = "%";
	const T_ID = "#";
	const T_CLASS = ".";
	const T_PHP_WRITE = "=";
	const T_PHP_RUN = "-";
	const T_ATTRIBUTES_OPEN = "{";
	const T_ATTRIBUTES_CLOSE = "}";

	const T_ATTRIBUTES_KEY = ":";
	const T_ATTRIBUTES_STRING = "=>";

	const REGEX_WORD = '/[A-Za-z0-9_]*/';
	const REGEX_ATTRIBUTE_KEY = "/:(?:[^=>]*)/";
	const REGEX_ATTRIBUTE_VALUE = "/(?:[^,]*)/";
	const REGEX_TAB = "/[\t]*/";
	const REGEX_LINE = "/[^\n]*/";

	public function parse(&$content) {
		$content = "\n" . $content;
		$length  = strlen($content);
		if($content[$length - 1] == "\n") {
			$content = substr($content, 0, -1);
			-- $length;
		}

		$matches = array();
		$root    = new State();
		$root -> setTab(-1);

		for($pos = 0; $pos < $length; ++ $pos) {
			$char = $content[$pos];
			if($char == self::T_NEWLINE) {
				if($pos + 1 == $length) break;
				$tab = array();
				preg_match(self::REGEX_TAB, $content, $tab, 0, $pos+1);
				$tab = $tab[0];
				$pos += empty($tab) ? 0 : strlen($tab);

				$state = new State();
				$state -> setTab($tab);

				while($root -> getTab() >= $state -> getTab()) {
					$root =& $root -> getParent();
				}

				$state = $root -> addChild($state);
				if($state -> getTab() > $root -> getTab()) {
					$root =& $root -> lastChild();
				}
			} else if($char == self::T_TAG) {
				$tag = $this -> getPattern($content, $pos + 1, self::REGEX_WORD);
				$pos += strlen($tag);
				$state -> setTag($tag);
			} else if($char == self::T_CLASS) {
				$class = $this -> getPattern($content, $pos + 1, self::REGEX_WORD);
				$pos   += strlen($class);
				$state -> addClass($class);
			} else if($char == self::T_ID) {
				$id   = $this -> getPattern($content, $pos + 1, self::REGEX_WORD);
				$pos += strlen($id);
				$state -> addId($id);
			} else if($char == self::T_ATTRIBUTES_OPEN) {
				$ending = strpos($content, self::T_ATTRIBUTES_CLOSE, $pos);
				$attrs = substr($content, $pos, $ending - $pos + 1);
				$state -> setAttributes($this -> parseAttributes($attrs));
				$pos = $ending;
			} else if($content[$pos] == self::T_PHP_WRITE || $content[$pos] == self::T_PHP_RUN) {
				$command = $this -> getPattern($content, $pos + 1, self::REGEX_LINE);
				$state -> setCommand(($content[$pos] == self::T_PHP_WRITE ? "echo " : "") . $command);
				$pos += strlen($command);
			} else if($content[$pos] != ' ') {
				$newline = strpos($content, self::T_NEWLINE, $pos) - 1;
				$state -> setHtml(substr($content, $pos, $newline - $pos + 1));
				$pos = $newline;
			}
		}

		while(($root -> getParent()) !== null) {
			$root =& $root -> getParent();
		}

		return $root;
	}

	public function parseAttributes($attributes) {
		$matches = array();
		$return  = array();
		$attributes[strlen($attributes) - 1] = ','; // little trick

		for($i = 0, $length = strlen($attributes); $i < $length; ++ $i ) {
			/** Match key */
			preg_match(self::REGEX_ATTRIBUTE_KEY, $attributes, $matches, 0, $i);
			$index = trim(substr($matches[0], 1));
			$i += strlen($matches[0]) + 3;

			/** Match value */
			while($attributes[$i] == ' ') ++ $i;
			if($attributes[$i] == '"') {
				$char = '"';
			} else if($attributes[$i] == "'") {
				$char = "'";
			} else if($attributes[$i] == '[') {
				$char = ']';
			} else {
				$char = '';
			}

			if(empty($char)) {
				preg_match(self::REGEX_ATTRIBUTE_VALUE, $attributes, $matches, 0, $i);
			} else {
				$matches[0] = substr($attributes, $i + 1, strpos($attributes, $char, $i + 1) - $i - 1);
				if($char == ']') {
					$matches[0] = '[' . $matches[0] . ']';
				}
			}

			$value = $matches[0];
			$i     = strpos($attributes, ',', $i + strlen($value)) ?: -1;

			$return[$index] = $value;
		}

		return $return;
	}

	public function getPattern(&$content, $pos, $pattern) {
		$matches = array();
		preg_match($pattern, $content, $matches, 0, $pos);
		return $matches[0];
	}
}


?>
