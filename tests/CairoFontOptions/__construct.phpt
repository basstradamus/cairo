--TEST--
new Cairo\Font\Options [ __construct() method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\Font\Options();
var_dump($options);

/* Wrong number args */
try {
    new Cairo\Font\Options('foo');
    trigger_error('__construct requires no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Font\Options)#%d (0) {
}
Cairo\Font\Options::__construct() expects exactly 0 parameters, 1 given