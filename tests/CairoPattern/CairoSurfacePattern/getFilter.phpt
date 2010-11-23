--TEST--
Cairo\Pattern\Surface->getFilter() method
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

$pattern->setFilter(Cairo\Filter::GOOD);
$filter = $pattern->getFilter();
var_dump($filter);
var_dump($filter == Cairo\Filter::GOOD);

/* Total number of args needed = 0 */
try {
    $pattern->getFilter(1);
    trigger_error('getFilter with too many args');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
int(1)
bool(true)
Cairo\Pattern\Surface::getFilter() expects exactly 0 parameters, 1 given