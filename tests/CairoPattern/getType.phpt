--TEST--
Cairo\Pattern->getType() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Format::ARGB32, 50, 50);
var_dump($surface);

$pattern = new Cairo\Pattern\Surface($surface);
var_dump($pattern);

var_dump($pattern->getType());

try {
    $pattern->getType('foo');
    trigger_error('Cairo\Pattern->getType requires no arguments');
} catch (Cairo\Exception $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
int(1)
Cairo\Pattern::getType() expects exactly 0 parameters, 1 given