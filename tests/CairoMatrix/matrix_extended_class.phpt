--TEST--
extend Cairo\Matrix Class
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
class test extends Cairo\Matrix {}

class test2 extends Cairo\Matrix {
	public function __construct() {}
}

$matrix = new Cairo\Matrix();
var_dump($matrix);

$matrix = new test2();
$matrix->invert();
echo 'First call to any method should throw a fatal error';
?>
--EXPECTF--
object(Cairo\Matrix)#%d (0) {
}

Fatal error: Internal matrix object missing in test2 wrapper, you must call parent::__construct in extended classes in %s on line %d