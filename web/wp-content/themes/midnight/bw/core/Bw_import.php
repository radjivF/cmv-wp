<?php

class Bw_import {

    static $importer;
    static $menus = array(
        'primary'               => 'Peenapo Primary',
        'top_secondary'         => 'Peenapo Top Secondary',
        'my_account'            => 'Peenapo My Account',
        'mobile'                => 'Peenapo Primary',
        'footer'                => 'Peenapo Footer',
    );
    static $static_pages = array(
        'home_page_name' => 'Homepage',
        'blog_page_name' => 'Blog Static'
    );

    static function init() {
        
        self::create_importer();
        
        self::ot_theme_options_import();

        self::assign_menus();
        
        self::assign_static_pages();
        
        self::assign_permalink_format();
        
        self::assign_custom_post_meta();
        
        self::assign_custom_options();
        
    }
    
    static function create_importer() {

        if( ! class_exists( "WP_Import" ) ) {
            if( ! defined( "WP_LOAD_IMPORTERS" ) ) { define( "WP_LOAD_IMPORTERS", true ); }
            require_once( BW_FRAME_LIB . "wordpress-importer/wordpress-importer.php" );
        }
        
        self::$importer = new WP_Import();
        self::$importer->fetch_attachments = true;

        self::import();
    }

    static function import() {

        set_time_limit(0);
        
        $demo = BW_DEMO . (int)$_POST['demo_index'] . DS . 'theme-demo.xml';
        
        ob_start();
        
        self::$importer->import( $demo );
        
        $output = ob_get_clean();
        
        wp_send_json( array('importer_result' => $output ) );
        
    }

    static function assign_menus() {

        $locations = array();

        foreach( self::$menus as $menu_location => $menu_name ) {

            $menu = get_term_by( 'name', $menu_name, 'nav_menu' );
            
            if( is_object( $menu ) ) {
                $locations[$menu_location] = $menu->term_id;
            }
        }

        if( count( $locations ) ) {
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }

    static function assign_static_pages() {

        # Front page displays: a static page
        update_option( 'show_on_front', 'page' );

        # static front page
        $about = get_page_by_title( self::$static_pages['home_page_name'] );
        if( is_object( $about ) ) {
            update_option( 'page_on_front', $about->ID );
        }

        # static blog page
        $blog = get_page_by_title( self::$static_pages['blog_page_name'] );
        if( is_object( $blog ) ) {
            update_option( 'page_for_posts', $blog->ID );
        }
    }
    
    static function assign_permalink_format() {
        
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
        $wp_rewrite->flush_rules();
        
    }

    static function ot_theme_options_import() {
        
        $theme_options_settings = BW_DEMO . (int)$_POST['demo_index'] . DS . 'theme-options.txt';

        if( file_exists( $theme_options_settings ) ) {
            
            # Initialize the Wordpress filesystem, no more using file_get_contents function
            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once( ABSPATH . '/wp-admin/includes/file.php' );
                WP_Filesystem();
            }
            $theme_options_settings_content = $wp_filesystem->get_contents( $theme_options_settings );
            //$theme_options_settings_content = file_get_contents( $theme_options_settings );

            $default_option_tree = unserialize( ot_decode( $theme_options_settings_content ) );

            update_option( 'option_tree', $default_option_tree );
        }
    }

    static function assign_custom_post_meta() {

        /*$post_metas = array(
            array('post_id' => '9',  'meta_key' => 'bw_megamenu_layout', 'meta_value' => 'latest_posts'),
        );

        if( count( $post_metas ) ) {
            foreach( $post_metas as $post_meta ) {
                add_post_meta( $post_meta['post_id'], $post_meta['meta_key'], $post_meta['meta_value'] );
            }
        }*/
    }

    static function assign_custom_options() {
        
        $import_array = array(
			'sidebars_widgets' 				        => 'a:8:{s:19:"wp_inactive_widgets";a:0:{}s:7:"sidebar";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:8:"footer_1";a:0:{}s:8:"footer_2";a:0:{}s:8:"footer_3";a:0:{}s:8:"footer_4";a:0:{}s:12:"sidebar_shop";a:3:{i:0;s:32:"woocommerce_product_categories-2";i:1;s:22:"woocommerce_products-2";i:2;s:31:"woocommerce_product_tag_cloud-2";}s:13:"array_version";i:3;}',
			'widget_woocommerce_product_categories'	=> 'a:2:{i:2;a:6:{s:5:"title";s:18:"Product Categories";s:7:"orderby";s:4:"name";s:8:"dropdown";i:0;s:5:"count";i:0;s:12:"hierarchical";s:1:"1";s:18:"show_children_only";i:0;}s:12:"_multiwidget";i:1;}',
			'widget_woocommerce_products'	        => 'a:2:{i:2;a:7:{s:5:"title";s:8:"Products";s:6:"number";s:1:"5";s:4:"show";s:0:"";s:7:"orderby";s:4:"date";s:5:"order";s:4:"desc";s:9:"hide_free";i:0;s:11:"show_hidden";i:0;}s:12:"_multiwidget";i:1;}',
			'widget_woocommerce_product_tag_cloud'	=> 'a:2:{i:2;a:1:{s:5:"title";s:12:"Product Tags";}s:12:"_multiwidget";i:1;}',
		);
		
		foreach($import_array as $import_option => $import_value) {
			update_option($import_option, unserialize(trim($import_value)));
		}
        
        /*add_option( 'category_2_category_color', '#a10eb7' );*/
    }

}