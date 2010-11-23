--TEST--
Cairo\Font\Options->setHintStyle() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\Font\Options();
var_dump($options);

$options->setHintStyle(Cairo\Hint\Style::STYLE_FULL);

/* Wrong number args 1*/
try {
    $options->setHintStyle();
    trigger_error('setHintStyle requires 1 arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setHintStyle(Cairo\Hint\Style::STYLE_FULL, 1);
    trigger_error('setHintStyle requires only 1 arg');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setHintStyle(array());
    trigger_error('setHintStyle requires int');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Font\Options)#%d (0) {
}
Cairo\Font\Options::setHintStyle() expects exactly 1 parameter, 0 given
Cairo\Font\Options::setHintStyle() expects exactly 1 parameter, 2 given
Cairo\Font\Options::setHintStyle() expects parameter 1 to be long, array given