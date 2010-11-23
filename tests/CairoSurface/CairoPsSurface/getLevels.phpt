--TEST--
Cairo\Surface\PS::getLevels() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
if(!method_exists('Cairo\Surface\PS', 'getLevels')) die('skip - Cairo\Surface\PS::getLevels not available');

?>
--FILE--
<?php
var_dump(Cairo\Surface\PS::getLevels());

/* Wrong number args */
try {
    Cairo\Surface\PS::getLevels('foo');
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
Cairo\Surface\PS::getLevels() expects exactly 0 parameters, 1 given