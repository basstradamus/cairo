--TEST--
Cairo\Surface->getFontOptions() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Format::ARGB32, 50, 50);
var_dump($surface);

var_dump($surface->getFontOptions());

/* Wrong number args */
try {
    $surface->getFontOptions('foo');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Font\Options)#%d (0) {
}
Cairo\Surface::getFontOptions() expects exactly 0 parameters, 1 given