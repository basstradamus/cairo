--TEST--
Cairo\Surface\SVG->restrictToVersion() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('SVG', Cairo::availableSurfaces())) die('skip - SVG surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\SVG(NULL, 50, 50);
var_dump($surface);

$surface->restrictToVersion(Cairo\Surface\SVG\Version::VERSION_1_1);

/* Wrong number args */
try {
    $surface->restrictToVersion();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->restrictToVersion(1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->restrictToVersion(array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\SVG)#%d (0) {
}
Cairo\Surface\SVG::restrictToVersion() expects exactly 1 parameter, 0 given
Cairo\Surface\SVG::restrictToVersion() expects exactly 1 parameter, 2 given
Cairo\Surface\SVG::restrictToVersion() expects parameter 1 to be long, array given