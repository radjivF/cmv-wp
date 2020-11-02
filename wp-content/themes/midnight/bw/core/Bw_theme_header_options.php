<?php

class Bw_theme_header_options {

    static $internal_css = '';
    static $body_class = '';
    static $body_font = array(
        ''
    );

    static function init() {
        # admin bar
        self::admin_bar();
        # general header settings
        add_action( 'get_header', array( 'Bw_theme_header_options', 'header_before' ) );
        # assign header settings
        add_action( 'wp_head', array( 'Bw_theme_header_options', 'header_inside' ) );
        # enqueue additional styles
        add_action( 'wp_enqueue_scripts', array( 'Bw_theme_header_options', 'internal_css' ) );
    }

    static function add_body_class( $class ) {
        self::$body_class .= ' ' . $class;
    }

    static function body_class( $additional_class = '' ) {
        return esc_attr( trim( self::$body_class . ' ' . $additional_class ) );
    }

    static function add_css( $css ) {
        self::$internal_css .= $css;
    }
    
    static function header_before() {
        
        // store cookie for newletter
        if( Bw::get_option('newsletter') and Bw::get_option('newsletter_once') and ! isset( $_COOKIE['bw_newsletter'] ) ) {
            if( get_post_type() == 'page' and get_the_ID() == Bw::get_option('newsletter_page') ) {
                setcookie('bw_newsletter', 1, time()+3600*24*30 /* 30 days */ , '/' );
            }
        }
        
        // get header version
        $header_version = Bw::get_option('header_version');
        if( ! empty( $header_version ) ) {
            Bw::$hver = esc_attr( $header_version );
        }
        // overwrite header version by page custom header layout options
        if( Bw::get_meta('overwrite_header_layout') ) {
            $header_version_page = Bw::get_meta('header_version');
            if( ! empty( $header_version_page ) ) {
                Bw::$hver = esc_attr( $header_version_page );
            }
        }
        
        self::custom_body_class();
        self::admin_bar_css();
        
    }

    static function header_inside() {
        
        self::fav_icon();
        self::theme_options();
        
    }
    
    static function custom_body_class() {
        
        if( is_front_page() or is_home() ) { Bw::add_body_class( 'bw-homepage' ); }
        if( wp_is_mobile() ) { Bw::add_body_class( 'bw-is-mobile' ); }
        if( is_page() and get_page_template_slug() == 'page-shop.php' ) { Bw::add_body_class( 'woocommerce' ); }
        
    }
    
    static function admin_bar() {
        if( ! Bw::get_option( 'show_wp_bar' ) ) { show_admin_bar( false ); }
    }
    
    static function admin_bar_css() {
        
        if( ! is_admin_bar_showing() ) {
            self::add_css("
                .bw-header.bw-is-sticky:not(.bw-is-bottom), .bw-header.bw-header-v2.bw-is-sticky.bw-is-bottom.bw-is-bottom-go,
                #bw-v3m .bw-v3m-close, .bw-hm-nav {top:0;}
            ");
        }else{
            self::add_css("
                .bw-header.bw-is-sticky:not(.bw-is-bottom), .bw-header.bw-header-v2.bw-is-sticky.bw-is-bottom.bw-is-bottom-go,
                #bw-v3m .bw-v3m-close, .bw-hm-nav {top:32px;}
                .bw-header-v2.bw-is-sticky.bw-is-bottom:not(.bw-is-bottom-go) {margin-top:-32px;}
                
                @media screen and ( max-width: 782px ) {
                    .bw-header.bw-is-sticky:not(.bw-is-bottom), .bw-header.bw-header-v2.bw-is-sticky.bw-is-bottom.bw-is-bottom-go,
                    #bw-v3m .bw-v3m-close, .bw-hm-nav {top:46px;}
                    .bw-header-v2.bw-is-sticky.bw-is-bottom:not(.bw-is-bottom-go) {margin-top:-46px;}
                }
            ");
        }
        
    }
    
    static function fav_icon() {
        
        // if the `wp_site_icon` function does not exist (ie we're on < WP 4.3)
        if ( ! function_exists( 'wp_site_icon' ) ) { // show the user your favicon theme option
            self::get_fav_icon();
        }else { // display a message advising the user to use the site icon feature
            if ( ! ( function_exists( 'has_site_icon' ) && has_site_icon() ) ) { // If the `has_site_icon` function doesn't exist if the site icon has not been set 
                // output your theme favicon code to the page source
                self::get_fav_icon();
            }
        }
    }

    static function get_fav_icon() {
        $fav = Bw::get_option( 'fav_icon' );
        if( $fav ) {
            echo "<link rel='shortcut icon' href='" . esc_url( $fav ) . "'>";
        }
    }
    
    static function theme_options() {
        Bw_theme_style::init();
    }

    static function internal_css() {
        $internal_css = self::$internal_css;
        $custom_css = Bw::get_option( 'custom_css' );
        if( $internal_css or $custom_css ) {
            wp_add_inline_style( 'bw-style', $internal_css . $custom_css );
        }
    }

    static function logo() {
        
        $ot_logo = Bw::get_option( 'logo' );
        $output = '';
        
        $output .= '<a href="' . esc_url( home_url( '/' ) ) . '">';
            if( ! empty( $ot_logo ) ) {
                $logo_src = Bw::float_option( 'logo' );
                if( is_numeric( $logo_src ) ) {
                    $logo_src = wp_get_attachment_image_src( $logo_src, 'full' );
                    if( isset( $logo_src[0] ) ) {
                        $logo_src =  $logo_src[0];
                    }
                }else{
                    $logo_src = Bw::get_option( 'logo' );
                }
                $output .= '<img src="' . esc_url( $logo_src ) . '" alt="' . get_bloginfo( 'name' ) . '">';
            }else{
                $output .= '<h1>' . get_bloginfo( 'name' ) . '</h1>';
            }
            if( Bw::$hver == 'v1' ) {
                $side_desc = Bw::get_option('custom_site_desc');
                $side_desc = empty( $side_desc ) ? get_bloginfo( 'description' ) : esc_html( $side_desc );
                $output .= Bw::get_option( 'enable_site_desc' ) ? '<h2>' . esc_html( $side_desc ) . '</h2>' : '';
            }
        $output .= '</a>';
        
        return $output;
    }

}