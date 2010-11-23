--TEST--
CairoWin32Fontface::__construct() function
--SKIPIF--
<?php
if(!extension_loaded('cairo'))
	die('skip - Cairo extension not available');
if(!class_exists('Cairo\FontFace\Win32'))
	die('skip - Cairo\FontFace\Win32 class not available');
?>
--FILE--
<?php
$f_opts = array (
	'lfWeight' => Cairo\FontFace\Win32\Weight::BOLD,
	'lfFaceName' => 'Impact'
);

// Test with no params
$f = new Cairo\FontFace\Win32;
var_dump($f);

// Test with all params
$f = new Cairo\FontFace\Win32($f_opts);
var_dump($f);

// Test with incorrect param
try {
	$f = new Cairo\FontFace\Win32('not an array');
} catch (Cairo\Exception $e) {
	echo $e->getMessage(), PHP_EOL;
}

// Test with too many params
try {
	$f = new Cairo\FontFace\Win32($f_opts, '2nd param');
} catch (Cairo\Exception $e) {
	echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Win32)#%d (0) {
}
object(Cairo\FontFace\Win32)#%d (0) {
}
Cairo\FontFace\Win32::__construct() expects parameter 1 to be array, string given
Cairo\FontFace\Win32::__construct() expects at most 1 parameter, 2 given
