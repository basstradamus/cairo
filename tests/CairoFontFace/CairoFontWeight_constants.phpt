--TEST--
Cairo\Font\Weight class constants
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$constants = array(
	'NORMAL',
	'BOLD',
	);

$error = false;
foreach($constants as $name) {
	if (!defined('Cairo\Font\Weight::' . $name)) {
		$error = true;
		echo 'Missing Constant: Cairo\Font\Weight::' . $name . "\n";
	}
}

if (!$error) {
	echo "No missing constants, checked " . sizeof($constants) . "!\n";
}
echo "Done\n";
?>
--EXPECT--
No missing constants, checked 2!
Done