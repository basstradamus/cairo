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
/** The zend_function_entry's are in php_cairo.h and cairo.c */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <cairo.h>
#include "php.h"
#include "php_cairo.h"
#include "zend_exceptions.h"

#ifdef CAIRO_HAS_WIN32_FONT
#include <Windows.h>
#include <Wingdi.h>
#include <cairo/cairo-win32.h>

/** Not sure why these are not being defined in Wingdi.h 
	Must investigate */
#ifndef CLEARTYPE_QUALITY
# define CLEARTYPE_QUALITY 5
#endif
#ifndef CLEARTYPE_NATURAL_QUALITY
# define CLEARTYPE_NATURAL_QUALITY 6
#endif

zend_class_entry *cairo_ce_cairowin32font;

/**
 * CairoWin32FontFace::__construct takes 1 optional argument
 */
ZEND_BEGIN_ARG_INFO_EX(CairoWin32FontFace_construct_args, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 0)
	ZEND_ARG_ARRAY_INFO(0, "font_options", 1)
ZEND_END_ARG_INFO()


/* {{{ proto CairoWin32FontFace cairo_win32_font_face_create([array font_options])
	   Creates a new font face for the Win32 backend */
PHP_FUNCTION(cairo_win32_font_face_create)
{
	cairo_win32_font_face_object *font_face;
	HashTable	*font_options;
	LOGFONT 	lfont;
	HFONT		hfont;
	
	/** just testing - ignore this :P */
	hfont = CreateFont(48, 0, 0, 0, FW_DONTCARE, FALSE, TRUE, FALSE, DEFAULT_CHARSET,
						OUT_OUTLINE_PRECIS, CLIP_DEFAULT_PRECIS, CLEARTYPE_QUALITY,
						VARIABLE_PITCH, TEXT("Impact"));

	object_init_ex(return_value, cairo_ce_cairowin32font);
	font_face = (cairo_win32_font_face_object *)zend_object_store_get_object(return_value TSRMLS_CC);
	font_face->font_face = (cairo_font_face_t *)cairo_win32_font_face_create_for_hfont(hfont);

	PHP_CAIRO_ERROR(cairo_font_face_status(font_face->font_face));
}

/* {{{ proto CairoWin32FontFace::__construct([array font_options])
	   Creates a new font face for the Win32 backend */
PHP_METHOD(CairoWin32FontFace, __construct)
{

}
/* }}} */

static function_entry cairo_win32_font_methods[] = {
	PHP_ME(CairoWin32FontFace, __construct, CairoWin32FontFace_construct_args, \
		ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	{NULL, NULL, NULL}
};

static void cairo_win32_font_face_object_destroy(void *object TSRMLS_DC)
{
	cairo_win32_font_face_object *font_face = (cairo_win32_font_face_object *)object;
	/** Frees the contents of the hashtable */
	zend_hash_destroy(font_face->std.properties);
	/** Frees the hashtable itself */
	FREE_HASHTABLE(font_face->std.properties);
	
	if (font_face->font_face)
		cairo_font_face_destroy(font_face->font_face);
		
	//efree(font_face);
}

/**
 * Called by init_object_ex() to create the new object.
 */
zend_object_value cairo_win32_font_face_create_new(zend_class_entry *ce TSRMLS_DC)
{
	zend_object_value retval;
	cairo_win32_font_face_object *font_face;
	zval *temp;
	
	font_face = ecalloc(1, sizeof(cairo_win32_font_face_object));
	font_face->std.ce = ce;
	
	ALLOC_HASHTABLE(font_face->std.properties);
	zend_hash_init(font_face->std.properties, 0, NULL, ZVAL_PTR_DTOR, 0);
	zend_hash_copy(
		font_face->std.properties, 
		&ce->default_properties, 
		(copy_ctor_func_t) zval_add_ref,(void *) 
		&temp, sizeof(zval *)
	);
	retval.handle = zend_objects_store_put(
		font_face, NULL, 
		(zend_objects_free_object_storage_t)cairo_win32_font_face_object_destroy, 
		NULL TSRMLS_CC
	);
	retval.handlers = zend_get_std_object_handlers();
	return retval;
}


PHP_MINIT_FUNCTION(cairo_win32_font)
{
	zend_class_entry ce;
	
	INIT_CLASS_ENTRY(ce, "CairoWin32FontFace", cairo_win32_font_methods);
	cairo_ce_cairowin32font = zend_register_internal_class_ex(
		&ce, cairo_ce_cairofontface, "CairoFontFace" TSRMLS_CC);
	/** So Zend knows what function to call when a new CairoWin32FontFace
		is requested */
	cairo_ce_cairowin32font->create_object = cairo_win32_font_face_create_new;
	return SUCCESS;
}

#endif /** CAIRO_HAS_WIN32_FONT */
