<?php
/*
Plugin Name: Peenapo Page Builder
Plugin URI: http://peenapo.com
Description: Peenapo Page Builder is a powerful WordPress plugin that allows you to create the unlimited number of custom page layouts in WordPress themes. This special drag and drop plugin is based on shortcodes and will save your time when building the pages.
Version: 1.3
Author: Peenapo
Author URI: http://themeforest.net/user/Peenapo
Text Domain: peenapo_page_builder

--- THIS PLUGIN AND ALL FILES INCLUDED ARE COPYRIGHT © PEENAPO THEMES 2015.
YOU MAY NOT RESELL, DISTRIBUTE, OR COPY THIS CODE IN ANY WAY.
THE PLUGIN CAN ONLY BE USED WITH PEENAPO THEMES. ---

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* main */
define( 'PBTD',             'peenapo_page_builder' );
define( 'PB_VER',           '1.2' );

/* plugin rooting */
define( 'PB_ROOT',          plugin_dir_path( __FILE__ ) );
define( 'PB_CONF',          PB_ROOT . 'config/' );
define( 'PB_CORE',          PB_ROOT . 'core/' );
define( 'PB_TEMPLATES',     PB_ROOT . 'templates/' );
define( 'PB_URL',           plugins_url( '/', __FILE__ ) );
define( 'PB_ASSEST',        PB_URL . 'assets/' );

/* theme rooting */
define( 'PB_DS',            DIRECTORY_SEPARATOR );
define( 'PBTH_ROOT',        get_template_directory() . PB_DS );
define( 'PBTH',             PBTH_ROOT . 'bw' . PB_DS . 'lib' . PB_DS . 'bwpb'. PB_DS );
define( 'PBTH_VIEW',        PBTH . 'view'. PB_DS );

define( 'PBTH_URI',         get_template_directory_uri() . '/' );


/*----------------------------------------------------*/
/*	Prints human-readable information about a variable
/*----------------------------------------------------*/
if( ! function_exists( 'd' ) ) {
	function d($what) {
		print '<pre>';
		print_r($what);
		print '</pre>';
	}
}

class Bwpb {
	
	# plugin global configuration
	static $global;
	
    # initiates plugin
	static function init() {
        
        add_action( 'plugins_loaded', array( 'Bwpb', 'on_plugins_loaded' ), 9 );
        
        add_action( 'admin_init', array( 'Bwpb', 'bwpb_init_plugin' ) );
        
    }
    
    # load textdomain
    static function on_plugins_loaded() {
        
        self::loader();
        
        load_plugin_textdomain( PBTD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
        
    }
    
    # require from theme or plugin directory
    static function bwpb_require( $file ) {
        require_once PB_CONF . $file; // default plugin settings
        $bw_fr_root = PBTH_ROOT . 'bwpb' . PB_DS . $file;
        // overwrite default plugins settings if other config file exists
        if( file_exists( PBTH . $file ) ) { // bw framework directory
            require_once PBTH . $file;
        }elseif( file_exists( $bw_fr_root ) ) { // theme directory
            require_once $bw_fr_root;
        }
    }
    
    # load files
	static function loader() {
        
        self::globals();
        if( ! self::license() ) { return; }
        
        include PB_CORE . 'Bwpb_assest.php';
        include PB_CORE . 'Bwpb_map.php';
        include PB_CORE . 'Bwpb_shortcide_parser.php';
        include PB_CORE . 'Bwpb_shortcode_definition.php';
        
        if( is_admin() ) {
            include PB_CORE . 'backend/Bwpb.php';
            include PB_CORE . 'backend/Bwpb_ajax.php';
        }else{
            include PB_CORE . 'front/Bwpb.php';
        }
		
		call_user_func( array( ( is_admin() ) ? "Bwpb_back" : "Bwpb_front", 'init' ) );
		
	}
	
    # globals
	static function globals() {
        self::bwpb_require( 'globals.php' );
		self::$global = $GLOBALS["pb_config"];
    }
    
    static function bwpb_init_plugin() {
        
        self::github_plugin_updater_init();
        
    }
    
    static function github_plugin_updater_init() {
        
		if ( is_admin() ) {
            
            require 'updater/plugin-update-checker.php';
            $className = PucFactory::getLatestClassVersion('PucGitHubChecker');
            $myUpdateChecker = new $className(
                'https://github.com/Peenapo/Peenapo-Page-Builder/',
                __FILE__,
                'master'
            );
            $myUpdateChecker->setAccessToken('6b957e1a3e052b773ecc493262ba4f2547e03cf2');
		}
        
    }
	
    # get stored data
	static function get_bwpb_data( $postid ) {
		
		$pagebuilder = array();
		
		$pagebuilder = get_post_meta( $postid, "bwpb_data", true );
		
		if ( is_array( $pagebuilder ) ) {
			array_walk_recursive( $pagebuilder, 'stripslashes_in_array' );
		}
		
		return $pagebuilder;
		
	}
    
    # fix paragraph
    static function autop( $content ) {
        $output = preg_replace( '/^<\/p><p>/', '<p>', $content );
        $output = preg_replace( '/^<\/p>/', '', $output );
        $output = preg_replace( '/<\/p><p>$/', '</p>', $output );
        return preg_replace( '/<p>$/', '', $output );
    }
    
    static function quote_decode_raw( $text ) {
        return str_replace( '`', "'", str_replace( '``', '"', stripcslashes( $text ) ) );
    }
    
    static function quote_decode( $text ) {
        return stripslashes( str_replace( '``', '&quot;', esc_html( $text ) ) );
    }
    
    # returns the icon
    static function get_icon( $icon_data ) {
        $icon = explode(',', $icon_data);
        return ( isset( $icon[0] ) and isset( $icon[1] ) ) ? $icon[1] : false;
    }
    
    # returns the library
    static function get_icon_lib( $icon_data ) {
        $icon = explode(',', $icon_data);
        return ( isset( $icon[0] ) and isset( $icon[1] ) ) ? $icon[0] : false;
    }
    
    # retrieves the attachment ID from the file URL
    static function get_image_id_from_url( $image_url ) {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return isset( $attachment[0] ) ? $attachment[0] : false; 
    }
    
    # get the current paging
    static function current_page() {
        
        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        }elseif ( get_query_var('page') ) {
            $paged = get_query_var('page');
        }else{
            $paged = 1;
        }
        
        return $paged;
    }
    
    # includes templates
    static function include_template( $template, $variables = array(), $once = false ) {
        is_array( $variables ) && extract( $variables );
        $template = PB_ROOT . "templates/{$template}.php";
        if( file_exists( $template ) ) {
            return $once ? require_once $template : require $template;
        }
    }
    
    # returns an empty image placeholder
    static function empty_img( $size ) {
        return PB_ASSEST . 'img/empty/' . ( $size ? $size : 'pixel' ) . '.png';
    }
    
    static function license() {
        if( self::$global['enable_licensing'] ) {
            include PB_CORE . 'Bwpb_license.php';
            return Bwpb_license::build();
        }
        return true;
    }
    
    static function bw_check_status( $id = false ) {
        if ( ! $id ) { $id = get_the_ID(); }
        $bwpb_status = get_post_meta( $id, '_bwpb_status', true );
        if ( ! isset( $bwpb_status ) or $bwpb_status == "" ) {
            $bwpb_status = false;
        }
        return $bwpb_status;
    }
    
}

Bwpb::init();