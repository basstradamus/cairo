--TEST--
Cairo\Format::strideForWidth() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!method_exists('Cairo\Format', 'strideForWidth')) die('skip - Cairo\Format::strideForWidth not available');
?>
--FILE--
<?php
echo Cairo\Format::strideForWidth(1, 5), PHP_EOL;

/* Wrong number args */
try {
    Cairo\Format::strideForWidth();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    Cairo\Format::strideForWidth(1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    Cairo\Format::strideForWidth(1, 1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    Cairo\Format::strideForWidth(array(), 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    Cairo\Format::strideForWidth(1, array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
20
Cairo\Format::strideForWidth() expects exactly 2 parameters, 0 given
Cairo\Format::strideForWidth() expects exactly 2 parameters, 1 given
Cairo\Format::strideForWidth() expects exactly 2 parameters, 3 given
Cairo\Format::strideForWidth() expects parameter 1 to be long, array given
Cairo\Format::strideForWidth() expects parameter 2 to be long, array given