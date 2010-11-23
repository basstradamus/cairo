--TEST--
Cairo\Filter class constants
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$constants = array(
	'FAST',
	'GOOD',
	'BEST',
	'NEAREST',
	'BILINEAR',
	'GAUSSIAN',
	);

foreach($constants as $name) {
	var_dump(defined('Cairo\Filter::' . $name));
}
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)