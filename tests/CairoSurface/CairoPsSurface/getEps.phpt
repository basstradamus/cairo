--TEST--
Cairo\Surface\PS->getEps() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
if(!method_exists('Cairo\Surface\PS', 'getEps')) die('skip - Cairo\Surface\PS->getEps not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PS(NULL, 50, 50);
var_dump($surface);

var_dump($surface->getEps());

/* Wrong number args */
try {
    $surface->getEps('foo');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\PS)#%d (0) {
}
bool(false)
Cairo\Surface\PS::getEps() expects exactly 0 parameters, 1 given