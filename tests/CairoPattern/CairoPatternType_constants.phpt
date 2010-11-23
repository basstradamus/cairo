--TEST--
Cairo\Pattern\Type class constants
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$constants = array(
	'SOLID',
	'SURFACE',
	'LINEAR',
	'RADIAL',
	);

foreach($constants as $name) {
	var_dump(defined('Cairo\Pattern\Type::' . $name));
}
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)