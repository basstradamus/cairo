--TEST--
Cairo\Pattern\Surface->setFilter() method
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

$pattern->setFilter(Cairo\Filter::NEAREST);

$filter = $pattern->getFilter();
var_dump($filter);
var_dump($filter == Cairo\Filter::NEAREST);

/* Total number of args needed = 1 */
try {
    $pattern->setFilter();
    trigger_error('setFilter with no args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->setFilter(1, 1);
    trigger_error('setFilter with too many args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be int or castable to int */
try {
    $pattern->setFilter(array());
    trigger_error('Arg 1 must be int');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
int(3)
bool(true)
Cairo\Pattern\Surface::setFilter() expects exactly 1 parameter, 0 given
Cairo\Pattern\Surface::setFilter() expects exactly 1 parameter, 2 given
Cairo\Pattern\Surface::setFilter() expects parameter 1 to be long, array given