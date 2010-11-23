--TEST--
Cairo\Surface\SVG::getVersions() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('SVG', Cairo::availableSurfaces())) die('skip - SVG surface not available');
?>
--FILE--
<?php
var_dump(Cairo\Surface\SVG::getVersions());

/* Wrong number args */
try {
    Cairo\Surface\SVG::getVersions('foo');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
array(2) {
  [0]=>
  int(0)
  [1]=>
  int(1)
}
Cairo\Surface\SVG::getVersions() expects exactly 0 parameters, 1 given