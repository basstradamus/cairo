--TEST--
Cairo\Font\Scaled->glyphExtents() method
--SKIPIF--
<?php
die('skip - Cairo glyph support not complete');
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
?>
--EXPECTF--