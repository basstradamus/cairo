--TEST--
Cairo\Font\Options->status() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\Font\Options();
var_dump($options);

$status = $options->status();
var_dump($status);
var_dump($status == Cairo\Status::SUCCESS);

/* Wrong number args */
try {
    $options->status('foo');
    trigger_error('status requires no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Font\Options)#%d (0) {
}
int(0)
bool(true)
Cairo\Font\Options::status() expects exactly 0 parameters, 1 given