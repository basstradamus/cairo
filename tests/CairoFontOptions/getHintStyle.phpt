--TEST--
Cairo\Font\Options->getHintStyle() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\Font\Options();
var_dump($options);

var_dump($options->getHintStyle());

/* Wrong number args */
try {
    $options->getHintStyle('foo');
    trigger_error('getHintStyle requires no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Font\Options)#%d (0) {
}
int(0)
Cairo\Font\Options::getHintStyle() expects exactly 0 parameters, 1 given