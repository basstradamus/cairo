--TEST--
Cairo\Pattern\Gradient->setExtend() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$pattern = new Cairo\Pattern\Gradient\Linear(1, 2, 3, 4);
var_dump($pattern);

$pattern->setExtend(Cairo\Extend::REFLECT);

$extend = $pattern->getExtend();
var_dump($extend);
var_dump($extend == Cairo\Extend::REFLECT);

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
object(Cairo\Pattern\Gradient\Linear)#%d (0) {
}
int(2)
bool(true)
Cairo\Pattern\Gradient::setExtend() expects exactly 1 parameter, 0 given
Cairo\Pattern\Gradient::setExtend() expects exactly 1 parameter, 2 given
Cairo\Pattern\Gradient::setExtend() expects parameter 1 to be long, array given