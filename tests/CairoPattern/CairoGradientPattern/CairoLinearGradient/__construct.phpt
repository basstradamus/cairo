--TEST--
new Cairo\Pattern\Gradient\Linear [ __construct method ]
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$pattern = new Cairo\Pattern\Gradient\Linear(1, 2, 3, 4);
var_dump($pattern);

/* Wrong number args - requires 4 */
try {
    new Cairo\Pattern\Gradient\Linear();
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct with no args should fail');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Pattern\Gradient\Linear(1);
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct with 1 arg should fail');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Pattern\Gradient\Linear(1, 1);
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct with 2 args should fail');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Pattern\Gradient\Linear(1, 1, 1);
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct with 3 args should fail');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\Pattern\Gradient\Linear(1, 1, 1, 1, 1);
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct with 5 args should fail');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Cairo\Pattern\Gradient\Linear(array(), 1, 1, 1);
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct requires all doubles');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Cairo\Pattern\Gradient\Linear(1, array(), 1, 1);
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct requires all doubles');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Cairo\Pattern\Gradient\Linear(1, 1, array(), 1);
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct requires all doubles');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 4 */
try {
    new Cairo\Pattern\Gradient\Linear(1, 1, 1, array());
    trigger_error('Cairo\Pattern\Gradient\Linear::__construct requires all doubles');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Pattern\Gradient\Linear)#%d (0) {
}
Cairo\Pattern\Gradient\Linear::__construct() expects exactly 4 parameters, 0 given
Cairo\Pattern\Gradient\Linear::__construct() expects exactly 4 parameters, 1 given
Cairo\Pattern\Gradient\Linear::__construct() expects exactly 4 parameters, 2 given
Cairo\Pattern\Gradient\Linear::__construct() expects exactly 4 parameters, 3 given
Cairo\Pattern\Gradient\Linear::__construct() expects exactly 4 parameters, 5 given
Cairo\Pattern\Gradient\Linear::__construct() expects parameter 1 to be double, array given
Cairo\Pattern\Gradient\Linear::__construct() expects parameter 2 to be double, array given
Cairo\Pattern\Gradient\Linear::__construct() expects parameter 3 to be double, array given
Cairo\Pattern\Gradient\Linear::__construct() expects parameter 4 to be double, array given