<?php

namespace Utilities;

class KnapsackTest extends \PHPUnit_Framework_TestCase {
	function testConstructor() {
		$knapsack = new Knapsack(array('foo' => 'bar', 'bar' => '123'));

		$this -> assertEquals($knapsack -> foo, 'bar');
		$this -> assertEquals($knapsack -> bar, '123');
		$this -> assertFalse(isset($knapsack -> something));
	}
}

?>
