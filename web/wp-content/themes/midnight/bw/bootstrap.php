<?php

/*----------------------------------------------------*/
/*	Prints human-readable information about a variable
/*----------------------------------------------------*/
if( ! function_exists( 'd' ) ) {
    function d( $what ) {
        print '<pre>';
        print_r( $what );
        print '</pre>';
    }
}

/*----------------------------------------------------*/
/*	Define bw variables
/*----------------------------------------------------*/
/*get_template_directory():     Returns the absolute template directory path. 
get_template_directory_uri():   Returns the template directory URI. 
get_stylesheet_directory():     Returns the absolute stylesheet directory path. 
get_stylesheet_directory_uri(): Returns the stylesheet directory URI.*/
define('DS',                    DIRECTORY_SEPARATOR);
define('BW_ROOT',               get_template_directory().DS);
define('BW_FRAME_ROOT',         BW_ROOT.'bw'.DS);
define('BW_FRAME_CORE',         BW_FRAME_ROOT.'core'.DS);
define('BW_FRAME_ASSETS',       BW_FRAME_ROOT.'assets'.DS);
define('BW_FRAME_LIB',          BW_FRAME_ROOT.'lib'.DS);
define('BW_FRAME_PLUGINS',      BW_FRAME_ROOT.'plugins'.DS);
define('BW_FRAME_WIDGETS',      BW_FRAME_ROOT.'widgets'.DS);
define('BW_DEMO',               BW_FRAME_ROOT.'demo'.DS);

$bw_theme = wp_get_theme();
define( 'BW_VERSION',           $bw_theme->exists() ? $bw_theme->get('Version') : '1.0' );

define('BW_URI',                get_template_directory_uri() . '/');
define('BW_URI_ASSETS',         BW_URI.'assets/');
define('BW_URI_FRAME_ASSETS',   BW_URI.'bw/assets/');

# require core feature
require BW_FRAME_ROOT.'core/Bw.php';


/*----------------------------------------------------*/
/*	Dynamically load in all classes
/*----------------------------------------------------*/
Bw::require_all( array( BW_FRAME_CORE ) );
Bw::init();
