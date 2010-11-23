--TEST--
Cairo\Font\Scaled->getType() method
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

var_dump($scaled->getType());

try {
    $scaled->getType('foo');
    trigger_error('Cairo\Font\Scaled->getType requires no arguments');
} catch (Cairo\Exception $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\Font\Scaled)#%d (0) {
}
int(%d)
Cairo\Font\Scaled::getType() expects exactly 0 parameters, 1 given
