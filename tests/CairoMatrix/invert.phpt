--TEST--
Cairo\Matrix->invert method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$matrix = new Cairo\Matrix();
var_dump($matrix);

$matrix->invert();

/* Wrong number args */
try {
    $matrix->invert('foo');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Matrix)#%d (0) {
}
Cairo\Matrix::invert() expects exactly 0 parameters, 1 given