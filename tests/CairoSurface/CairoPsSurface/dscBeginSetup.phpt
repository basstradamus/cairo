--TEST--
Cairo\Surface\PS->dscBeginSetup() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PS(NULL, 50, 50);
var_dump($surface);

$surface->dscBeginSetup();

/* Wrong number args */
try {
    $surface->dscBeginSetup('foo');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\PS)#%d (0) {
}
Cairo\Surface\PS::dscBeginSetup() expects exactly 0 parameters, 1 given