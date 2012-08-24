<?php

namespace magicOracle\src;

/**
 * Oracle is a proxy class that can aid in unit testing by making all methods and properties accessible.
 * 
 * <code>
 * class Foo {
 * 	public $publicProperty;
 * 	private $privateProperty;
 * 	protected $protectedProperty;
 * 	public function __construct() {
 * 		$this->publicProperty = 'foo';
 * 		$this->privateProperty = 'bar';
 * 		$this->protectedProperty = 'baz';
 * 	}
 * 	public function publicMethod($words) {
 * 		return $words;
 * 	}
 * 	private function privateMethod() {
 * 		return $this->publicProperty;
 * 	}
 * 	protected function protectedMethod($words) {
 * 		return strtoupper($words);
 * 	}
 * }
 * 
 * $fooBar = new Oracle('Foo');
 * 
 * // Call private method
 * echo $fooBar->privateMethod(); // 'foo';
 * 
 * // Echo protected variable
 * echo $fooBar->protectedProperty; // 'baz';
 * 
 * // Set and echo protected variable
 * echo $fooBar->privateProperty; //  'bar';
 * $fooBar->privateProperty = 'Blaine';
 * echo $fooBar->privateProperty; // Blaine
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
		$this->reflection = new \ReflectionObject($this->instance);
	}

	/**
	 * Magic method __call
	 * 
	 * Allows you call any method on the $className class provided in the constructor.
	 * 
	 * <code>
	 * $fooBar = new Oracle('Foo');
	 * echo $fooBar->privateMethod(); // 'foo';
	 * </code>
	 * 
	 * @link http://www.php.net/manual/en/language.oop5.overloading.php#object.call
	 * @param string $methodName 
	 * @param array $args 
	 * @return mixed
	 */
	public function __call($methodName, $args) {
		$method = new \ReflectionMethod($this->instance, $methodName);
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
	 * $fooBar = new Oracle('Foo');
	 * echo $fooBar->protectedProperty; // 'baz';
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
	 * $fooBar = new Oracle('Foo');
	 * echo $fooBar->privateProperty; //  'bar';
	 * $fooBar->privateProperty = 'Blaine';
	 * echo $fooBar->privateProperty; // Blaine
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