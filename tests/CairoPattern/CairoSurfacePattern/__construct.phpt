--TEST--
new Cairo\Pattern\Surface [ __construct method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Format::ARGB32, 50, 50);
var_dump($surface);

$pattern = new Cairo\Pattern\Surface($surface);
var_dump($pattern);

/* Total number of args needed = 1 */
try {
    new Cairo\Pattern\Surface();
    trigger_error('Cairo\Pattern\Surface with no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    new Cairo\Pattern\Surface($surface, 1);
    trigger_error('Cairo\Pattern\Surface with too many args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be instanceof Cairo\Surface */
try {
    new Cairo\Pattern\Surface(1);
    trigger_error('Arg 1 must be Cairo\Surface');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
Cairo\Pattern\Surface::__construct() expects exactly 1 parameter, 0 given
Cairo\Pattern\Surface::__construct() expects exactly 1 parameter, 2 given
Cairo\Pattern\Surface::__construct() expects parameter 1 to be Cairo\Surface, integer given