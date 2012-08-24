# magicOracle

A proxy class developed for unit testing that makes all methods and properties public to you.

## Example 1
```php
<?php
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