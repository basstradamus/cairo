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

#ifdef CAIRO_HAS_FT_FONT
#include <fontconfig/fontconfig.h>
#include <ft2build.h>
#include FT_FREETYPE_H

zend_class_entry *cairo_ce_cairoftfont;

ZEND_BEGIN_ARG_INFO_EX(CairoFtFontFace_construct_args, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 1)
	ZEND_ARG_INFO(0, face)
	ZEND_ARG_INFO(0, load_flags)
ZEND_END_ARG_INFO()

/* {{{ proto CairoFtFontFace cairo_ft_font_face_create(string face, long load_flags)
	   Creates a new font face for the FreeType font backend from a pre-opened FreeType face. */

/* FIXME: Adapt this to use streams, to handle open_basedir etc */
PHP_FUNCTION(cairo_ft_font_face_create)
{
	FT_Face face = (FT_Face) NULL;
	FT_Library *ft_lib;
	long load_flags = 0;	
	char *font_name;
	int error = 0;
	long font_name_length = 0;
	zval *font_face_zval = NULL;
	cairo_font_face_object *font_face_object;
	

	PHP_CAIRO_ERROR_HANDLING(FALSE)
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s|l",
				&font_name, &font_name_length, &load_flags) == FAILURE)
	{
		PHP_CAIRO_RESTORE_ERRORS(FALSE)
		return;
	}
	PHP_CAIRO_RESTORE_ERRORS(FALSE)
	
	ft_lib = &CAIROG(ft_lib);
	if(*ft_lib == NULL) {
		error = FT_Init_FreeType(ft_lib);
		if(error) {
			//PHP_CAIRO_ERROR("Failed to initialize FreeType library");
			return;
		}
	}

	/* FIXME: hard coding open first face, will change to allow it to be selected */
	error = FT_New_Face(*ft_lib, font_name, 0, &face);
	if(error == FT_Err_Unknown_File_Format) { 
		//PHP_CAIRO_ERROR("Unknown font file format");
		return;
	} else if ( error ) { 
		//PHP_CAIRO_ERROR("An error occurred opening the file");
		return;
	} 

	object_init_ex(return_value, cairo_ce_cairoftfont);
	font_face_object = (cairo_font_face_object *)zend_object_store_get_object(return_value TSRMLS_CC);	
	font_face_object->font_face = cairo_ft_font_face_create_for_ft_face(face, (int)load_flags);
	//PHP_CAIRO_ERROR(cairo_font_face_status(font_face_object->font_face));
}

/* }}} */


/* {{{ proto CairoFtFontFace::__construct(string fontFilename, long load_flags)
	   Creates a new font face for the FreeType font backend from a pre-opened FreeType face. */

/* FIXME: Adapt this to use streams, to handle open_basedir etc */
PHP_METHOD(CairoFtFontFace, __construct)
{
	FT_Face face = (FT_Face) NULL;
	FT_Library *ft_lib;
	long load_flags = 0;	
	char *font_name;
	int error = 0;
	long font_name_length = 0;
	zval *font_face_zval = NULL;
	cairo_font_face_object *font_face_object;
	

	PHP_CAIRO_ERROR_HANDLING(FALSE)
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s|l",
				&font_name, &font_name_length, &load_flags) == FAILURE)
	{
		PHP_CAIRO_RESTORE_ERRORS(FALSE)
		return;
	}
	PHP_CAIRO_RESTORE_ERRORS(FALSE)
	
	ft_lib = &CAIROG(ft_lib);
	if(*ft_lib == NULL) {
		error = FT_Init_FreeType(ft_lib);
		if(error) {
			zend_throw_exception(cairo_ce_cairoexception, "Failed to initalise FreeType library", 0 TSRMLS_CC);
			return;
		}
	}

	/* FIXME: hard coding open first face, will change to allow it to be selected */
	error = FT_New_Face(*ft_lib, font_name, 0, &face);
	if(error == FT_Err_Unknown_File_Format) { 
		zend_throw_exception(cairo_ce_cairoexception, "CairoFtFontFace: unknown file format", 0 TSRMLS_CC);
		return;
		zend_throw_exception(cairo_ce_cairoexception, "An error occurred opening the file", 0 TSRMLS_CC);
		return;
	} 

	font_face_object = (cairo_font_face_object *)zend_object_store_get_object(getThis() TSRMLS_CC);	
	font_face_object->font_face = cairo_ft_font_face_create_for_ft_face(face, (int)load_flags);
	php_cairo_throw_exception(cairo_font_face_status(font_face_object->font_face) TSRMLS_CC);
}

/* }}} */

/* {{{ cairo_ft_font_methods */
const zend_function_entry cairo_ft_font_methods[] = {
	PHP_ME(CairoFtFontFace, __construct, CairoFtFontFace_construct_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	{NULL, NULL, NULL}
};

/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_ft_font)
{
	zend_class_entry ftfont_ce;

	INIT_CLASS_ENTRY(ftfont_ce, "CairoFtFontFace", cairo_ft_font_methods);
	cairo_ce_cairoftfont = zend_register_internal_class_ex(&ftfont_ce, cairo_ce_cairofontface, "CairoFontFace" TSRMLS_CC);
	cairo_ce_cairoftfont->create_object = cairo_font_face_object_new;

	return SUCCESS;
}

#endif

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
