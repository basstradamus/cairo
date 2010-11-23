--TEST--
Cairo\Surface\PS->dscBeginPageSetup() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PS(NULL, 50, 50);
var_dump($surface);

$surface->dscBeginPageSetup();

/* Wrong number args */
try {
    $surface->dscBeginPageSetup('foo');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\PS)#%d (0) {
}
Cairo\Surface\PS::dscBeginPageSetup() expects exactly 0 parameters, 1 given