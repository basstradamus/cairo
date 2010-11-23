--TEST--
cairo_font_options_hash() function
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = cairo_font_options_create();
var_dump($options);

var_dump(cairo_font_options_hash($options));

// bad type hint is an E_RECOVERABLE_ERROR, so let's hook a handler
function bad_class($errno, $errstr) {
	echo 'CAUGHT ERROR: ' . $errstr, PHP_EOL;
}
set_error_handler('bad_class', E_RECOVERABLE_ERROR);

// check number of args - should accept ONLY 1
cairo_font_options_hash();
cairo_font_options_hash($options, 1);

// check arg types, should be options object
cairo_font_options_hash(1);
?>
--EXPECTF--
object(Cairo\Font\Options)#%d (0) {
}
int(0)

Warning: cairo_font_options_hash() expects exactly 1 parameter, 0 given in %s on line %d

Warning: cairo_font_options_hash() expects exactly 1 parameter, 2 given in %s on line %d
CAUGHT ERROR: Argument 1 passed to cairo_font_options_hash() must be an instance of Cairo\Font\Options, integer given

Warning: cairo_font_options_hash() expects parameter 1 to be Cairo\Font\Options, integer given in %s on line %d