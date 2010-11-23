--TEST--
Cairo\Pattern\Gradient->getExtend() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$pattern = new Cairo\Pattern\Gradient\Linear(1, 2, 3, 4);
var_dump($pattern);

$extend = $pattern->getExtend();
var_dump($extend);
var_dump($extend == Cairo\Extend::PAD);

/* Total number of args needed = 0 */
try {
    $pattern->getExtend(1);
    trigger_error('getExtend with too many args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Pattern\Gradient\Linear)#%d (0) {
}
int(3)
bool(true)
Cairo\Pattern\Gradient::getExtend() expects exactly 0 parameters, 1 given