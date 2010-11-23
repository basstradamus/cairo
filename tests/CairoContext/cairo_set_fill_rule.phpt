--TEST--
cairo_set_fill_rule() function
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

cairo_set_fill_rule($context, CAIRO_FILL_RULE_EVEN_ODD);
var_dump(cairo_get_fill_rule($context));

// bad type hint is an E_RECOVERABLE_ERROR, so let's hook a handler
function bad_class($errno, $errstr) {
	echo 'CAUGHT ERROR: ' . $errstr, PHP_EOL;
}
set_error_handler('bad_class', E_RECOVERABLE_ERROR);

// check number of args - should accept 2
cairo_set_fill_rule();
cairo_set_fill_rule($context);
cairo_set_fill_rule($context, 1, 1);

// check arg types, should be int
cairo_set_fill_rule(1, 1);
cairo_set_fill_rule($context, array());
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
int(1)

Warning: cairo_set_fill_rule() expects exactly 2 parameters, 0 given in %s on line %d

Warning: cairo_set_fill_rule() expects exactly 2 parameters, 1 given in %s on line %d

Warning: cairo_set_fill_rule() expects exactly 2 parameters, 3 given in %s on line %d
CAUGHT ERROR: Argument 1 passed to cairo_set_fill_rule() must be an instance of Cairo\Context, integer given

Warning: cairo_set_fill_rule() expects parameter 1 to be Cairo\Context, integer given in %s on line %d

Warning: cairo_set_fill_rule() expects parameter 2 to be long, array given in %s on line %d