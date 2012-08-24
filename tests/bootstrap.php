<?php
// Get source
require_once(__DIR__ . '/../src/Oracle.php');

// Get mocks
$mocks = array_slice(scandir(__DIR__ . '/mocks'), 2);
foreach($mocks as $mock) {
	require_once(__DIR__ . '/mocks/' . $mock);
}