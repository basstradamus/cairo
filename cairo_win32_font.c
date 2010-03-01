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

PHP_FUNCTION(cairo_win32_font_face_create)
{
	
	
	return;
}

/** The zend_function_entry's are in php_cairo.h and cairo.c */

PHP_MINIT_FUNCTION(cairo_win32_font)
{

	return SUCCESS;
}

#endif /** CAIRO_HAS_WIN32_FONT */