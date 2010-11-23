--TEST--
Cairo\Pattern\Surface->getExtend() method
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

$pattern->setExtend(Cairo\Extend::PAD);

$extend = $pattern->getExtend();
var_dump($extend);
var_dump($extend == Cairo\Extend::PAD);

/* Total number of args needed = 1 */
try {
    $pattern->setExtend();
    trigger_error('setExtend with no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->setExtend(1, 1);
    trigger_error('setExtend with too many args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be int or castable to int */
try {
    $pattern->setExtend(array());
    trigger_error('Arg 1 must be int');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
int(3)
bool(true)
Cairo\Pattern\Surface::setExtend() expects exactly 1 parameter, 0 given
Cairo\Pattern\Surface::setExtend() expects exactly 1 parameter, 2 given
Cairo\Pattern\Surface::setExtend() expects parameter 1 to be long, array given