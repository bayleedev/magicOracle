<?php

namespace magicOracle\tests\mocks;

class Foo {
	public $publicProperty;
	private $privateProperty;
	protected $protectedProperty;

	public function __construct($args = array()) {
		foreach($args as $key => $value) {
			$this->$key = $value;
		}
	}

	public function public_strtolower($words) {
		return strtolower($words);
	}

	private function private_ucwords($words) {
		return ucwords($words);
	}

	protected function protected_strtouper($words) {
		return strtoupper($words);
	}
}