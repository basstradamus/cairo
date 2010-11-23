--TEST--
new Cairo\Surface\PDF [__construct() method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!in_array('PDF', Cairo::availableSurfaces())) die('skip - PDF surface not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\PDF(NULL, 50, 50);
var_dump($surface);

$surface = new Cairo\Surface\PDF(dirname(__FILE__) . '/nametest.pdf', 50, 50);
var_dump($surface);

$fp = fopen(dirname(__FILE__) . '/streamtest.pdf', 'wb');
$surface = new Cairo\Surface\PDF($fp, 50, 50);
var_dump($surface);

/* Wrong number args - 1 */
try {
    new Cairo\Surface\PDF();
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    new Cairo\Surface\PDF(NULL);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    new Cairo\Surface\PDF(NULL, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Surface\PDF(NULL, 1, 1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Surface\PDF(array(), 1, 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Surface\PDF(NULL, array(), 1);
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Cairo\Surface\PDF(NULL, 1, array());
    trigger_error('We should bomb here');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--CLEAN--
<?php
unlink(dirname(__FILE__) . '/nametest.pdf');
unlink(dirname(__FILE__) . '/streamtest.pdf');
?>
--EXPECTF--
object(Cairo\Surface\PDF)#%d (0) {
}
object(Cairo\Surface\PDF)#%d (0) {
}
object(Cairo\Surface\PDF)#%d (0) {
}
Cairo\Surface\PDF::__construct() expects exactly 3 parameters, 0 given
Cairo\Surface\PDF::__construct() expects exactly 3 parameters, 1 given
Cairo\Surface\PDF::__construct() expects exactly 3 parameters, 2 given
Cairo\Surface\PDF::__construct() expects exactly 3 parameters, 4 given
Cairo\Surface\PDF::__construct() expects parameter 1 to be null, a string, or a stream resource
Cairo\Surface\PDF::__construct() expects parameter 2 to be double, array given
Cairo\Surface\PDF::__construct() expects parameter 3 to be double, array given