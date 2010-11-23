--TEST--
Cairo\Surface\PS->restrictToLevel() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
if(!method_exists('Cairo\Surface\PS', 'restrictToLevel')) die('skip - Cairo\Surface\PS->restrictToLevel not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PS(NULL, 50, 50);
var_dump($surface);

$surface->restrictToLevel(Cairo\Surface\PS\Level::LEVEL_2);

/* Wrong number args */
try {
    $surface->restrictToLevel();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->restrictToLevel(1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->restrictToLevel(array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\PS)#%d (0) {
}
Cairo\Surface\PS::restrictToLevel() expects exactly 1 parameter, 0 given
Cairo\Surface\PS::restrictToLevel() expects exactly 1 parameter, 2 given
Cairo\Surface\PS::restrictToLevel() expects parameter 1 to be long, array given