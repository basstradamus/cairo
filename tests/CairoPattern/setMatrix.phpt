--TEST--
Cairo\Pattern->setMatrix() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$pattern = new Cairo\Pattern\Solid(0.8, 0.6, 0.5);
var_dump($pattern);

$matrix = new Cairo\Matrix();
var_dump($matrix);

$pattern->setMatrix($matrix);
$matrix1 = $pattern->getMatrix();

var_dump($matrix === $matrix1);

$matrix2 = new Cairo\Matrix(5, 5);
$pattern->setMatrix($matrix2);
$matrix1 = $pattern->getMatrix();

var_dump($matrix2 === $matrix1);

try {
    $pattern->setMatrix();
    trigger_error('Set matrix requires one arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $pattern->setMatrix(1, 1);
    trigger_error('Set matrix requires only one arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $pattern->setMatrix(1);
    trigger_error('Set matrix requires instanceof Cairomatrix');
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
bool(true)
bool(true)
Cairo\Pattern::setMatrix() expects exactly 1 parameter, 0 given
Cairo\Pattern::setMatrix() expects exactly 1 parameter, 2 given
Cairo\Pattern::setMatrix() expects parameter 1 to be Cairo\Matrix, integer given