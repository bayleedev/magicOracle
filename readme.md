# magicOracle

A proxy class developed for unit testing that makes all methods and properties public to you.

[![Build Status](https://secure.travis-ci.org/BlaineSch/magicOracle.png?branch=master)](http://travis-ci.org/BlaineSch/magicOracle)

## Basic Example
```php
<?php
// Library
include('../magicOracle/src/Oracle.php');

// Namespace
use magicOracle\src\Oracle as Oracle;

// Mock Class
class Foo {
	public $publicProperty;
	private $privateProperty;
	protected $protectedProperty;
	public function __construct() {
		$this->publicProperty = 'foo';
		$this->privateProperty = 'bar';
		$this->protectedProperty = 'baz';
	}
	public function publicMethod($words) {
		return $words;
	}
	private function privateMethod() {
		return $this->publicProperty;
	}
}

// new class
$fooBar = new Oracle('Foo');

// Call private method
echo $fooBar->privateMethod(); // 'foo';

// Echo protected variable
echo $fooBar->protectedProperty; // 'baz';

// Set and echo protected variable
echo $fooBar->privateProperty; //  'bar';
$fooBar->privateProperty = 'BlaineSch';
echo $fooBar->privateProperty; // BlaineSch
```

## Constructing Oracle
With class name
```php
$fooBar = new Oracle('Foo');
```

With class name and args
```php
$fooBar = new Oracle('Foo', array('arg1', 'arg2'));
```

With object
```php
$foo = new Foo('arg1', 'arg2');
$fooBar = new Oracle($foo);
```

## Requirements
 * [PHP 5.3+](http://php.net/downloads.php)

## Contributing

### Requirements
 * [PHP 5.3+](http://php.net/downloads.php)
 * [PHPUnit](http://www.phpunit.de/manual/3.6/en/installation.html/)

### Unit Testing
```
cd magicOracle
phpunit ./
```

```
PHPUnit 3.6.12 by Sebastian Bergmann.

Configuration read from /Users/blaineschmeisser/Sites/devup/magicOracle/phpunit.xml

......

Time: 0 seconds, Memory: 5.00Mb

OK (6 tests, 9 assertions)
```