--TEST--
Cairo\Surface\SVG::versionToString() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('SVG', Cairo::availableSurfaces())) die('skip - SVG surface not available');
?>
--FILE--
<?php
echo Cairo\Surface\SVG::versionToString(Cairo\Surface\SVG\Version::VERSION_1_1), PHP_EOL;

/* Wrong number args */
try {
    Cairo\Surface\SVG::versionToString();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    Cairo\Surface\SVG::versionToString(1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    Cairo\Surface\SVG::versionToString(array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
SVG 1.1
Cairo\Surface\SVG::versionToString() expects exactly 1 parameter, 0 given
Cairo\Surface\SVG::versionToString() expects exactly 1 parameter, 2 given
Cairo\Surface\SVG::versionToString() expects parameter 1 to be long, array given