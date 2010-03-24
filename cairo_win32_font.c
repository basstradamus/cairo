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
  |           Mark Skilbeck <markskilbeck@php.net>                         |
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
#include "zend.h"

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

/** TODO: Add REGISTER_LONG_CONSTANT support
    The WinGdi.h definitions of these constants don't give them
    consistent prefixes, so we'll have to figure out a way of exposing
    them with better names. */
#define REGISTER_WIN32_LONG_CONST(ce, const_name, const_value) \
        zend_declare_class_constant_long(cairo_ce_##ce, const_name, sizeof(const_name) - 1, (long)const_value TSRMLS_CC); 
        
#define LFONT_FIND_LONG(name, defaultval) \
    if (zend_hash_find(Z_ARRVAL_P(font_options), #name, sizeof(#name), (void **)&tmp) == SUCCESS) { \
        if (Z_TYPE_PP(tmp) != IS_LONG) \
            zend_error(E_WARNING, "cairo_win32_font_face_create() expects key '"#name"' to be of type long"); \
        else \
            lfont.##name = Z_LVAL_PP(tmp); \
    } \
    else \
        lfont.##name = defaultval;
        
/** Same as before but casts return to BYTE */
#define LFONT_FIND_LONGB(name, defaultval) \
    if (zend_hash_find(Z_ARRVAL_P(font_options), #name, sizeof(#name), (void **)&tmp) == SUCCESS) { \
        if (Z_TYPE_PP(tmp) != IS_LONG) \
            zend_error(E_WARNING, "cairo_win32_font_face_create() expects key '"#name"' to be of type long"); \
        else \
            lfont.##name = (BYTE)Z_LVAL_PP(tmp); \
    } \
    else \
        lfont.##name = (BYTE)defaultval;
            
#define LFONT_FIND_BOOL(name, defaultval) \
    if (zend_hash_find(Z_ARRVAL_P(font_options), #name, sizeof(#name), (void **)&tmp) == SUCCESS) { \
        if (Z_TYPE_PP(tmp) != IS_BOOL) \
            zend_error(E_WARNING, "cairo_win32_font_face_create() expects key '"#name"' to be of type bool"); \
        else \
            lfont.##name = Z_BVAL_PP(tmp); \
    } \
    else \
        lfont.##name = defaultval;

zend_class_entry *cairo_ce_cairowin32font;
/** These classes are containers for constants defined in WinGdi.h, etc. */
zend_class_entry *cairo_ce_cairowin32fontweight;
zend_class_entry *cairo_ce_cairowin32fontcharset;
/** output precision constants */
zend_class_entry *cairo_ce_cairowin32fontoutprec;
/** clip precision constants */
zend_class_entry *cairo_ce_cairowin32fontclipprec;
zend_class_entry *cairo_ce_cairowin32fontquality;
zend_class_entry *cairo_ce_cairowin32fontpitch;
zend_class_entry *cairo_ce_cairowin32fontfamily;

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
    LOGFONT     lfont;
    HFONT       hfont;
    zval        *font_options = NULL;
    zval        **tmp;
    char        *font_name = NULL;          

    PHP_CAIRO_ERROR_HANDLING(FALSE)
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|a", &font_options) == FAILURE) {
        PHP_CAIRO_RESTORE_ERRORS(FALSE)
        return;
    }
    PHP_CAIRO_RESTORE_ERRORS(FALSE)

    if (font_options) {
        /** Find values in font_options array and set them. Otherwise set defaults */
        LFONT_FIND_LONG(lfHeight, 0);
        LFONT_FIND_LONG(lfWidth, 0);
        LFONT_FIND_LONG(lfWeight, FW_DONTCARE);
        LFONT_FIND_LONG(lfOrientation, 0);
        LFONT_FIND_BOOL(lfItalic, FALSE);
        LFONT_FIND_BOOL(lfUnderline, FALSE);
        LFONT_FIND_BOOL(lfStrikeOut, FALSE);
        LFONT_FIND_LONGB(lfCharSet, DEFAULT_CHARSET);
        LFONT_FIND_LONGB(lfOutPrecision, OUT_DEFAULT_PRECIS);
        LFONT_FIND_LONGB(lfClipPrecision, CLIP_DEFAULT_PRECIS);
        LFONT_FIND_LONGB(lfQuality, DEFAULT_QUALITY);
        LFONT_FIND_LONGB(lfPitchAndFamily, FIXED_PITCH | FF_DONTCARE);
        
        if (zend_hash_find(Z_ARRVAL_P(font_options), "lfFaceName", sizeof("lfFaceName"), (void **)&tmp) == SUCCESS) {
            if (Z_TYPE_PP(tmp) != IS_STRING) {
                zend_error(E_WARNING, "cairo_win32_font_face_create() expects key 'lfFaceName' to be of type string");
            } else {
                lstrcpy(lfont.lfFaceName, Z_STRVAL_PP(tmp));
            }
        } else {
            lstrcpy(lfont.lfFaceName, "");
        }
        
    } else {
        /** Arbitrary defaults */
        lfont.lfHeight = 24;
        lfont.lfWidth = 12;
        lfont.lfOrientation = 0;
        lfont.lfEscapement = 0;
        lfont.lfWeight = FW_NORMAL;
        lfont.lfItalic = FALSE;
        lfont.lfUnderline = FALSE;
        lfont.lfStrikeOut = FALSE;
        lfont.lfCharSet = OEM_CHARSET;
        lfont.lfOutPrecision = 0;
        lfont.lfClipPrecision = 0;
        lfont.lfQuality = DEFAULT_QUALITY;
        lfont.lfPitchAndFamily = FIXED_PITCH | FF_DONTCARE;
        lstrcpy(lfont.lfFaceName, "");
    }    
    
    hfont = CreateFontIndirect(&lfont);

    object_init_ex(return_value, cairo_ce_cairowin32font);
    font_face = (cairo_win32_font_face_object *)zend_object_store_get_object(return_value TSRMLS_CC);
    font_face->font_face = cairo_win32_font_face_create_for_hfont(hfont);

    PHP_CAIRO_ERROR(cairo_font_face_status(font_face->font_face));
}

/* {{{ proto CairoWin32FontFace::__construct([array font_options])
       Creates a new font face for the Win32 backend */
PHP_METHOD(CairoWin32FontFace, __construct)
{
    cairo_win32_font_face_object *font_face;
    LOGFONT     lfont;
    HFONT       hfont;
    zval        *font_options = NULL;
    zval        **tmp;
    char        *font_name = NULL;          

    PHP_CAIRO_ERROR_HANDLING(TRUE)
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|a", &font_options) == FAILURE) {
        PHP_CAIRO_RESTORE_ERRORS(TRUE)
        return;
    }
    PHP_CAIRO_RESTORE_ERRORS(TRUE)

    if (font_options) {
        /** Find values in font_options array and set them. Otherwise set defaults */
        LFONT_FIND_LONG(lfHeight, 0);
        LFONT_FIND_LONG(lfWidth, 0);
        LFONT_FIND_LONG(lfWeight, FW_DONTCARE);
        LFONT_FIND_LONG(lfOrientation, 0);
        LFONT_FIND_BOOL(lfItalic, FALSE);
        LFONT_FIND_BOOL(lfUnderline, FALSE);
        LFONT_FIND_BOOL(lfStrikeOut, FALSE);
        LFONT_FIND_LONGB(lfCharSet, DEFAULT_CHARSET);
        LFONT_FIND_LONGB(lfOutPrecision, OUT_DEFAULT_PRECIS);
        LFONT_FIND_LONGB(lfClipPrecision, CLIP_DEFAULT_PRECIS);
        LFONT_FIND_LONGB(lfQuality, DEFAULT_QUALITY);
        LFONT_FIND_LONGB(lfPitchAndFamily, FIXED_PITCH | FF_DONTCARE);

        if (zend_hash_find(Z_ARRVAL_P(font_options), "lfFaceName", sizeof("lfFaceName"), (void **)&tmp) == SUCCESS) {
            if (Z_TYPE_PP(tmp) != IS_STRING) {
                zend_error(E_WARNING, "cairo_win32_font_face_create() expects key 'lfFaceName' to be of type string");
            } else {
                lstrcpy(lfont.lfFaceName, Z_STRVAL_PP(tmp));
            }
        } else {
            lstrcpy(lfont.lfFaceName, "");
        }

    } else {
        /** Arbitrary defaults */
        lfont.lfHeight = 0;
        lfont.lfWidth = 0;
        lfont.lfOrientation = 0;
        lfont.lfEscapement = 0;
        lfont.lfWeight = FW_NORMAL;
        lfont.lfItalic = FALSE;
        lfont.lfUnderline = TRUE;
        lfont.lfStrikeOut = FALSE;
        lfont.lfCharSet = OEM_CHARSET;
        lfont.lfOutPrecision = 0;
        lfont.lfClipPrecision = 0;
        lfont.lfQuality = DEFAULT_QUALITY;
        lfont.lfPitchAndFamily = FIXED_PITCH | FF_DONTCARE;
        lstrcpy(lfont.lfFaceName, "");
    }    

    hfont = CreateFontIndirect(&lfont);

    font_face = (cairo_win32_font_face_object *)zend_object_store_get_object(getThis() TSRMLS_CC);
    font_face->font_face = cairo_win32_font_face_create_for_hfont(hfont);

    php_cairo_throw_exception(cairo_font_face_status(font_face->font_face) TSRMLS_CC);
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

    efree(font_face);
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
    /** These classes are containers for constants defined in WinGdi.h, etc. */
    zend_class_entry ce_cairowin32fontweight;
    zend_class_entry ce_cairowin32fontcharset;
    /** output precision constants */
    zend_class_entry ce_cairowin32fontoutprec;
    /** clip precision constants */
    zend_class_entry ce_cairowin32fontclipprec;
    zend_class_entry ce_cairowin32fontquality;
    zend_class_entry ce_cairowin32fontpitch;
    zend_class_entry ce_cairowin32fontfamily;

    INIT_CLASS_ENTRY(ce, "CairoWin32FontFace", cairo_win32_font_methods);
    cairo_ce_cairowin32font = zend_register_internal_class_ex(
        &ce, cairo_ce_cairofontface, "CairoFontFace" TSRMLS_CC);
    /** So Zend knows what function to call when a new CairoWin32FontFace
        is requested */
    cairo_ce_cairowin32font->create_object = cairo_win32_font_face_create_new;

    /** Commence BORING constant definitions! */
    INIT_CLASS_ENTRY(ce_cairowin32fontweight, "CairoWin32FontWeight", NULL);
    cairo_ce_cairowin32fontweight = zend_register_internal_class(&ce_cairowin32fontweight TSRMLS_CC);
    cairo_ce_cairowin32fontweight->ce_flags |= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS | ZEND_ACC_FINAL_CLASS;
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "NORMAL", FW_NORMAL);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "DONTCARE", FW_DONTCARE);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "THIN", FW_THIN);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "EXTRALIGHT", FW_EXTRALIGHT);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "ULTRALIGHT", FW_ULTRALIGHT);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "LIGHT", FW_LIGHT);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "REGULAR", FW_REGULAR);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "MEDIUM", FW_MEDIUM);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "SEMIBOLD", FW_SEMIBOLD);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "DEMIBOLD", FW_DEMIBOLD);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "BOLD", FW_BOLD);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "EXTRABOLD", FW_EXTRABOLD);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "ULTRABOLD", FW_ULTRABOLD);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "HEAVY", FW_HEAVY);
    REGISTER_WIN32_LONG_CONST(cairowin32fontweight, "BLACK", FW_BLACK);

    INIT_CLASS_ENTRY(ce_cairowin32fontcharset, "CairoWin32FontCharset", NULL);
    cairo_ce_cairowin32fontcharset = zend_register_internal_class(&ce_cairowin32fontcharset TSRMLS_CC);
    cairo_ce_cairowin32fontcharset->ce_flags |= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS | ZEND_ACC_FINAL_CLASS;
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "ANSI", ANSI_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "BALTIC", BALTIC_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "CHINESEBIG5", CHINESEBIG5_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "DEFAULT", DEFAULT_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "EASTEUROPE", EASTEUROPE_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "GB2312", GB2312_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "GREEK", GREEK_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "HANGUL", HANGUL_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "MAC", MAC_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "OEM", OEM_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "RUSSIAN", RUSSIAN_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "SHIFTJIS", SHIFTJIS_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "SYMBOL", SYMBOL_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "TURKISH", TURKISH_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "VIETNAMESE", VIETNAMESE_CHARSET);
#if(WINVER >= 0x0400)
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "JOHAB", JOHAB_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "ARABIC", ARABIC_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "HEBREW", HEBREW_CHARSET);
    REGISTER_WIN32_LONG_CONST(cairowin32fontcharset, "THAI", THAI_CHARSET);
#endif /** WINVER */

    INIT_CLASS_ENTRY(ce_cairowin32fontoutprec, "CairoWin32FontOutputPrecision", NULL);
    cairo_ce_cairowin32fontoutprec = zend_register_internal_class(&ce_cairowin32fontoutprec TSRMLS_CC);
    cairo_ce_cairowin32fontoutprec->ce_flags |= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS | ZEND_ACC_FINAL_CLASS;
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "CHARACTER", OUT_CHARACTER_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "DEFAULT", OUT_DEFAULT_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "DEVICE", OUT_DEVICE_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "OUTLINE", OUT_OUTLINE_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "PS_ONLY", OUT_PS_ONLY_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "RASTER", OUT_RASTER_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "STRING", OUT_STRING_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "STROKE", OUT_STROKE_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "TT_ONLY", OUT_TT_ONLY_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontoutprec, "TT", OUT_TT_PRECIS);

    INIT_CLASS_ENTRY(ce_cairowin32fontclipprec, "CairoWin32FontClipPrecision", NULL);
    cairo_ce_cairowin32fontclipprec = zend_register_internal_class(&ce_cairowin32fontclipprec TSRMLS_CC);
    cairo_ce_cairowin32fontclipprec->ce_flags |= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS | ZEND_ACC_FINAL_CLASS;
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "CHARACTER", CLIP_CHARACTER_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "DEFAULT", CLIP_DEFAULT_PRECIS);
#if (_WIN32_WINNT >= _WIN32_WINNT_LONGHORN)
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "DFA_DISABLE", CLIP_DFA_DISABLE);
#endif /** _WIN32_WINNT >= _WIN32_WINNT_LONGHORN */
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "EMBEDDED", CLIP_EMBEDDED);
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "LH_ANGLES", CLIP_LH_ANGLES);
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "MASK", CLIP_MASK);
#if (_WIN32_WINNT >= _WIN32_WINNT_LONGHORN)
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "DFA_OVERRIDE", CLIP_DFA_OVERRIDE);
#endif /** _WIN32_WINNT >= _WIN32_WINNT_LONGHORN */
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "STROKE", CLIP_STROKE_PRECIS);
    REGISTER_WIN32_LONG_CONST(cairowin32fontclipprec, "TT_ALWAYS", CLIP_TT_ALWAYS);

    INIT_CLASS_ENTRY(ce_cairowin32fontquality, "CairoWin32FontQuality", NULL);
    cairo_ce_cairowin32fontquality = zend_register_internal_class(&ce_cairowin32fontquality TSRMLS_CC);
    cairo_ce_cairowin32fontquality->ce_flags |= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS | ZEND_ACC_FINAL_CLASS;
    REGISTER_WIN32_LONG_CONST(cairowin32fontquality, "ANTIALIASED", ANTIALIASED_QUALITY);
    REGISTER_WIN32_LONG_CONST(cairowin32fontquality, "CLEARTYPE", CLEARTYPE_QUALITY);
    REGISTER_WIN32_LONG_CONST(cairowin32fontquality, "DEFAULT", DEFAULT_QUALITY);
    REGISTER_WIN32_LONG_CONST(cairowin32fontquality, "DRAFT", DRAFT_QUALITY);
    REGISTER_WIN32_LONG_CONST(cairowin32fontquality, "NONANTIALIASED", NONANTIALIASED_QUALITY);
    REGISTER_WIN32_LONG_CONST(cairowin32fontquality, "PROOF", PROOF_QUALITY);

    INIT_CLASS_ENTRY(ce_cairowin32fontpitch, "CairoWin32FontPitch", NULL);
    cairo_ce_cairowin32fontpitch = zend_register_internal_class(&ce_cairowin32fontpitch TSRMLS_CC);
    cairo_ce_cairowin32fontpitch->ce_flags |= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS | ZEND_ACC_FINAL_CLASS;
    REGISTER_WIN32_LONG_CONST(cairowin32fontpitch, "DEFAULT", DEFAULT_PITCH);
    REGISTER_WIN32_LONG_CONST(cairowin32fontpitch, "FIXED", FIXED_PITCH);
    REGISTER_WIN32_LONG_CONST(cairowin32fontpitch, "VARIABLE", VARIABLE_PITCH);

    INIT_CLASS_ENTRY(ce_cairowin32fontfamily, "CairoWin32FontFamily", NULL);
    cairo_ce_cairowin32fontfamily = zend_register_internal_class(&ce_cairowin32fontfamily TSRMLS_CC);
    cairo_ce_cairowin32fontfamily->ce_flags |= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS | ZEND_ACC_FINAL_CLASS;
    REGISTER_WIN32_LONG_CONST(cairowin32fontfamily, "DECORATIVE", FF_DECORATIVE);
    REGISTER_WIN32_LONG_CONST(cairowin32fontfamily, "DONTCARE", FF_DONTCARE);
    REGISTER_WIN32_LONG_CONST(cairowin32fontfamily, "MODERN", FF_MODERN);
    REGISTER_WIN32_LONG_CONST(cairowin32fontfamily, "ROMAN", FF_ROMAN);
    REGISTER_WIN32_LONG_CONST(cairowin32fontfamily, "SCRIPT", FF_SCRIPT);
    REGISTER_WIN32_LONG_CONST(cairowin32fontfamily, "SWISS", FF_SWISS);

    return SUCCESS;
}

#endif /** CAIRO_HAS_WIN32_FONT */
