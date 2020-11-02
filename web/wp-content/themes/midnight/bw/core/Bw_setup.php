<?php

/*
 * Sets up theme defaults
 */
class Bw_setup {
    
    static $post_formats = array(
        'default' => array( 'gallery', 'video', 'quote', 'link' ),
        //'post' => array( 'gallery', 'video' ),
    );

    static function init() {

        add_action( 'after_setup_theme', array( 'Bw_setup', 'setup' ) );

        # assign post formats depending on the post type
        add_action( 'admin_head', array( 'Bw_setup', 'assign_post_formats' ) );
        
    }

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    static function setup() {

        /**
         * http://codex.wordpress.org/Content_Width
         */
        if( !isset( $content_width ) ) {
            $content_width = 960;
        }

        /*
         * set translation
         * Theme translations can be filed in the my_theme/languages/ directory
         */
        global $locale;
        if ( isset( $locale ) ) { if ( defined( 'WPLANG' ) ) { $locale = WPLANG; } }
        load_theme_textdomain( 'midnight', get_template_directory() . '/languages' );
        load_textdomain( 'midnight', get_template_directory() . '/languages/en_US.mo');
        
        # Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        
        # assign default post formats
        self::default_post_formats();

        # Menu locations
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'midnight' ),
        ));
        register_nav_menus( array(
            'top_secondary' => esc_html__( 'Top Menu Secondary', 'midnight' ),
        ));
        register_nav_menus( array(
            'my_account' => esc_html__( 'My Account', 'midnight' ),
        ));
        register_nav_menus( array(
            'mobile' => esc_html__( 'Mobile Menu', 'midnight' ),
        ));
        register_nav_menus( array(
            'footer' => esc_html__( 'Footer Menu', 'midnight' ),
        ));

        # Setup the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'bad_weather_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        # Enable support for HTML5 markup.
        add_theme_support( 'html5', array(
            'comment-list',
            'search-form',
            'comment-form',
            'gallery',
        ));
        
        # Enabling Support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );
        
        # This feature allows themes to add document title tag to HTML <head>.
        add_theme_support( 'title-tag' );

        # remove parentheses from category list and add span class to post count
        add_filter( 'wp_list_categories', array( 'Bw_setup', 'categories_postcount_filter' ) );

        # same for archives
        add_filter( 'get_archives_link', array( 'Bw_setup', 'archive_postcount_filter' ) );

        # custom excerpt text
        add_filter( 'excerpt_more', array( 'Bw_setup', 'new_excerpt_more' ) );

        # custom excerpt length
        add_filter( 'excerpt_length', array( 'Bw_setup', 'new_excerpt_length' ), 999 );
        
        # return wp title
        add_filter( 'wp_title', array( 'Bw_setup', 'title' ) );
        
        # fix shortcode empty paragraphs
        add_filter( 'the_content', array( 'Bw_setup', 'wpex_clean_shortcodes' ) );
        
        # escape comment results
        add_filter( 'comment_text', array( 'Bw_setup', 'bw_comment_kses' ) );
        add_filter( 'comment_text_rss', array( 'Bw_setup', 'bw_comment_kses' ) );
        add_filter( 'comment_excerpt', array( 'Bw_setup', 'bw_comment_kses' ) );
        
    }
    
    static function default_post_formats() {

        $default = self::$post_formats['default'];
        if( isset( $default ) and ! empty( $default ) ) {
            add_theme_support( 'post-formats', $default );
        }
    }

    static function assign_post_formats() {

        global $post;
        if( isset( $post->ID ) ) {
            if( array_key_exists( $post->post_type, self::$post_formats ) ) {
                add_theme_support( 'post-formats', self::$post_formats[$post->post_type] );
            }
        }
    }

    static function bw_comment_kses( $data ) {
        return addslashes( wp_kses( stripslashes( $data ), '' ) );
    }
    
    static function wpex_clean_shortcodes( $content ) {
        $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }
    
    static function title( $title ) {
        if( empty( $title ) && ( is_home() or is_front_page() ) ) {
            return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
        }elseif( is_author() ) {
            return sprintf( esc_html__( 'Author: %s', 'midnight' ), get_the_author() );
        }elseif( is_archive() ) {
            return single_cat_title();
        }
        return $title;
    }

    static function categories_postcount_filter( $variable ) {
        $variable = str_replace( '(', '<span class="post-count">', $variable );
        $variable = str_replace( ')', '</span>', $variable );
        return $variable;
    }

    static function archive_postcount_filter( $links ) {
        $links = str_replace( '</a>&nbsp;(', '</a>&nbsp;<span class="post-count">', $links );
        $links = str_replace( ')', '</span>', $links );
        return $links;
    }

    static function new_excerpt_more() {
        return ' ...';
    }

    static function new_excerpt_length( $length ) {
        return 60;
    }

}