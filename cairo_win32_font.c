/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2009 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author: Elizabeth Smith <auroraeosrose@php.net>                      |
  |         Michael Maclean <mgdm@php.net>                               |
  |         Akshat Gupta <g.akshat@gmail.com>                            |
  |   		Mark Skilbeck <markskilbeck@php.net>						 |
  +----------------------------------------------------------------------+
*/

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <cairo.h>
#include "php.h"
#include "php_cairo.h"
#include "zend_exceptions.h"

#ifdef CAIRO_HAS_WIN32_FONT
#include <Wingdi.h>
#include <cairo/cairo-win32.h>

zend_class_entry *cairo_ce_cairowin32font;

ZEND_BEGIN_ARG_INFO_EX(CairoFtFontFace_construct_args, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 0)
	ZEND_ARG_ARRAY_INFO(0, "font_options", 1)
ZEND_END_ARG_INFO()


/* {{{ proto CairoWin32FontFace cairo_win32_font_face_create([array font_options])
	   Creates a new font face for the Win32 backend */
PHP_FUNCTION(cairo_win32_font_face_create)
{
	HashTable *font_options;
	LOGFONT lfont;
	HFTON	hfont;
	
	/** just testing - ignore this :P */
	hfont = CreateFont(48, 0, 0, 0, FW_DONTCARE, FALSE, TRUE, FALSE, DEFAULT_CHARSET,
						OUT_OUTLINE_PRECIS, CLIP_DEFAULT_PRECIS, CLEARTYPE_QUALITY,
						VARIABLE_PITCH, TEXT("Impact"));
	
	return;
}

PHP_METHOD(CairoWin32FontFace, __construct)
{
	
}

static function_entry cairo_win32_font_methods[] = {
	PHP_ME(CairoWin32FontFace, __construct, CairoWin32FontFace_construct_args, \
		ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	{NULL, NULL, NULL}
};

zend_object_value cairo_win32_font_face_create_new(

/** The zend_function_entry's are in php_cairo.h and cairo.c */

PHP_MINIT_FUNCTION(cairo_win32_font)
{
	zend_class_entry ce;
	
	INIT_CLASS_ENTRY(ce, "CairoWin32FontFace", cairo_fe_win32font);
	cairo_ce_cairowin32font = zend_register_internal_class_ex(
		&ce, cairo_ce_cairofontface, "CairoFontFace" TSRMLS_CC);
	return SUCCESS;
}

#endif /** CAIRO_HAS_WIN32_FONT */