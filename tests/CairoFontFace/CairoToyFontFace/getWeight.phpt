--TEST--
Cairo\FontFace\Toy::getWeight() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!class_exists('Cairo\FontFace\Toy')) die('skip - Cairo\FontFace\Toy not enabled');
?>
--FILE--
<?php
// Test with all parameters
$c = new Cairo\FontFace\Toy("sans-serif", Cairo\Font\Weight::NORMAL, Cairo\Font\Weight::NORMAL);
var_dump($c->getWeight());

$c = new Cairo\FontFace\Toy("sans-serif", Cairo\Font\Weight::NORMAL, Cairo\Font\Weight::BOLD);
var_dump($c->getWeight());
?>
--EXPECTF--
int(0)
int(1)
