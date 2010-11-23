--TEST--
new Cairo\Pattern\Gradient [ __construct method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
class test extends Cairo\Pattern\Gradient {}

class test2 extends Cairo\Pattern\Gradient {
	public function __construct() {}
}
try {
	$pattern = new test();
	echo 'Attempting to use constructor should throw an exception';
} catch (Cairo\Exception $e) {
	echo $e->getMessage();
}

$pattern = new test2();
$pattern->getType();
echo 'First call to any method should throw a fatal error';
?>
--EXPECTF--
Cairo\Pattern cannot be constructed
Fatal error: Internal pattern object missing in test2 wrapper, you must call parent::__construct in extended classes in %s on line %d