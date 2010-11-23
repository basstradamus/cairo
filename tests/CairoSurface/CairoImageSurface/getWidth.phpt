--TEST--
Cairo\Surface\Image->getWidth() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Format::ARGB32, 50, 50);
var_dump($surface);

var_dump($surface->getWidth());

/* Wrong number args */
try {
    $surface->getWidth('foo');
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
int(50)
Cairo\Surface\Image::getWidth() expects exactly 0 parameters, 1 given