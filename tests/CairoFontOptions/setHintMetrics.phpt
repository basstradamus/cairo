--TEST--
Cairo\Font\Options->setHintMetrics() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\Font\Options();
var_dump($options);

$options->setHintMetrics(Cairo\Hint\Metrics::METRICS_ON);

/* Wrong number args 1*/
try {
    $options->setHintMetrics();
    trigger_error('setHintMetrics requires 1 arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setHintMetrics(Cairo\Hint\Metrics::METRICS_ON, 1);
    trigger_error('setHintMetrics requires only 1 arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setHintMetrics(array());
    trigger_error('setHintMetrics requires int');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Font\Options)#%d (0) {
}
Cairo\Font\Options::setHintMetrics() expects exactly 1 parameter, 0 given
Cairo\Font\Options::setHintMetrics() expects exactly 1 parameter, 2 given
Cairo\Font\Options::setHintMetrics() expects parameter 1 to be long, array given