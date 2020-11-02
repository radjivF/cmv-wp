<?php

class Bw_widgets {
    
    static $widgets = array(
        /*'bw_widgets_popular_posts',
        'bw_widgets_latest_reviews'
        'bw_widgets_recent_posts_slider',*/
        'bw_widgets_recent_posts',
    );
    
    static function init() {
        
        # Register widgetized area and update sidebar with default widgets.
        self::register_sidebars();
        
        # require and register widgets.
        add_action( 'after_setup_theme', array( 'Bw_widgets', 'require_widgets' ) );
        add_action( 'widgets_init', array( 'Bw_widgets', 'register_widgets' ) );
        
    }
    
    static function register_sidebars() {
        
        register_sidebar(
            array(
                'name'          => esc_html__( 'Sidebar', 'midnight' ),
                'id'            => 'sidebar',
                'description'   => 'Main sidebar',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
        
        register_sidebar(
            array(
                'name'          => esc_html__( 'Footer column 1', 'midnight' ),
                'id'            => 'footer_1',
                'description'   => 'Footer widget area - column 1',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            )
        );
        
        register_sidebar(
            array(
                'name'          => esc_html__( 'Footer column 2', 'midnight' ),
                'id'            => 'footer_2',
                'description'   => 'Footer widget area - column 2',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            )
        );
        
        register_sidebar(
            array(
                'name'          => esc_html__( 'Footer column 3', 'midnight' ),
                'id'            => 'footer_3',
                'description'   => 'Footer widget area - column 3',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            )
        );
        
        register_sidebar(
            array(
                'name'          => esc_html__( 'Footer column 4', 'midnight' ),
                'id'            => 'footer_4',
                'description'   => 'Footer widget area - column 4',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            )
        );
        
        # register woocommerce sidebar if enabled.
        if( Bw_woo::woo_active_plugin() ) {
            register_sidebar(
                array(
                    'name'          => esc_html__( 'E-commerce sidebar', 'midnight' ),
                    'id'            => 'sidebar_shop',
                    'description'   => 'The sidebar displayed in the e-commerce section',
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h1 class="widget-title">',
                    'after_title'   => '</h1>',
                )
            );
        }
        
    }
    
    static function require_widgets() {
        foreach ( self::$widgets as $widget ) {
            require_once BW_FRAME_WIDGETS . $widget . '.php';
        }
    }
    
    static function register_widgets() {
        foreach ( self::$widgets as $widget ) {
            register_widget( $widget );
        }
    }
}