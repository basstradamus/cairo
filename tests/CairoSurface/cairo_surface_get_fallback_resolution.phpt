--TEST--
cairo_surface_get_fallback_resolution() function
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!function_exists('cairo_surface_get_fallback_resolution')) die('skip - cairo_surface_get_fallback_resolution is not available');
?>
--FILE--
<?php
$surface = cairo_image_surface_create(CAIRO_FORMAT_ARGB32, 50, 50);
var_dump($surface);

var_dump(cairo_surface_get_fallback_resolution($surface));

// bad type hint is an E_RECOVERABLE_ERROR, so let's hook a handler
function bad_class($errno, $errstr) {
	echo 'CAUGHT ERROR: ' . $errstr, PHP_EOL;
}
set_error_handler('bad_class', E_RECOVERABLE_ERROR);

// check number of args - should accept ONLY 1
cairo_surface_get_fallback_resolution();
cairo_surface_get_fallback_resolution($surface, 1);

// check arg types, should be surface object
cairo_surface_get_fallback_resolution(1);
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
array(2) {
  [0]=>
  float(%d)
  [1]=>
  float(%d)
}

Warning: cairo_surface_get_fallback_resolution() expects exactly 1 parameter, 0 given in %s on line %d

Warning: cairo_surface_get_fallback_resolution() expects exactly 1 parameter, 2 given in %s on line %d
CAUGHT ERROR: Argument 1 passed to cairo_surface_get_fallback_resolution() must be an instance of Cairo\Surface, integer given

Warning: cairo_surface_get_fallback_resolution() expects parameter 1 to be Cairo\Surface, integer given in %s on line %d