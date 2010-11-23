--TEST--
Cairo\Font\Slant class constants
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$constants = array(
	'NORMAL',
	'ITALIC',
	'OBLIQUE',
	);
$error = false;
foreach($constants as $name) {
	if (!defined('Cairo\Font\Slant::' . $name)) {
		$error = true;
		echo 'Missing Constant: Cairo\Font\Slant::' . $name . "\n";
	}
}
if (!$error) {
	echo "No missing constants, checked " . sizeof($constants) . "!\n";
}
echo "Done\n";
?>
--EXPECT--
No missing constants, checked 3!
Done