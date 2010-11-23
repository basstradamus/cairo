--TEST--
new Cairo\Surface\PS [__construct() method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PS', Cairo::availableSurfaces())) die('skip - PS surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PS(NULL, 50, 50);
var_dump($surface);

$surface = new Cairo\Surface\PS(dirname(__FILE__) . '/nametest.ps', 50, 50);
var_dump($surface);

$fp = fopen(dirname(__FILE__) . '/streamtest.ps', 'wb');
$surface = new Cairo\Surface\PS($fp, 50, 50);
var_dump($surface);

/* Wrong number args - 1 */
try {
    new Cairo\Surface\PS();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    new Cairo\Surface\PS(NULL);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    new Cairo\Surface\PS(NULL, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Surface\PS(NULL, 1, 1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Surface\PS(array(), 1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Surface\PS(NULL, array(), 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Cairo\Surface\PS(NULL, 1, array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/nametest.ps');
unlink(dirname(__FILE__) . '/streamtest.ps');
?>
--EXPECTF--
object(Cairo\Surface\PS)#%d (0) {
}
object(Cairo\Surface\PS)#%d (0) {
}
object(Cairo\Surface\PS)#%d (0) {
}
Cairo\Surface\PS::__construct() expects exactly 3 parameters, 0 given
Cairo\Surface\PS::__construct() expects exactly 3 parameters, 1 given
Cairo\Surface\PS::__construct() expects exactly 3 parameters, 2 given
Cairo\Surface\PS::__construct() expects exactly 3 parameters, 4 given
Cairo\Surface\PS::__construct() expects parameter 1 to be null, a string, or a stream resource
Cairo\Surface\PS::__construct() expects parameter 2 to be double, array given
Cairo\Surface\PS::__construct() expects parameter 3 to be double, array given