<?php
/*
Plugin Name: Peenapo Codes
Plugin URI: http://peenapo.com
Description: WordPress meta options plugin everywhere, awesomeness and more.
Version: 1.3
Author: Peenapo
Author URI: http://themeforest.net/user/Peenapo
Text Domain: peenapo_codes
License:     GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

--- @copyright 2015 Peenapo ---

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! function_exists( 'd' ) ) {
	function d($what) {
		print '<pre>';
		print_r($what);
		print '</pre>';
	}
}

if( ! defined( 'PCODES_ROOT' ) ) {
    define( 'PCODES_ROOT', plugin_dir_path( __FILE__ ) );
}
if( ! defined( 'PCODES_URI' ) ) {
    define( 'PCODES_URI', plugins_url( '/', __FILE__ ) );
}
if( ! defined( 'PCODES_SLUG' ) ) {
    define( 'PCODES_SLUG', plugin_basename(__FILE__) );
}

require_once( PCODES_ROOT . 'core/Pcodes.php' );

Pcodes::init();