--TEST--
cairo_scaled_font_status() function
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);

$matrix1 = cairo_matrix_init(1);
$matrix2 = cairo_matrix_init(1, 1);
$options = cairo_font_options_create();

$scaledfont = cairo_scaled_font_create($fontface, $matrix1, $matrix2, $options);
var_dump($scaledfont);

$status = cairo_scaled_font_status($scaledfont);
var_dump($status);

var_dump($status == CAIRO_STATUS_SUCCESS);

// bad type hint is an E_RECOVERABLE_ERROR, so let's hook a handler
function bad_class($errno, $errstr) {
	echo 'CAUGHT ERROR: ' . $errstr, PHP_EOL;
}
set_error_handler('bad_class', E_RECOVERABLE_ERROR);

// check number of args - should accept ONLY 1
cairo_scaled_font_status();
cairo_scaled_font_status($scaledfont, 1);

// check arg types, should be scaledfont object
cairo_scaled_font_status(1);
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\Font\Scaled)#%d (0) {
}
int(0)
bool(true)

Warning: cairo_scaled_font_status() expects exactly 1 parameter, 0 given in %s on line %d

Warning: cairo_scaled_font_status() expects exactly 1 parameter, 2 given in %s on line %d
CAUGHT ERROR: Argument 1 passed to cairo_scaled_font_status() must be an instance of Cairo\Font\Scaled, integer given

Warning: cairo_scaled_font_status() expects parameter 1 to be Cairo\Font\Scaled, integer given in %s on line %d