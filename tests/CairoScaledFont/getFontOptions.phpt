--TEST--
Cairo\Font\Scaled->getFontOptions() method
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

$options2 = $scaled->getFontOptions();
var_dump($options2);

var_dump($options2 == $fontoptions);

/* Wrong number args */
try {
    $scaled->getFontOptions('foo');
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
object(Cairo\Font\Options)#%d (0) {
}
bool(true)
Cairo\Font\Scaled::getFontOptions() expects exactly 0 parameters, 1 given