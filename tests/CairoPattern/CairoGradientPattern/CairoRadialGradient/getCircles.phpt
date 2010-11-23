--TEST--
Cairo\Pattern\Gradient\Radial->getCircles() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$pattern = new Cairo\Pattern\Gradient\Radial(0.5, 0.5, 0.25, 0.5, 0.5, 0.5);
var_dump($pattern);

var_dump($pattern->getCircles());

/* Total number of args needed = 0 */
try {
    $pattern->getCircles(1);
    trigger_error('getCircles with too many args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Pattern\Gradient\Radial)#%d (0) {
}
array(6) {
  ["x0"]=>
  float(0.5)
  ["y0"]=>
  float(0.5)
  ["r0"]=>
  float(0.25)
  ["x1"]=>
  float(0.5)
  ["y1"]=>
  float(0.5)
  ["r1"]=>
  float(0.5)
}
Cairo\Pattern\Gradient\Radial::getCircles() expects exactly 0 parameters, 1 given