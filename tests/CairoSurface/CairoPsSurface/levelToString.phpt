--TEST--
Cairo\Surface\PS::levelToString() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
if(!method_exists('Cairo\Surface\PS', 'levelToString')) die('skip - Cairo\Surface\PS::levelToString not available');
?>
--FILE--
<?php
echo Cairo\Surface\PS::levelToString(Cairo\Surface\PS\Level::LEVEL_2), PHP_EOL;

/* Wrong number args */
try {
    Cairo\Surface\PS::levelToString();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    Cairo\Surface\PS::levelToString(1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    Cairo\Surface\PS::levelToString(array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
PS Level 2
Cairo\Surface\PS::levelToString() expects exactly 1 parameter, 0 given
Cairo\Surface\PS::levelToString() expects exactly 1 parameter, 2 given
Cairo\Surface\PS::levelToString() expects parameter 1 to be long, array given