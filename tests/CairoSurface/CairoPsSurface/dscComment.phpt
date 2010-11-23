--TEST--
Cairo\Surface\PS->dscComment() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PS(NULL, 50, 50);
var_dump($surface);

$surface->dscComment('%%Title: My excellent document');

/* Wrong number args */
try {
    $surface->dscComment();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->dscComment(1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->dscComment(array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\PS)#%d (0) {
}
Cairo\Surface\PS::dscComment() expects exactly 1 parameter, 0 given
Cairo\Surface\PS::dscComment() expects exactly 1 parameter, 2 given
Cairo\Surface\PS::dscComment() expects parameter 1 to be string, array given