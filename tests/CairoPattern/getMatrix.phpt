--TEST--
Cairo\Pattern->getMatrix() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$pattern = new Cairo\Pattern\Solid(0.8, 0.6, 0.5);
var_dump($pattern);

var_dump($orig_matrix = $pattern->getMatrix());

$matrix = new Cairo\Matrix(5, 5);
var_dump($matrix);
var_dump($orig_matrix === $matrix);

$pattern->setMatrix($matrix);
var_dump($matrix1 = $pattern->getMatrix());
var_dump($matrix1 === $matrix);
var_dump($orig_matrix === $matrix);

try {
    $pattern->getMatrix('foo');
    trigger_error('get matrix requires no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

die; // DO NOT REMOVE THIS - fixes issue in 5.3 with GC giving bogus memleak reports
?>
--EXPECTF--
object(Cairo\Pattern\Solid)#%d (0) {
}
object(Cairo\Matrix)#%d (0) {
}
object(Cairo\Matrix)#%d (0) {
}
bool(false)
object(Cairo\Matrix)#%d (0) {
}
bool(true)
bool(false)
Cairo\Pattern::getMatrix() expects exactly 0 parameters, 1 given