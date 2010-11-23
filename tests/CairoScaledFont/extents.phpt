--TEST--
Cairo\Font\Scaled->extents() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);
$matrix1 = new Cairo\Matrix(1);
$matrix2 = new Cairo\Matrix(1,1);
$fontoptions = new Cairo\Font\Options();

$scaled = new Cairo\Font\Scaled($fontface, $matrix1, $matrix2, $fontoptions);
var_dump($scaled);

var_dump($scaled->extents());

/* Wrong number args */
try {
    $scaled->extents('foo');
    trigger_error('status requires only one arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\Font\Scaled)#%d (0) {
}
array(5) {
  ["ascent"]=>
  float(%f)
  ["descent"]=>
  float(%f)
  ["height"]=>
  float(%f)
  ["max_x_advance"]=>
  float(%f)
  ["max_y_advance"]=>
  float(%f)
}
Cairo\Font\Scaled::extents() expects exactly 0 parameters, 1 given
