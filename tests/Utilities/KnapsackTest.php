<?php

namespace Utilities;

class KnapsackTest extends \PHPUnit_Framework_TestCase {
	var $knapsack;

	function setUp() {
		$this -> knapsack = new Knapsack(array('foo' => 'bar', 'bar' => '123'));
	}

	function tearDown() {
		unset($this -> knapsack);
	}

	function testGet() {
		$this -> assertEquals($this -> knapsack -> foo, 'bar');
		$this -> assertEquals($this -> knapsack -> bar, '123');
	}

	function testIsset() {
		$this -> assertFalse(isset($this -> knapsack -> something));
	}

	function testSet() {
		$this -> knapsack -> something1 = 'foo';
		$this -> knapsack -> set('SoMeThInG2', 'bar' );

		$this -> assertEquals($this -> knapsack -> get('something1'), 'foo');
		$this -> assertEquals($this -> knapsack -> something2, 'bar');
	}
}

?>
