--TEST--
Cairo\Context->fill() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Format::ARGB32, 50, 50);
var_dump($surface);

$context = new Cairo\Context($surface);
var_dump($context);

$context->fillPreserve();

/* Wrong number args */
try {
    $context->fillPreserve('foobar');
    trigger_error('fillPreserve requires no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
Cairo\Context::fillPreserve() expects exactly 0 parameters, 1 given