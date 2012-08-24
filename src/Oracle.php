<?php

namespace magicOracle\src;

/**
 * Oracle is a proxy class that can aid in unit testing by making all methods and properties accessible.
 * 
 * <code>
 * // Foo.php
 * class Foo {
 * 	public $r;
 * 	protected $m;
 * 	public function __construct() {
 * 		$this->r = 'meow';
 * 		$this->m = 'ruff';
 * 	}
 * 	private function myPrivateMethod() {
 * 		return $this->r;
 * 	}
 * 	private function speak($words) {
 * 		echo $words;
 * 		return;
 * 	}
 * 	private static function scream($words) {
 * 		echo strtoupper($words);
 * 		return;
 * 	}
 * }
 * </code>
 * 
 * <code>
 * // test.php
 * require_once('Foo.php');
 * 
 * $bar = new Oracle('Foo');
 * 
 * // Call private method
 * echo $bar->myPrivateMethod(); // meow
 * 
 * // Call private method with params
 * $bar->speak('Hello, Tim!');  // Hello, Tim!
 * 
 * // Echo protected variable
 * echo $bar->m; // 'ruff';
 * 
 * // Set and echo protected variable
 * $bar->m = 'Blaine';
 * echo $bar->m; // Blaine
 * </code>
 */
class Oracle {
	protected $instance;
	protected $reflection;

	/**
	 * The constructor
	 * 
	 * @param string $className The name of the class you wish to access.
	 */
	public function __construct($className) {
		$this->instance = new $className;
		$this->reflection = new ReflectionObject($this->instance);
	}

	/**
	 * Magic method __call
	 * 
	 * Allows you call any method on the $className class provided in the constructor.
	 * 
	 * <code>
	 * $bar = new Oracle('Foo');
	 * $bar->speak('Hello, Tim!');  // Hello, Tim!
	 * </code>
	 * 
	 * @link http://www.php.net/manual/en/language.oop5.overloading.php#object.call
	 * @param string $methodName 
	 * @param array $args 
	 * @return mixed
	 */
	public function __call($methodName, $args) {
		$method = new ReflectionMethod($this->instance, $methodName);
		$method->setAccessible(true);
		array_unshift($args, $this->instance); // make instance first
		return call_user_func_array(array($method, 'invoke'), $args);
	}

	/**
	 * Magic method __get
	 * 
	 * Allows you to retrieve the value of any property inside of the $className class.
	 * 
	 * <code>
	 * $bar = new Oracle('Foo');
	 * echo $bar->m; // 'ruff';
	 * </code>
	 * 
	 * @param string $name 
	 * @return mixed
	 */
	public function __get($name) {
		$prop = $this->reflection->getProperty($name);
		$prop->setAccessible(true);
		return $prop->getValue($this->instance);
	}

	/**
	 * Magic method __set
	 * 
	 * Allows you to set the value of any property inside of the $className class.
	 * 
	 * <code>
	 * $bar = new Oracle('Foo');
	 * $bar->m = 'BlaineSch';
	 * echo $bar->m; // BlaineSch
	 * </code>
	 * 
	 * @param type $name 
	 * @param type $value 
	 * @return type
	 */
	public function __set($name, $value) {
		$prop = $this->reflection->getProperty($name);
		$prop->setAccessible(true);
		return $prop->setValue($this->instance, $value);
	}

}