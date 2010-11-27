<?php

namespace Swift\HTTP\Response\Adapters\Haml;

class State {
	public $tag        = false;
	public $attributes = array();
	public $command    = false;
	public $tab        = 0;
	public $children   = array();
	public $parent     = null;
	public $html       = '';
	public $sanitaze   = false;

	public function setTab($tab) {
		$this -> tab = $tab;
	}

	public function getTab() {
		return $this -> tab;
	}

	public function getTag() {
		if(empty($this -> tag)) {
			$this -> tag = 'div';
		}

		return $this -> tag;
	}

	public function setTag($tag) {
		$this -> tag = $tag;
	}

	public function setHtml($html) {
		$this -> html = trim($html);
	}

	public function addClass($class) {
		if(isset($this -> attributes['class'])) {
			$this -> attributes['class'] .= ',';
		} else {
			$this -> attributes['class'] = '';
		}

		$this -> attributes['class'] .= $class;
	}

	public function addId($id) {
		if(isset($this -> attributes['id'])) {
			$this -> attributes['id'] .= ',';
		} else {
			$this -> attributes['id'] = '';
		}

		$this -> attributes['id'] .= $id;
	}

	public function setAttributes($attributes) {
		$this -> attributes = $attributes;
	}

	public function setCommand($command) {
		$this -> command = trim($command);
	}

	public function &addChild($state) {
		$state -> setParent($this);
		$this -> children[] = $state;
		return $this -> children[count($this -> children)-1];
	}

	public function &getParent() {
		return $this -> parent;
	}

	public function setParent(&$parent) {
		$this -> parent = $parent;
	}

	public function &lastChild() {
		return $this -> children[count($this -> children) - 1];
	}

	public function output() {
		$return = '';
		$tag    = $this -> getTag();
		if($this -> tab >= 0 && !empty($tag)) {
			$return .= "<$tag";

			foreach($this -> attributes as $name => $value) {
				$return .= " $name=\"$value\"";
			}

			$return .= '>' . $this -> html;

			if($this -> command !== false) {
				$return .= eval($this -> command);
			}
		}

		foreach($this -> children as $child) {
			$return .= $child -> output();
		}

		if($this -> tab >= 0 && !empty($tag)) {
			$return .= in_array($tag, $this -> closing) ? "" : "</$tag>";
		}

		return $return;
	}
}

?>
