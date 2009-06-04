--TEST--
CairoContext->setSourceSurface() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new CairoImageSurface(CAIRO_FORMAT_ARGB32, 50, 50);
var_dump($surface);

$context = new CairoContext($surface);
var_dump($context);

$surface2 = new CairoImageSurface(CAIRO_FORMAT_ARGB32, 50, 50);
var_dump($surface2);

$context->setSourceSurface($surface2, 5, 5);
?>
--EXPECTF--
object(CairoImageSurface)#%d (0) {
}
object(CairoContext)#%d (0) {
}
object(CairoImageSurface)#%d (0) {
}