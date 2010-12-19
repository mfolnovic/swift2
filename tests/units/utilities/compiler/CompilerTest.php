<?php

use Swift\Utilities\Compiler\Compiler;

class CompilerTest extends \PHPUnit_Framework_TestCase {
	function testCreation() {
		$compiler = new Compiler(APP_DIR . 'tmp/test.compiled.php');
		unset($compiler);

		$this -> assertEquals(file_get_contents(APP_DIR . 'tmp/test.compiled.php'), file_get_contents(APP_DIR . 'tmp/test.correct.php'));
	}

	function testCall() {
		$compiler = new Compiler(APP_DIR . 'tmp/test2.compiled.php');
		$compiler -> print('hello', 'world');
		$compiler -> die('hmm');
		$compiler -> custom(123, 456, '789');
		unset($compiler);

		$this -> assertEquals(file_get_contents(APP_DIR . 'tmp/test2.compiled.php'), file_get_contents(APP_DIR . 'tmp/test2.correct.php'));
	}

	function testEach() {
		$compiler = new Compiler(APP_DIR . 'tmp/test3.compiled.php');
		$compiler -> foreach("array('hello', 'world')", 'key', 'val');
		$compiler -> print('key');
		$compiler -> print('val');
		$compiler -> endForeach();
		unset($compiler);

		$this -> assertEquals(file_get_contents(APP_DIR . 'tmp/test3.compiled.php'), file_get_contents(APP_DIR . 'tmp/test3.correct.php'));
	}

	function testIf() {
		$compiler = new Compiler(APP_DIR . 'tmp/test4.compiled.php');
		$compiler -> if('$a == $b') -> print("\$a equals \$b");
		$compiler -> elseif('$a == $c') -> print("\$a equals \$c");
		$compiler -> else() -> print('else');
		$compiler -> endIf();
		unset($compiler);

		$this -> assertEquals(file_get_contents(APP_DIR . 'tmp/test4.compiled.php'), file_get_contents(APP_DIR . 'tmp/test4.correct.php'));
	}

	function testFunction() {
		$compiler = new Compiler(APP_DIR . 'tmp/test5.compiled.php');

		$compiler -> startFunction('hello', 'arg1', 'arg2');
		$compiler -> print('$arg1, $arg2');
		$compiler -> endFunction();

		$compiler -> startFunction('hello2');
		$compiler -> print('something');
		$compiler -> return('0');
		$compiler -> endFunction();

		unset($compiler);

		$this -> assertEquals(file_get_contents(APP_DIR . 'tmp/test5.compiled.php'), file_get_contents(APP_DIR . 'tmp/test5.correct.php'));
	}

	/**
	 * @dataProvider providerTestCompileArray
	 */
	function testCompileArray($from) {
		$compiler = new Compiler();
		$class  = new ReflectionClass('Swift\Utilities\Compiler\Compiler');
		$method = $class -> getMethod('compileArray');
		$method -> setAccessible(true);

		$return = $method -> invoke($compiler, $from);
		$this -> assertEquals(eval("return $return;"), $from);
	}

	/**
	 * @codeCoverageIgnore
	 */
	function providerTestCompileArray() {
		return array(
			array(array(1, 2, 3)),
			array(array('foo' => 'bar', 'hello' => 1)),
			array(array('foo' => array('bar', 1), 'hello' => 'world'))
		);
	}
}

?>
