--TEST--
cairo_create function
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = cairo_image_surface_create(CAIRO_FORMAT_ARGB32, 50, 50);
var_dump($surface);

$context = cairo_create($surface);
var_dump($context);

// bad type hint is an E_RECOVERABLE_ERROR, so let's hook a handler
function bad_class($errno, $errstr) {
	echo 'CAUGHT ERROR: ' . $errstr, PHP_EOL;
}
set_error_handler('bad_class', E_RECOVERABLE_ERROR);

// check number of args - should accept ONLY 1
cairo_create();
cairo_create($surface, 1);

// check arg types, should be Cairo\Surface
cairo_create(1);
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}

Warning: cairo_create() expects exactly 1 parameter, 0 given in %s on line %d

Warning: cairo_create() expects exactly 1 parameter, 2 given in %s on line %d
CAUGHT ERROR: Argument 1 passed to cairo_create() must be an instance of Cairo\Surface, integer given

Warning: cairo_create() expects parameter 1 to be Cairo\Surface, integer given in %s on line %d