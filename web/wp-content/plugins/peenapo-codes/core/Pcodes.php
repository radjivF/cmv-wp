<?php

class Pcodes {
    
    static $config;
    
    static function init() {
        
        # after_setup_theme hook is called during each page load, after the theme is initialized
        add_action( 'after_setup_theme', array('Pcodes', 'general') );
        # enqueue some scripts
        add_action( 'init', array('Pcodes', 'enqueue_scripts') );
        # admin_init hook
        add_action( 'admin_init', array('Pcodes', 'admin_init') );
        
    }
    
    static function general() {
        self::init_acf();
    }
    
    static function init_acf() {
        
        # include ACF
        include_once( PCODES_ROOT . 'lib/acf/acf.php' );
        
        # do only if one of our themes
        if( class_exists( 'Bw_meta' ) ) {
            # load cached acf option settings
            if( ! ( defined( 'ACF_PRODUCTION' ) and ACF_PRODUCTION === true ) ) {
                if( Bw_meta::$acf_load_export and file_exists( Bw_meta::$acf_export_path ) ) {
                    include_once( Bw_meta::$acf_export_path );
                }
            }
            
            # remove fields for standard users
            add_action( 'admin_menu', array( 'Bw_meta', 'remove_acf_menu' ), 999 );
            
            # automatic acf field export. Export is initiated whenever an admin
            # publishes a new field group or saves changes to an existing field group.
            if( is_admin() and Bw_meta::$is_peenapo_user and Bw_meta::$acf_export_on_update) {
                add_action('admin_head-post.php', array( 'Bw_meta', 'automatic_acf_export' ) );
            }
        }
        
        # register acf addons
        self::acf_addons();
    }

    static function acf_addons() {
        if( is_admin() ) {
            include_once( PCODES_ROOT . 'lib/acf/add-ons/acf-flexible-content/flexible-content.php');
            include_once( PCODES_ROOT . 'lib/acf/add-ons/acf-repeater/repeater.php');
        }
    }
    
    # enqueue some scripts
    static function enqueue_scripts() {
        if( is_admin() ) {
            wp_enqueue_script( 'bw-acf-custom', PCODES_URI . 'lib/acf/js/custom-admin.js', array(), '1.0', true );
        }
        
    }
    
    static function admin_init() {
        if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
            deactivate_plugins('advanced-custom-fields/acf.php');
        }
        self::github_plugin_updater_init();
    }
    
    # yeah baby, chack for updates
    static function github_plugin_updater_init() {
        
        include PCODES_ROOT .  DIRECTORY_SEPARATOR . 'updater.php';
        
		if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin
            
			$config = array(
				'username'   => 'Peenapo',
				'repo'       => 'Peenapo-Codes',
				'name'       => 'Peenapo Codes',
				'slug'       => PCODES_SLUG,
				'api_url'    => 'https://api.github.com/repos/Peenapo/peenapo-codes',
				'raw_url'    => 'https://raw.github.com/Peenapo/peenapo-codes/master',
				'github_url' => 'https://github.com/Peenapo/peenapo-codes',
				'zip_url'    => 'https://github.com/Peenapo/peenapo-codes/archive/master.zip',
				'sslverify'  => false,
				'requires'   => '4.0',
				'tested'     => '4.2.1',
				'readme'     => 'README.md',
				'textdomain' => 'peenapo_codes',
				'debug_mode' => false,
				'access_token' => '',
			);
			new WP_Peenapo_Codes_GitHub_Updater( $config );
		}
        
    }
}