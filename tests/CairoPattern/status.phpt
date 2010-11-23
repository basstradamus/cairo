--TEST--
Cairo\Pattern->status() method
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

$status = $pattern->status();
var_dump($status);
var_dump($status == Cairo\Status::SUCCESS);

try {
    $pattern->status('foo');
    trigger_error('status requires no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
int(0)
bool(true)
Cairo\Pattern::status() expects exactly 0 parameters, 1 given