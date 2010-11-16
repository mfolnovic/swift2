<?php

namespace HTTP\Router;

class Route {
	var $route;
	var $compiled = array();

	function __construct($route) {
		$this -> route = $route;
	}

	public function &compile() {
		if(empty($this -> compiled)) {
			$path     =  $this -> route['pattern'];
			$compiled =& $this -> compiled;

			preg_match_all("/[(]|[)]|[^\(\)]+/", $path, $parts);
			foreach($parts[0] as $part) {
				if($part == ')') {
					$push = array();
					while(($current = array_pop($compiled)) != '(') {
						$push[] = $current;
					}
					$compiled[] = array_reverse($push);
				} else {
					$compiled[] = $part;
				}
			}
		}

		return $compiled;
	}
}

?>
