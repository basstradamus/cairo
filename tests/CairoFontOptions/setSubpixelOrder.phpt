--TEST--
Cairo\Font\Options->setSubpixelOrder() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\Font\Options();
var_dump($options);

$options->setSubpixelOrder(Cairo\SubpixelOrder::ORDER_RGB);

/* Wrong number args 1*/
try {
    $options->setSubpixelOrder();
    trigger_error('setSubpixelOrder requires 1 arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setSubpixelOrder(Cairo\SubpixelOrder::ORDER_RGB, 1);
    trigger_error('setSubpixelOrder requires only 1 arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setSubpixelOrder(array());
    trigger_error('setSubpixelOrder requires int');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Font\Options)#%d (0) {
}
Cairo\Font\Options::setSubpixelOrder() expects exactly 1 parameter, 0 given
Cairo\Font\Options::setSubpixelOrder() expects exactly 1 parameter, 2 given
Cairo\Font\Options::setSubpixelOrder() expects parameter 1 to be long, array given