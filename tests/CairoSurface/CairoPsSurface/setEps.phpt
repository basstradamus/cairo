--TEST--
Cairo\Surface\PS->setEps() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
if(!method_exists('Cairo\Surface\PS', 'setEps')) die('skip - Cairo\Surface\PS->setEps not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PS(NULL, 50, 50);
var_dump($surface);

$surface->setEps(true);

/* Wrong number args */
try {
    $surface->setEps();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->setEps(1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->setEps(array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\PS)#%d (0) {
}
Cairo\Surface\PS::setEps() expects exactly 1 parameter, 0 given
Cairo\Surface\PS::setEps() expects exactly 1 parameter, 2 given
Cairo\Surface\PS::setEps() expects parameter 1 to be boolean, array given