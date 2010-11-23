--TEST--
Cairo\Font\Scaled->getCtm() method
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

var_dump($scaled->getCtm());

/* Wrong number args */
try {
    $scaled->getCtm('foo');
    trigger_error('status requires only one arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

die; // GC issue, bogus memleaks reported without this
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\Font\Scaled)#%d (0) {
}
object(Cairo\Matrix)#%d (0) {
}
Cairo\Font\Scaled::getCtm() expects exactly 0 parameters, 1 given
