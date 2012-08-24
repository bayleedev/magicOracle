<?php

namespace magicOracle\tests;

use \magicOracle\src\Oracle as Oracle;
use \magicOracle\tests\mocks\Foo as Foo;

class BaseTest extends \PHPUnit_Framework_TestCase {

	protected $foo;
	protected $oracle;

	protected function setUp() {
		$this->foo = new Foo(array(
			'publicProperty' => 'foo',
			'privateProperty' => 'bar',
			'protectedProperty' => 'baz'
		));
		$this->oracle = new Oracle($this->foo);
	}

	public function testPublicProperty() {
		// Get default property
		$this->assertEquals('foo', $this->oracle->publicProperty);

		// Set property
		$this->oracle->publicProperty = 'foobar';
		$this->assertEquals('foobar', $this->oracle->publicProperty);
	}

	public function testProtectedProperty() {
		// Get default property
		$this->assertEquals('baz', $this->oracle->protectedProperty);

		// Set property
		$this->oracle->protectedProperty = 'foobar';
		$this->assertEquals('foobar', $this->oracle->protectedProperty);
	}

	public function testPrivateProperty() {
		// Get default property
		$this->assertEquals('bar', $this->oracle->privateProperty);

		// Set property
		$this->oracle->privateProperty = 'foobar';
		$this->assertEquals('foobar', $this->oracle->privateProperty);
	}

	public function testPublicMethod() {
		$phrase = 'Hello, World.';
		$expected = strtolower($phrase);
		$this->assertEquals($expected, $this->oracle->public_strtolower($phrase));
	}

	public function testProtectedMethod() {
		$phrase = 'Hello, World.';
		$expected = strtoupper($phrase);
		$this->assertEquals($expected, $this->oracle->protected_strtouper($phrase));
	}

	public function testPrivateMethod() {
		$phrase = 'Hello, World.';
		$expected = ucwords($phrase);
		$this->assertEquals($expected, $this->oracle->private_ucwords($phrase));
	}
}