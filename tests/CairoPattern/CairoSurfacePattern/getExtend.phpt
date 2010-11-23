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

$extend = $pattern->getExtend();
var_dump($extend);
var_dump($extend == Cairo\Extend::NONE);

/* Total number of args needed = 0 */
try {
    $pattern->getExtend(1);
    trigger_error('getExtend with too many args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
int(0)
bool(true)
Cairo\Pattern\Surface::getExtend() expects exactly 0 parameters, 1 given