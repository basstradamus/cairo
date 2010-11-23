--TEST--
cairo_ft_font_face_create() function
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!function_exists('cairo_ft_font_face_create')) die('skip - cairo_ft_font_face_create not available');
?>
--FILE--
<?php
$fontFile = dirname(__FILE__) . "/Vera.ttf";

// Test with 1 param
$c = new Cairo\FontFace\FreeType($fontFile);
var_dump($c);

// test with 2 params
$c = new Cairo\FontFace\FreeType($fontFile, 0);
var_dump($c);

// We shouldn't accept 0 args
try {
    $c = new Cairo\FontFace\FreeType();
} catch (Cairo\Exception $e) {
    var_dump($e->getMessage());
}
var_dump($c);

// Test with 1 param
try {
    $c = new Cairo\FontFace\FreeType("NotARealFont");
} catch (Cairo\Exception $e) {
    var_dump($e->getMessage());
}
var_dump($c);

// Test with a silly param
try {
    $c = new Cairo\FontFace\FreeType(array());
} catch (Cairo\Exception $e) {
    var_dump($e->getMessage());
}
var_dump($c); 

// Test with a broken font
try {
    $c = new Cairo\FontFace\FreeType(dirname(__FILE__) . '/broken.ttf');
} catch (Cairo\Exception $e) {
    var_dump($e->getMessage());
}
var_dump($c);
?>
--EXPECTF--
object(Cairo\FontFace\FreeType)#1 (0) {
}
object(Cairo\FontFace\FreeType)#2 (0) {
}
string(%d) "Cairo\FontFace\FreeType::__construct() expects at least 1 parameter, 0 given"
object(Cairo\FontFace\FreeType)#2 (0) {
}
string(%d) "Cairo\FontFace\FreeType::__construct(NotARealFont): failed to open stream: No such file or directory"
object(Cairo\FontFace\FreeType)#2 (0) {
}
string(%d) "Cairo\FontFace\FreeType::__construct() expects parameter 1 to be a string or a stream resource"
object(Cairo\FontFace\FreeType)#2 (0) {
}
string(%d) "Cairo\FontFace\FreeType::__construct(): An error occurred opening the file"
object(Cairo\FontFace\FreeType)#2 (0) {
}
