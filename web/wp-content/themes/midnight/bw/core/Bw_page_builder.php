<?php

class Bw_page_builder {
    
    static $modules = array(
        'theme_slider_wrapper',
        'theme_slider_item',
        'theme_text_anim',
        'theme_icon_text_wrapper',
        'theme_icon_text_item',
        'theme_featured_products',
        'theme_featured_products_slider',
        'theme_product_picks',
        'theme_product_picks_item',
        'theme_midnight_deal',
        'theme_midnight_latest_posts',
        'theme_collections',
        'theme_collections_item',
        'theme_faq',
        'theme_faq_item',
        'theme_lookbook',
        'theme_shop_archive',
        'theme_product_thumbs',
        'theme_customers_say',
        'theme_custom_product',
    );
    
    static $shop_filter = array();
    
    static function init() {
        
        // don't load if page builder is not enabled.
        // TODO
        
        if( class_exists( 'Bwpb_map' ) ) {
            
            self::$shop_filter = array(
                array(
                    'type' => 'select',
                    'fields' => array(
                        'latest' => 'Latest products',
                        'featured' => 'Featured products',
                        'latest_by_cat' => 'Latest products from a category',
                        'top_rating' => 'Top rated products',
                        'best_sellers' => 'Best selling products',
                        'new_badge' => 'New products',
                        'sale' => 'On sale',
                    ),
                    'param_name' => 'source',
                    'heading' => esc_html__( 'Post source', 'midnight' ),
                    'description' => 'Select what type of posts to be displayed.',
                ),
                /* latest posts from a category */
                array(
                    'type' => 'taxonomies',
                    'heading' => esc_html__( 'Category', 'midnight' ),
                    'param_name' => 'category',
                    'description' => esc_html__( 'Hold down Command key (or CTRL on Windows) to select multiple categories.', 'midnight' ),
                    'tx_type' => 'product_cat',
                    'allow_empty' => true,
                    'multiple' => true,
                    'dependency' => array( 'element' => 'source', 'value' => 'latest_by_cat' ),
                ),
            );
            
            // modules
            foreach( self::$modules as $module ) {
                if( is_admin() ) {
                    add_action( 'admin_init', array( 'Bw_page_builder', $module ) );
                }else{
                    if( method_exists( 'Bwpb_shortcode_definition', 'the_shortcode' ) ) {
                        Bwpb_shortcode_definition::the_shortcode( $module, array( 'Bw_page_builder', "pb_shortcode_{$module}" ) );
                    }
                }
            }
            
            add_action( 'after_setup_theme', array( 'Bw_page_builder', 'setup' ) );
        }
    }
    
    static function setup() {
        
    }
    
    static function theme_slider_wrapper() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight slider', 'midnight' ),
            'base' => 'theme_slider_wrapper',
            'icon' => 'bwpb-icon-theme-slider',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'true_false',
                    'heading' => 'Pagination',
                    'param_name' => 'pagination',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Autoplay',
                    'param_name' => 'autoplay',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Full height',
                    'param_name' => 'full_height',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Full width',
                    'param_name' => 'full_width',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'White navigation',
                    'param_name' => 'nav_white',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => 'Background color',
                    'param_name' => 'bg_color',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing',
            'container_child' => 'theme_slider_item'
        ));
        
    }
    
    static function theme_slider_item() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight slide', 'midnight' ),
            'base' => 'theme_slider_item',
            'icon' => 'bwpb-icon-theme-slider',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'image',
                    'heading' => esc_html__( 'Background image', 'midnight' ),
                    'param_name' => 'bg_image'
                ),
                array(
                    'type' => 'select',
                    'heading' => esc_html__( 'Background position', 'midnight' ),
                    'param_name' => 'bg_position',
                    'fields' => array(
                        'left top' => 'Left Top',
                        'left center' => 'Left Center',
                        'left bottom' => 'Left Bottom',
                        'right top' => 'Right Top',
                        'right center' => 'Right Center',
                        'right bottom' => 'Right Bottom',
                        'center top' => 'Center Top',
                        'center center' => 'Center Center',
                        'center bottom' => 'Center Bottom',
                    ),
                    'value' => 'center center'
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'title',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'value' => 'Some title',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'sub_title',
                    'heading' => esc_html__( 'Sub title', 'midnight' ),
                    'value' => 'Sub title',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'summary',
                    'heading' => esc_html__( 'Summary', 'midnight' ),
                    'value' => 'Summary',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Summary letter spacing', 'midnight' ),
                    'param_name' => 'summary_spacing',
                    'min' => 0,
                    'max' => 15,
                    'step' => 1,
                    'value' => 0,
                    'append_before' => '',
                    'append_after' => 'pixels.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'bg_text',
                    'heading' => esc_html__( 'Background text', 'midnight' ),
                    'value' => '50%',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Background text size', 'midnight' ),
                    'param_name' => 'bg_text_size',
                    'min' => 100,
                    'max' => 350,
                    'step' => 10,
                    'value' => 320,
                    'append_before' => '',
                    'append_after' => 'pixels.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'alt_text',
                    'heading' => esc_html__( 'Alt text', 'midnight' ),
                ),
                array(
                    'type' => 'select',
                    'heading' => esc_html__( 'Text position', 'midnight' ),
                    'param_name' => 'text_position',
                    'fields' => array(
                        'left-top' => 'Left Top',
                        'left-center' => 'Left Center',
                        'left-bottom' => 'Left Bottom',
                        'right-top' => 'Right Top',
                        'right-center' => 'Right Center',
                        'right-bottom' => 'Right Bottom',
                        'center-top' => 'Center Top',
                        'center-center' => 'Center Center',
                        'center-bottom' => 'Center Bottom',
                    ),
                    'value' => 'center center'
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Enable button',
                    'param_name' => 'enable_button',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Button label',
                    'param_name' => 'button_label',
                    'value' => esc_html__( 'Shop Now', 'midnight' ),
                    'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Button url',
                    'param_name' => 'button_url',
                    'placeholder' => 'http://',
                    'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Use white text color',
                    'param_name' => 'white_text',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing_item',
            'container_parent' => 'theme_slider_wrapper'
        ));
        
    }
    
    static function theme_text_anim() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight text animation', 'midnight' ),
            'base' => 'theme_text_anim',
            'icon' => 'bwpb-icon-theme-anim',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'param_name' => 'title',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'value' => 'Some title',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'sub_title',
                    'heading' => esc_html__( 'Sub title', 'midnight' ),
                    'value' => 'Sub title',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'summary',
                    'heading' => esc_html__( 'Summary', 'midnight' ),
                    'value' => 'Summary',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Summary letter spacing', 'midnight' ),
                    'param_name' => 'summary_spacing',
                    'min' => 0,
                    'max' => 15,
                    'step' => 1,
                    'value' => 0,
                    'append_before' => '',
                    'append_after' => 'pixels.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'bg_text',
                    'heading' => esc_html__( 'Background text', 'midnight' ),
                    'value' => '50%',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Background text size', 'midnight' ),
                    'param_name' => 'bg_text_size',
                    'min' => 100,
                    'max' => 350,
                    'step' => 10,
                    'value' => 320,
                    'append_before' => '',
                    'append_after' => 'pixels.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'alt_text',
                    'heading' => esc_html__( 'Alt text', 'midnight' ),
                ),
                array(
                    'type' => 'select',
                    'heading' => esc_html__( 'Text position', 'midnight' ),
                    'param_name' => 'text_position',
                    'fields' => array(
                        'left-top' => 'Left Top',
                        'left-center' => 'Left Center',
                        'left-bottom' => 'Left Bottom',
                        'right-top' => 'Right Top',
                        'right-center' => 'Right Center',
                        'right-bottom' => 'Right Bottom',
                        'center-top' => 'Center Top',
                        'center-center' => 'Center Center',
                        'center-bottom' => 'Center Bottom',
                    ),
                    'value' => 'center center'
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Enable button',
                    'param_name' => 'enable_button',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Button label',
                    'param_name' => 'button_label',
                    'value' => esc_html__( 'Shop Now', 'midnight' ),
                    'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Button url',
                    'param_name' => 'button_url',
                    'placeholder' => 'http://',
                    'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Use white text color',
                    'param_name' => 'white_text',
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Add text shadow',
                    'param_name' => 'text_shadow',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            )
        ));
        
    }
    
    static function theme_icon_text_wrapper() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight Icon with Text Box', 'midnight' ),
            'base' => 'theme_icon_text_wrapper',
            'icon' => 'bwpb-icon-theme-icon',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'true_false',
                    'heading' => 'Use white text color',
                    'param_name' => 'white_color'
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing',
            'container_child' => 'theme_icon_text_item'
        ));
        
    }
    
    static function theme_icon_text_item() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight Icon with Text', 'midnight' ),
            'base' => 'theme_icon_text_item',
            'icon' => 'bwpb-icon-theme-icon',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'summary', 'midnight' ),
                    'param_name' => 'summary',
                ),
                array(
                    'type' => 'icon',
                    'heading' => esc_html__( 'Icon', 'midnight' ),
                    'param_name' => 'icon',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing_item',
            'container_parent' => 'theme_icon_text_wrapper'
        ));
        
    }
    
    static function theme_featured_products() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Featured products', 'midnight' ),
            'base' => 'theme_featured_products',
            'icon' => 'bwpb-icon-theme-featured-prod',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'taxonomies',
                    'heading' => esc_html__( 'Category', 'midnight' ),
                    'param_name' => 'category',
                    'description' => esc_html__( 'Hold down Command key (or CTRL on Windows) to select multiple categories.', 'midnight' ),
                    'tx_type' => 'product_cat',
                    'allow_empty' => true,
                    'multiple' => true,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Featured', 'midnight' ),
                    'param_name' => 'tab_featured',
                    'value' => '1',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'On sale', 'midnight' ),
                    'param_name' => 'tab_sale',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Best sellers', 'midnight' ),
                    'param_name' => 'tab_best_sellers',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'New', 'midnight' ),
                    'param_name' => 'tab_new',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'New with badge', 'midnight' ),
                    'param_name' => 'tab_new_badge',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Number of products', 'midnight' ),
                    'param_name' => 'number_of_posts',
                    'min' => 3,
                    'max' => 20,
                    'step' => 1,
                    'value' => 8,
                    'append_before' => '',
                    'append_after' => 'products.',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Items per row', 'midnight' ),
                    'param_name' => 'items_per_row',
                    'min' => 3,
                    'max' => 6,
                    'step' => 1,
                    'value' => 4,
                    'append_before' => '',
                    'append_after' => 'products.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
        ));
        
    }
    
    static function theme_featured_products_slider() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Featured products slider', 'midnight' ),
            'base' => 'theme_featured_products_slider',
            'icon' => 'bwpb-icon-theme-slider-prod',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'taxonomies',
                    'heading' => esc_html__( 'Category', 'midnight' ),
                    'param_name' => 'category',
                    'description' => esc_html__( 'Hold down Command key (or CTRL on Windows) to select multiple categories.', 'midnight' ),
                    'tx_type' => 'product_cat',
                    'allow_empty' => true,
                    'multiple' => true,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Featured', 'midnight' ),
                    'param_name' => 'tab_featured',
                    'value' => '1',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'On sale', 'midnight' ),
                    'param_name' => 'tab_sale',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Best sellers', 'midnight' ),
                    'param_name' => 'tab_best_sellers',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'New', 'midnight' ),
                    'param_name' => 'tab_new',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'New with badge', 'midnight' ),
                    'param_name' => 'tab_new_badge',
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Enable autoplay', 'midnight' ),
                    'param_name' => 'autoplay',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Enable navigation', 'midnight' ),
                    'param_name' => 'navigation',
                    'width' => 50,
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Number of products', 'midnight' ),
                    'param_name' => 'number_of_posts',
                    'min' => 3,
                    'max' => 20,
                    'step' => 1,
                    'value' => 8,
                    'append_before' => '',
                    'append_after' => 'products.',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Items per slide', 'midnight' ),
                    'param_name' => 'items_per_row',
                    'min' => 3,
                    'max' => 6,
                    'step' => 1,
                    'value' => 4,
                    'append_before' => '',
                    'append_after' => 'products.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
        ));
        
    }
    
    static function theme_midnight_deal() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight Deal', 'midnight' ),
            'base' => 'theme_midnight_deal',
            'icon' => 'bwpb-icon-theme-deal',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Sub title', 'midnight' ),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Background text', 'midnight' ),
                    'param_name' => 'bg_text',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Background text size', 'midnight' ),
                    'param_name' => 'bg_text_size',
                    'min' => 100,
                    'max' => 350,
                    'step' => 10,
                    'value' => 320,
                    'append_before' => '',
                    'append_after' => 'pixels.',
                ),
                array(
                    'type' => 'select',
                    'heading' => esc_html__( 'Text position', 'midnight' ),
                    'param_name' => 'text_position',
                    'fields' => array(
                        'left-center' => 'Left Center',
                        'right-center' => 'Right Center',
                        'center-center' => 'Center Center',
                    ),
                    'value' => 'right center'
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Enable button',
                    'param_name' => 'enable_button',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Button label',
                    'param_name' => 'button_label',
                    'value' => esc_html__( 'Shop Now', 'midnight' ),
                    'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Button url',
                    'param_name' => 'button_url',
                    'placeholder' => 'http://',
                    'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Use white text color',
                    'param_name' => 'white_text',
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Enable countdown',
                    'param_name' => 'enable_countdown',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Countdown date',
                    'param_name' => 'countdown_date',
                    'placeholder' => 'DD.MM.YYYY',
                    'description' => 'Date format: DD.MM.YYYY',
                    'dependency' => array( 'element' => 'enable_countdown', 'value' => '1' ),
                ),
                array(
                    'type' => 'select',
                    'heading' => 'Countdown position',
                    'param_name' => 'countdown_position',
                    'fields' => array(
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ),
                    'value' => 'center',
                    'dependency' => array( 'element' => 'enable_countdown', 'value' => '1' ),
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
        ));
        
    }
    
    static function theme_product_picks() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Product picks', 'midnight' ),
            'base' => 'theme_product_picks',
            'icon' => 'bwpb-icon-theme-pick',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Element height', 'midnight' ),
                    'param_name' => 'height',
                    'min' => 400,
                    'max' => 800,
                    'step' => 5,
                    'value' => 675,
                    'append_before' => '',
                    'append_after' => 'pixels.',
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Enable countdown',
                    'param_name' => 'enable_countdown',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'Countdown date',
                    'param_name' => 'countdown_date',
                    'placeholder' => 'DD.MM.YYYY',
                    'description' => 'Date format: DD.MM.YYYY',
                    'dependency' => array( 'element' => 'enable_countdown', 'value' => '1' ),
                ),
                array(
                    'type' => 'select',
                    'heading' => 'Countdown position',
                    'param_name' => 'countdown_position',
                    'fields' => array(
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ),
                    'value' => 'center',
                    'dependency' => array( 'element' => 'enable_countdown', 'value' => '1' ),
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing',
            'container_child' => 'theme_product_picks_item'
        ));
        
    }
    
    static function theme_product_picks_item() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Product picks item', 'midnight' ),
            'base' => 'theme_product_picks_item',
            'icon' => 'bwpb-icon-theme-pick',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Top position', 'midnight' ),
                    'param_name' => 'top',
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'value' => 50,
                    'append_before' => '',
                    'append_after' => '%',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Left position', 'midnight' ),
                    'param_name' => 'left',
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'value' => 50,
                    'append_before' => '',
                    'append_after' => '%',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Price', 'midnight' ),
                    'param_name' => 'price',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Price before', 'midnight' ),
                    'param_name' => 'sale_price',
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Enable link', 'midnight' ),
                    'param_name' => 'enable_link',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => 'URL',
                    'param_name' => 'url',
                    'placeholder' => 'http://',
                    'dependency' => array( 'element' => 'enable_link', 'value' => '1' ),
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing_item',
            'container_parent' => 'theme_product_picks'
        ));
        
    }
    
    static function theme_midnight_latest_posts() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight latest posts', 'midnight' ),
            'base' => 'theme_midnight_latest_posts',
            'icon' => 'bwpb-icon-theme-latest-posts',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Number of posts', 'midnight' ),
                    'param_name' => 'number_of_posts',
                    'min' => 3,
                    'max' => 12,
                    'step' => 1,
                    'value' => 3,
                    'append_before' => '',
                    'append_after' => 'posts.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
        ));
        
    }
    
    static function theme_collections() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Collection blocks', 'midnight' ),
            'base' => 'theme_collections',
            'icon' => 'bwpb-icon-theme-collections',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'radio_image',
                    'heading' => esc_html__( 'Collection layout', 'midnight' ),
                    'param_name' => 'collection_layout',
                    'fields' => array(
                        array(
                            'value' => '5',
                            'label' => 'Mixed grid',
                            'image' => BW_URI . 'bw/assets/img/admin/layout_collections/1.png'
                        ),
                        array(
                            'value' => '2',
                            'label' => '2 columns',
                            'image' => BW_URI . 'bw/assets/img/admin/layout_collections/2.png'
                        ),
                        array(
                            'value' => '3',
                            'label' => '3 columns',
                            'image' => BW_URI . 'bw/assets/img/admin/layout_collections/3.png'
                        ),
                        array(
                            'value' => '4',
                            'label' => '4 columns',
                            'image' => BW_URI . 'bw/assets/img/admin/layout_collections/4.png'
                        ),
                        array(
                            'value' => '4_wall',
                            'label' => '4 columns wall',
                            'image' => BW_URI . 'bw/assets/img/admin/layout_collections/4_wall.png'
                        ),
                    ),
                    'value' => '5',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing',
            'container_child' => 'theme_collections_item'
        ));
        
    }
    
    static function theme_collections_item() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Collections block item', 'midnight' ),
            'base' => 'theme_collections_item',
            'icon' => 'bwpb-icon-theme-collections',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'image',
                    'heading' => esc_html__( 'Background image', 'midnight' ),
                    'param_name' => 'bg_image'
                ),
                array(
                    'type' => 'taxonomies',
                    'heading' => esc_html__( 'Link to category', 'midnight' ),
                    'param_name' => 'category',
                    'tx_type' => 'product_cat'
                ),
                array(
                    'type' => 'select',
                    'heading' => esc_html__( 'Text position', 'midnight' ),
                    'param_name' => 'text_position',
                    'fields' => array(
                        'left-top' => 'Left Top',
                        'left-center' => 'Left Center',
                        'left-bottom' => 'Left Bottom',
                        'right-top' => 'Right Top',
                        'right-center' => 'Right Center',
                        'right-bottom' => 'Right Bottom',
                        'center-top' => 'Center Top',
                        'center-center' => 'Center Center',
                        'center-bottom' => 'Center Bottom',
                    ),
                    'value' => 'center-center'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Sub title', 'midnight' ),
                    'param_name' => 'sub_title',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Summary', 'midnight' ),
                    'param_name' => 'summary',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Font size', 'midnight' ),
                    'param_name' => 'font_size',
                    'min' => 10,
                    'max' => 30,
                    'step' => 1,
                    'value' => 14,
                    'append_before' => '',
                    'append_after' => 'pixels.',
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Enable border', 'midnight' ),
                    'param_name' => 'enable_border',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Use white text color', 'midnight' ),
                    'param_name' => 'white_text',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Hide text before hover', 'midnight' ),
                    'param_name' => 'hide_text',
                    'width' => 50,
                ),
                array(
                    'type' => 'true_false',
                    'heading' => esc_html__( 'Visible over color', 'midnight' ),
                    'param_name' => 'over_active',
                    'width' => 50,
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing_item',
            'container_parent' => 'theme_collections'
        ));
        
    }
    
    static function theme_faq() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight FAQ', 'midnight' ),
            'base' => 'theme_faq',
            'icon' => 'bwpb-icon-theme-faq',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing',
            'container_child' => 'theme_faq_item'
        ));
        
    }
    
    static function theme_faq_item() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Midnight FAQ item', 'midnight' ),
            'base' => 'theme_faq_item',
            'icon' => 'bwpb-icon-theme-faq',
            'open_settings_on_create' => false,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'param_name' => 'title',
                    'value' => esc_html__( 'Some title', 'midnight' )
                ),
                array(
                    'type' => 'editor',
                    'param_name' => 'content',
                    'heading' => esc_html__( 'Content', 'midnight' ),
                    'value' => 'Text block. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
                    'is_content' => true,
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ),
            'view' => 'listing_item',
            'container_parent' => 'theme_faq'
        ));
        
    }
    
    static function theme_lookbook() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Lookbook section', 'midnight' ),
            'base' => 'theme_lookbook',
            'icon' => 'bwpb-icon-theme-lookbook',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'select',
                    'fields' => array(
                        'ltr' => 'Left to right',
                        'rtl' => 'Right to left',
                    ),
                    'param_name' => 'align',
                    'heading' => esc_html__( 'Section alignment style', 'midnight' ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'param_name' => 'title',
                    'value' => esc_html__( 'The title', 'midnight' )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Sub title', 'midnight' ),
                    'param_name' => 'sub_title',
                    'value' => esc_html__( 'Sub title', 'midnight' )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Alt', 'midnight' ),
                    'param_name' => 'alt',
                    'value' => esc_html__( '01', 'midnight' )
                ),
                array(
                    'type' => 'image',
                    'heading' => esc_html__( 'Main image', 'midnight' ),
                    'param_name' => 'image_main',
                    'description' => 'Recommended image size: 570px X 700px.'
                ),
                array(
                    'type' => 'image',
                    'heading' => esc_html__( 'Sub image', 'midnight' ),
                    'param_name' => 'image_sub',
                    'description' => 'Recommended image size: 400px X 540px.'
                ),
                array(
                    'type' => 'true_false',
                    'heading' => 'Enable link button',
                    'param_name' => 'enable_button',
                ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Button label', 'midnight' ),
                        'param_name' => 'label',
                        'value' => esc_html__( 'Button', 'midnight' ),
                        'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Location', 'midnight' ),
                        'param_name' => 'url',
                        'placeholder' => 'http://',
                        'dependency' => array( 'element' => 'enable_button', 'value' => '1' ),
                    ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            )
        ));
        
    }
    
    static function theme_shop_archive() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Shop archive', 'midnight' ),
            'base' => 'theme_shop_archive',
            'icon' => 'bwpb-icon-theme-archive',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'taxonomies',
                    'heading' => esc_html__( 'Select categories', 'midnight' ),
                    'tx_type' => 'product_cat',
                    'multiple' => true,
                    'param_name' => 'tax',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            )
        ));
        
    }
    
    static function theme_product_thumbs() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Product thumbs', 'midnight' ),
            'base' => 'theme_product_thumbs',
            'icon' => 'bwpb-icon-theme-thumbs',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array_merge( self::$shop_filter, array(
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Number of products', 'midnight' ),
                    'param_name' => 'number_of_posts',
                    'min' => 2,
                    'max' => 20,
                    'step' => 1,
                    'value' => 3,
                    'append_before' => '',
                    'append_after' => 'posts.',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            ))
        ));
        
    }
    
    static function theme_customers_say() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Customers say', 'midnight' ),
            'base' => 'theme_customers_say',
            'icon' => 'bwpb-icon-theme-customers-say',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'image',
                    'heading' => esc_html__( 'Image', 'midnight' ),
                    'param_name' => 'image',
                    'description' => 'Recommended image size: 100px X 100px.'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Name', 'midnight' ),
                    'param_name' => 'name',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Sub text', 'midnight' ),
                    'param_name' => 'sub_text',
                ),
                array(
                    'type' => 'editor',
                    'param_name' => 'content',
                    'heading' => esc_html__( 'Content', 'midnight' ),
                    'value' => 'Customers say. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
                    'is_content' => true,
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            )
        ));
        
    }
    
    static function theme_custom_product() {
        
        Bwpb_map::map(array(
            'name' => esc_html__( 'Custom product', 'midnight' ),
            'base' => 'theme_custom_product',
            'icon' => 'bwpb-icon-theme-custom-product',
            'open_settings_on_create' => true,
            'category' => esc_html__( 'Theme', 'midnight' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'midnight' ),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'number_slider',
                    'heading' => esc_html__( 'Title font size', 'midnight' ),
                    'param_name' => 'title_font_size',
                    'min' => 18,
                    'max' => 80,
                    'step' => 1,
                    'value' => 30,
                    'append_before' => '',
                    'append_after' => 'px.',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Sub text', 'midnight' ),
                    'param_name' => 'sub_text',
                ),
                array(
                    'type' => 'image',
                    'heading' => esc_html__( 'Upload product image', 'midnight' ),
                    'param_name' => 'image',
                ),
                array(
                    'type' => 'post',
                    'post_type' => 'product',
                    'heading' => esc_html__( 'Link to product', 'midnight' ),
                    'description' => esc_html__( 'Make this item purchasable by linking it to a real product.', 'midnight' ),
                    'param_name' => 'link',
                ),
                array(
                    'type' => 'textfield',
                    'param_name' => 'class'
                )
            )
        ));
        
    }
    
    /*----------------------------------*/
    /* shortcodes
    /*----------------------------------*/
    
    static function pb_shortcode_theme_slider_wrapper( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'pagination'       => false,
            'autoplay'         => false,
            'bg_color'         => 'transparent',
            'full_height'      => false,
            'full_width'       => false,
            'nav_white'         => false,
            'class'            => '',
        ), $atts));
        
        $style = '';
        $style .= $bg_color ? 'background-color:' . esc_attr( $bg_color ) : '';
        
        $class .= $full_width ? '' : ' bw-row';
        $class .= $full_height ? ' bw-creanim-full' : '';
        $class .= $nav_white ? ' bw-nav-white' : '';
        
        $attributes = 'data-slides="1"';
        $attributes .= $autoplay ? ' data-autoplay' : '';
        $attributes .= $pagination ? ' data-pagination' : '';
        
        return "<div class='bw-creanim-slider bw-slider " . esc_attr( $class ) . "' style='{$style}' {$attributes}>".
            do_shortcode( $content ).
        "</div>";
        
    }
    
    static function pb_shortcode_theme_slider_item( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'bg_image'          => '',
            'bg_position'       => 'center center',
            
            'title'             => '',
            'sub_title'         => '',
            'summary'           => '',
            'summary_spacing'   => '0',
            'bg_text'           => '',
            'bg_text_size'      => '245',
            'alt_text'          => '',
            'text_position'     => 'center-center',
            'white_text'        => false,
            'enable_button'     => false,
            'button_label'      => '',
            'button_url'        => '',
            
            'class'             => '',
        ), $atts));
        
        $style  = $content = '';
        $style .= ! empty( $bg_image ) ? 'background-image:url("' . esc_url( $bg_image ) . '");' : '';
        $style .= ! empty( $bg_position ) ? 'background-position:' . esc_attr( $bg_position ) . ';' : '';
        $style .= ! empty( $bg_text_size ) ? 'font-size:' . esc_attr( $bg_text_size ) . 'px;' : '';
        
        $content .= ! empty( $title ) ? "<h2>" . esc_html( $title ) . "</h2>" : '';
        $content .= ! empty( $alt_text ) ? "<p class='bw-creanim-alt-text'>" . esc_html( $alt_text ) . "</p>" : '';
        $content .= ! empty( $sub_title ) ? "<h3>" . esc_html( $sub_title ) . "</h3>" : '';
        $content .= ! empty( $summary ) ? "<p class='bw-creanim-summary' style='letter-spacing:" . esc_attr( $summary_spacing ) . "px'>" . esc_html( $summary ) . "</p>" : '';
        
        $class .= $white_text ? ' bw-creanim-white' : '';
        
        $button = $enable_button ? '<a class="bw-creanim-button" href="' . esc_html( $button_url ) . '">' . esc_html( $button_label ) . '</a>' : '';
        
        return "<div class='bw-creanim " . esc_attr( $class ) . "' style='{$style}'>".
            "<div class='bw-row bw-relative' style='height:100%;'><div class='bw-creanim-content bw-creanim-position-" . esc_attr( $text_position ) . "'>".
                "<span class='bw-creanim-bg-text'>" . esc_html( $bg_text ) . "</span>".
                "<div class='bw-creanim-box'>{$content}{$button}</div>".
            "</div></div>".
        "</div>";
        
    }
    
    static function pb_shortcode_theme_text_anim( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'title'             => '',
            'sub_title'         => '',
            'summary'           => '',
            'summary_spacing'   => '0',
            'bg_text'           => '',
            'bg_text_size'      => '245',
            'alt_text'          => '',
            'text_position'     => 'center-center',
            'white_text'        => false,
            'text_shadow'       => false,
            'enable_button'     => false,
            'button_label'      => '',
            'button_url'        => '',
            'class'             => '',
        ), $atts));
        
        $style  = $content = '';
        $style .= ! empty( $bg_text_size ) ? 'font-size:' . esc_attr( $bg_text_size ) . 'px;' : '';
        
        $content .= ! empty( $title ) ? "<h2>" . esc_html( $title ) . "</h2>" : '';
        $content .= ! empty( $alt_text ) ? "<p class='bw-creanim-alt-text'>" . esc_html( $alt_text ) . "</p>" : '';
        $content .= ! empty( $sub_title ) ? "<h3>" . esc_html( $sub_title ) . "</h3>" : '';
        $content .= ! empty( $summary ) ? "<p class='bw-creanim-summary' style='letter-spacing:" . esc_attr( $summary_spacing ) . "px'>" . esc_html( $summary ) . "</p>" : '';
        
        $class .= $white_text ? ' bw-creanim-white' : '';
        $class .= $text_shadow ? ' bw-creanim-shadow' : '';
        
        $button = $enable_button ? '<a class="bw-creanim-button" href="' . esc_html( $button_url ) . '">' . esc_html( $button_label ) . '</a>' : '';
        
        return "<div class='bw-text-animation bw-creanim " . esc_attr( $class ) . "' style='{$style}'>".
            "<div class='bw-row bw-relative' style='height:100%;'><div class='bw-creanim-content bw-creanim-position-" . esc_attr( $text_position ) . "'>".
                "<span class='bw-creanim-bg-text'>" . esc_html( $bg_text ) . "</span>".
                "<div class='bw-creanim-box'>{$content}{$button}</div>".
            "</div></div>".
        "</div>";
        
    }
    
    static function pb_shortcode_theme_icon_text_wrapper( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'white_color'       => false,
            'class'             => '',
        ), $atts));
        
        $class .= $white_color ? ' bw-icon-white' : '';
        
        return "<div class='bw-icon-text-wrapper bw-table " . esc_attr( $class ) . "'>".do_shortcode( $content )."</div>";
        
    }
    
    static function pb_shortcode_theme_icon_text_item( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'title'             => '',
            'summary'           => '',
            'icon'              => '',
            'class'             => '',
        ), $atts));
        
        return "<div class='bw-cell " . esc_attr( $class ) . "'>".
            "<div class='bw-icon-text'>".
                "<i class='" . esc_attr( Bwpb::get_icon( $icon ) ) . "'></i>".
                "<h3>" . esc_html( $title ) . "</h3>".
                "<p>" . esc_html( $summary ) . "</p>".
            "</div>".
        "</div>";
        
    }
    
    static function pb_shortcode_theme_featured_products( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'category'          => '',
            'tab_featured'      => false,
            'tab_best_sellers'  => false,
            'tab_sale'          => false,
            'tab_new'           => false,
            'tab_new_badge'     => false,
            'number_of_posts'   => 4,
            'items_per_row'     => 4,
            'class'             => '',
        ), $atts));
        
        $tabs = array();
        if( $tab_featured ) { $tabs['tab_featured'] = esc_html__( 'Featured', 'midnight' ); }
        if( $tab_best_sellers ) { $tabs['tab_best_sellers'] = esc_html__( 'Best sellers', 'midnight' ); }
        if( $tab_sale ) { $tabs['tab_sale'] = esc_html__( 'On sale', 'midnight' ); }
        if( $tab_new ) { $tabs['tab_new'] = esc_html__( 'New arrival', 'midnight' ); }
        if( $tab_new_badge ) { $tabs['tab_new_badge'] = esc_html__( 'New', 'midnight' ); }
        $cats = ! empty( $category ) ? ' data-category="' . esc_attr( $category ) . '"' : '';
        
        ob_start();
        
        echo '<div class="bw-featured-products bw-cols-' . (int)$items_per_row . '" data-items_per_row="' . (int)$items_per_row . '" data-number_of_posts="' . (int)$number_of_posts . '"' . $cats . '>';
        
        if( count( $tabs > 1 ) ) {
            
            echo '<ul class="bw-featured-tabs bw-no-select">';
            
            $c = 0;
            global $woocommerce_loop;
            $woocommerce_loop['columns'] = (int)$items_per_row;
            
            foreach( $tabs as $tab => $label ) {
                if( $c == 0 ) {
                    $source = str_replace( 'tab_', '', $tab ); //featured, best_sellers, sale, new_badge
                }
                echo "<li data-tab='{$tab}' " . ( $c == 0 ? 'class="bw-active"' : '' ) . ">{$label}</li>";
                $c++;
            }
            echo '</ul>';
        }
        
        if( ! empty( $category ) ) {
            $quary_raw['tax_query'] = array(
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'id', 
                    'terms'     => array_filter( explode(',', $category) )
                )
            );
        }
        
        require( BW_ROOT . 'templates/query-products.php' );
        
        if ( $output->have_posts() ) {
            echo "<div class='woocommerce'>";
            echo "<ul class='products'>";
            while ( $output->have_posts() ) { $output->the_post();
                woocommerce_get_template_part('content', 'product');
            }
            echo "</ul>";
            echo "</div>";
        }
        wp_reset_postdata();
        
        echo '</div>';
        
        return ob_get_clean();
        
    }
    
    static function pb_shortcode_theme_featured_products_slider( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'category'          => '',
            'tab_featured'      => false,
            'tab_best_sellers'  => false,
            'tab_sale'          => false,
            'tab_new'           => false,
            'tab_new_badge'     => false,
            'autoplay'          => false,
            'navigation'        => false,
            'number_of_posts'   => 4,
            'items_per_row'     => 4,
            'class'             => '',
        ), $atts));
        
        $tabs = array();
        if( $tab_featured ) { $tabs['tab_featured'] = esc_html__( 'Featured', 'midnight' ); }
        if( $tab_best_sellers ) { $tabs['tab_best_sellers'] = esc_html__( 'Best sellers', 'midnight' ); }
        if( $tab_sale ) { $tabs['tab_sale'] = esc_html__( 'On sale', 'midnight' ); }
        if( $tab_new ) { $tabs['tab_new'] = esc_html__( 'New arrival', 'midnight' ); }
        if( $tab_new_badge ) { $tabs['tab_new_badge'] = esc_html__( 'New', 'midnight' ); }
        $cats = ! empty( $category ) ? ' data-category="' . esc_attr( $category ) . '"' : '';
        
        $slider_data  = ' data-slides="' . (int)$items_per_row . '"';
        $slider_data .= $autoplay ? ' data-autoplay' : '';
        $slider_data .= $navigation ? ' data-navigation' : '';
        
        ob_start();
        
        echo '<div class="bw-featured-products bw-cols-' . (int)$items_per_row . '" data-items_per_row="' . (int)$items_per_row . '" data-number_of_posts="' . (int)$number_of_posts . '"' . $cats . '>';
        
        if( count( $tabs > 1 ) ) {
            
            echo '<ul class="bw-featured-tabs bw-no-select">';
            
            $c = 0;
            global $woocommerce_loop;
            $woocommerce_loop['columns'] = (int)$items_per_row;
            
            foreach( $tabs as $tab => $label ) {
                if( $c == 0 ) {
                    $source = str_replace( 'tab_', '', $tab ); //featured, best_sellers, sale, new_badge
                }
                echo "<li data-tab='{$tab}' " . ( $c == 0 ? 'class="bw-active"' : '' ) . ">{$label}</li>";
                $c++;
            }
            echo '</ul>';
        }
        
        if( ! empty( $category ) ) {
            $quary_raw['tax_query'] = array(
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'id', 
                    'terms'     => array_filter( explode(',', $category) )
                )
            );
        }
        
        require( BW_ROOT . 'templates/query-products.php' );
        
        if ( $output->have_posts() ) {
            echo "<div class='woocommerce bw-row'>";
            echo "<ul class='bw-slider bw-featured-slider products'" . $slider_data . ">";
            while ( $output->have_posts() ) { $output->the_post();
                woocommerce_get_template_part('content', 'product');
            }
            echo "</ul>";
            echo "</div>";
        }
        wp_reset_postdata();
        
        echo '</div>';
        
        return ob_get_clean();
        
    }
    
    static function pb_shortcode_theme_midnight_deal( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'title'             => '',
            'sub_title'         => '',
            'bg_text'           => '',
            'bg_text_size'      => '245',
            'text_position'     => 'center-center',
            'enable_button'     => false,
            'button_url'        => '',
            'button_label'      => '',
            'white_text'        => false,
            'enable_countdown'  => false,
            'countdown_date'    => '',
            'countdown_position'=> 'center',
            'class'             => '',
        ), $atts));
        
        $style  = $content = $countdown = '';
        $style .= ! empty( $bg_position ) ? 'font-size:' . esc_attr( $bg_text_size ) . 'px;' : '';
        $style .= 'font-size:' . esc_attr( $bg_text_size ) . 'px;';
        
        $content .= ! empty( $title ) ? "<h2>" . esc_html( $title ) . "</h2>" : '';
        $content .= ! empty( $sub_title ) ? "<h3>" . esc_html( $sub_title ) . "</h3>" : '';

        $class .= $white_text ? ' bw-creanim-white' : '';

        $button = $enable_button ? '<a class="bw-creanim-button" href="' . esc_html( $button_url ) . '">' . esc_html( $button_label ) . '</a>' : '';
        
        if( $enable_countdown ) {
            
            /* calculate time left */
            $seconds = strtotime( $countdown_date ) - time();
            $days = floor($seconds / 86400);
            $seconds %= 86400;
            $hours = floor($seconds / 3600);
            $seconds %= 3600;
            $minutes = floor($seconds / 60);
            $seconds %= 60;
            
            $php_date = date_parse( $countdown_date );
            $data_date = " data-day='{$php_date['day']}' data-month='{$php_date['month']}' data-year='{$php_date['year']}'";
            
            $countdown = "<div class='bw-deal-counter bw-deal-cd-{$countdown_position}'{$data_date}>".
                "<ul>".
                    "<li><strong>{$days}</strong> " . esc_html__('Days', 'midnight') . "</li>".
                    "<li><strong>{$hours}</strong> " . esc_html__('Hours', 'midnight') . "</li>".
                    "<li><strong>{$minutes}</strong> " . esc_html__('Mins', 'midnight') . "</li>".
                    "<li><strong>{$seconds}</strong> " . esc_html__('Secs', 'midnight') . "</li>".
                "</ul>".
            "</div>";
        }
        
        return "<div class='bw-deal'>".
            "<div class='bw-creanim " . esc_attr( $class ) . "' style='{$style}'>".
                "<div class='bw-creanim-content bw-creanim-position-" . esc_attr( $text_position ) . "'>".
                    "<span class='bw-creanim-bg-text'>" . esc_html( $bg_text ) . "</span>".
                    "<div class='bw-creanim-box'>{$content}{$button}</div>".
                "</div>".
                "<div class='bw-row bw-deal-counter-holder'>{$countdown}</div>".
            "</div>".
        "</div>";
        
    }
    
    static function pb_shortcode_theme_product_picks( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'height'            => '675',
            'enable_countdown'  => false,
            'countdown_date'    => '',
            'countdown_position'=> 'center',
            'class'             => '',
        ), $atts));
        
        $style = '';
        $style .= 'height:' . (int)$height . 'px';
        
        if( $enable_countdown ) {
            
            /* calculate time left */
            $seconds = strtotime( $countdown_date ) - time();
            $days = floor($seconds / 86400);
            $seconds %= 86400;
            $hours = floor($seconds / 3600);
            $seconds %= 3600;
            $minutes = floor($seconds / 60);
            $seconds %= 60;
            
            $php_date = date_parse( $countdown_date );
            $data_date = " data-day='{$php_date['day']}' data-month='{$php_date['month']}' data-year='{$php_date['year']}'";
            
            $countdown = "<div class='bw-deal-counter bw-deal-cd-{$countdown_position}'{$data_date}>".
                "<ul>".
                    "<li><strong>{$days}</strong> " . esc_html__('Days', 'midnight') . "</li>".
                    "<li><strong>{$hours}</strong> " . esc_html__('Hours', 'midnight') . "</li>".
                    "<li><strong>{$minutes}</strong> " . esc_html__('Mins', 'midnight') . "</li>".
                    "<li><strong>{$seconds}</strong> " . esc_html__('Secs', 'midnight') . "</li>".
                "</ul>".
            "</div>";
        }
        
        return "<div class='bw-picks' style='" . $style . "'>".
            do_shortcode( $content ).
            "<div class='bw-row bw-deal-counter-holder'>{$countdown}</div>".
        "</div>";
        
    }
    
    static function pb_shortcode_theme_product_picks_item( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'top'               => '0',
            'left'              => '0',
            'title'             => '',
            'price'             => '',
            'sale_price'        => '',
            'enable_link'       => '',
            'url'               => '',
            'class'             => '',
        ), $atts));
        
        $style = 'top:' . (int)$top . '%;left:' . (int)$left . '%;';
        
        $tag_before = $enable_link ? "a href='" . esc_url( $url ) . "'" : 'div';
        $tag_after  = $enable_link ? "a" : 'div';
        $del = !empty( $sale_price ) ? "<del>" . esc_attr( $sale_price ) . "</del>" : '';
        
        return "<{$tag_before} class='bw-price-label' style='" . $style . "'><h4>" . esc_attr( $title ) . "</h4><div class='bw-table'><div class='bw-cell'>".
            "<strong>" . esc_attr( $price ) . "</strong>{$del}".
        "</div></div></{$tag_after}>";
        
    }
    
    static function pb_shortcode_theme_midnight_latest_posts( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'number_of_posts'   => 3,
            'class'             => '',
        ), $atts));
        
        ob_start();
        
        echo "<div class='bw-latest-posts'>";
        
        require( BW_ROOT . 'templates/query-source.php' );
        
        if ( $output->have_posts() ) {
            $c = 0;
            while ( $output->have_posts() ) { $output->the_post();
                include( locate_template( 'templates/article-midnight-grid.php' ) );
                $c++;
            }
        }
        
        wp_reset_postdata();
        
        echo "</div>";
        
        return ob_get_clean();
        
    }
    
    static function pb_shortcode_theme_collections( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'collection_layout' => '5',
            'class'             => '',
        ), $atts));
        
        global $bw_collection_key;
        $bw_collection_key = 1;
        
        return "<div class='bw-clls-holder'><div class='bw-clls bw-clls-" . esc_attr( $collection_layout ) . " " . esc_attr( $class ) . "'>" . do_shortcode( $content ) . "</div></div>";
        
    }
    
    static function pb_shortcode_theme_collections_item( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'bg_image'          => '',
            'category'          => 0,
            'title'             => '',
            'sub_title'         => '',
            'summary'           => '',
            'font_size'         => '14',
            'enable_border'     => false,
            'white_text'        => false,
            'text_position'     => 'center-center',
            'hide_text'         => false,
            'over_active'       => false,
            'class'             => '',
        ), $atts));
        
        global $bw_collection_key;
        ob_start();
        
        echo '<div class="bw-cll' . ( $over_active ? ' bw-over-active' : '' ) . ' bw-cll-' . (int)$bw_collection_key++ . '" style="font-size:' . (int)$font_size . 'px;">';
        
        $cat_link = get_term_link((int)$category, 'product_cat');
        
        $style  = '';
        $class .= $white_text ? ' bw-white-text' : '';
        $class .= $enable_border ? ' bw-enable-border' : '';
        $class .= $hide_text ? ' bw-hide-text' : '';
        
        $content = '<span class="bw-cll-bg" style="' . ( ! empty( $bg_image ) ? 'background-image:url(' . esc_url( $bg_image ) . ');' : '' ) . '"></span>'.
        '<span class="bw-cll-over"></span>'.
        '<div class="bw-cont ' . esc_attr( $class ) . ' bw-cll-pos-' . esc_attr( $text_position ) . '">'.
            '<div class="bw-table">'.
                '<div class="bw-cell">'.
                    '<h3 class="bw-title">' . esc_attr( $title ) . '</h3>'.
                    '<h4 class="bw-sub-title">' . esc_attr( $sub_title ) . '</h4>'.
                    '<span class="bw-summary">' . esc_attr( $summary ) . '</span>'.
                '</div>'.
            '</div>'.
        '</div>';
        
        $tag_before = ( ! is_object( $cat_link ) and (int)$category > 0 and ! empty( $cat_link ) ) ? "a href='" . esc_url( $cat_link ) . "'" : 'div';
        $tag_after =  ( ! is_object( $cat_link ) and (int)$category > 0 and ! empty( $cat_link ) ) ? 'a' : 'div';
        
        echo "<{$tag_before} class='bw-cll-inner' style='{$style}'>{$content}</{$tag_after}>";
        
        echo '</div>';
        
        return ob_get_clean();
        
    }
    
    static function pb_shortcode_theme_faq( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'class'        => '',
        ), $atts));
        
        global $bw_key;
        $bw_key = 1;
        
        return "<div class='bw-faq-wrapper'>" . do_shortcode( $content ) . "</div>";
        
    }
    
    static function pb_shortcode_theme_faq_item( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'title'             => '',
        ), $atts));
        
        global $bw_key;
        
        return "<div class='bw-faq-item'><div class='bw-faq-title" . ( (int)$bw_key == 1 ? ' bw-active' : '' ) . "'>" . esc_attr( $title ) . "</div><div class='bw-faq-content" . ( (int)$bw_key++ == 1 ? ' bw-active' : '' ) . "'><h3>Q. " . esc_attr( $title ) . "</h3>" . do_shortcode( $content ) . "</div></div>";
        
    }
    
    static function pb_shortcode_theme_lookbook( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'align'             => 'ltr',
            'title'             => '',
            'sub_title'         => '',
            'alt'               => '',
            'image_main'        => '',
            'image_sub'         => '',
            'enable_button'     => false,
            'label'             => '',
            'url'               => '',
            'class'             => '',
        ), $atts));
        
        $class .= ' bw-look-align-' . esc_attr( $align );
        $button = $enable_button ? "<a class='bw-button' href='" . esc_url( $url ) . "'>" . esc_attr( $label ) . "</a>" : '';
        $media = $align == 'ltr' ? "<div class='bw-look-sub bw-cell'><img src='" . esc_url( $image_sub ) . "' alt=''></div><div class='bw-look-main bw-cell'><img src='" . esc_url( $image_main ) . "' alt=''></div>" : "<div class='bw-look-main bw-cell'><img src='" . esc_url( $image_main ) . "' alt=''></div><div class='bw-look-sub bw-cell'><img src='" . esc_url( $image_sub ) . "' alt=''></div>";
        
        return "<div class='bw-look " . esc_attr( $class ) . "'>".
            "<div class='bw-look-info'>".
                "<em>" . esc_attr( $alt ) . "</em>".
                "<h2>" . esc_attr( $title ) . "</h2>".
                "<p>" . esc_attr( $sub_title ) . "</p>".
                $button.
            "</div>".
            "<div class='bw-look-media bw-table'>{$media}</div>".
        "</div>";
    }
    
    static function pb_shortcode_theme_shop_archive( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'tax'               => '',
            'class'             => '',
        ), $atts));
        
        $product_categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'include' => $tax ) );
        
        $output = '<div class="bw-shop-archive ' . esc_attr( $class ) . '">';
        
        if ( count( $product_categories ) > 0 ) {
            foreach ( $product_categories as $product_category ) {
                
                $output .= '<a href="' . get_term_link( $product_category ) . '" class="bw-item"><div class="bw-item-inner">';
                    
                    $thumbnail_id = get_woocommerce_term_meta( $product_category->term_id, 'thumbnail_id', true );
                    
                    $image = wp_get_attachment_image_src( $thumbnail_id, 'bw_349x245_true' );
                    
                    $output .= '<div class="bw-image"><img src="' . ( ! empty( $image[0] ) ? $image[0] : Bw::empty_img( '349x245' ) ) . '" alt="" /><span class="bw-over"></span></div>';
                    
                    $output .= '<div class="bw-cont">'.
                        '<div class="bw-table">'.
                            '<div class="bw-cell">'.
                                '<h4>' . $product_category->name . '</h4>'.
                            '</div>'.
                        '</div>'.
                    '</div>';
                
                $output .= '</div></a>';
            }
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    static function pb_shortcode_theme_product_thumbs( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'source'             => 'latest',
            'category'           => '',
            'number_of_posts'    => 2,
            'class'              => '',
        ), $atts));
        
        ob_start();
        
        require( BW_ROOT . 'templates/query-products.php' );
        
        if ( $output->have_posts() ) {
            echo '<div class="bw-shop-thumbs woocommerce">';
            while ( $output->have_posts() ) { $output->the_post();
                echo '<div class="bw-item' . ( ! has_post_thumbnail() ? ' bw-no-image' : '' ) . '">';
                    $_product = wc_get_product( get_the_ID() );
                    if( has_post_thumbnail() ) {
                        echo '<a href="' . get_permalink() . '" class="bw-image">';
                            the_post_thumbnail('shop_thumbnail');
                        echo '</a>';
                    }
                    echo '<div class="bw-cont bw-table"><div class="bw-cell">';
                        echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
                        echo $_product->get_rating_html();
                        echo '<div class="bw-price">' . $_product->get_price_html() . '</div>';
                        do_action( 'woocommerce_simple_add_to_cart' );
                    echo '</div></div>';
                echo '</div>';
            }
            echo '</div>';
        }
        wp_reset_postdata();
        
        return ob_get_clean();
    }
    
    static function pb_shortcode_theme_customers_say( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'name'              => '',
            'sub_text'          => '',
            'image'             => '',
            'class'             => '',
        ), $atts));
        
        return "<div class='bw-csay " . esc_attr( $class ) . "'>".
            "<div class='bw-thumb'>".
                "<img src='" . esc_url( $image ) . "' alt=''>".
            "</div>".
            "<div class='bw-cont'>".
                "<h3>" . esc_attr( $name ) . "</h3>".
                "<h4>" . esc_attr( $sub_text ) . "</h4>".
                "<div class='bw-csay-content'>" . do_shortcode( $content ) . "</div>".
            "</div>".
        "</div>";
        
    }
    
    static function pb_shortcode_theme_custom_product( $atts, $content ) {
        
        extract(shortcode_atts(array(
            'title'             => '',
            'title_font_size'   => 30,
            'sub_text'          => '',
            'image'             => '',
            'link'              => 0,
            'class'             => '',
        ), $atts));
        
        $_product_after = $woo_button = '';
        
        // link to a real product
        if( (int)$link > 0 ) {
            
            $the_query = new WP_Query( array(
                'p'                     => (int)$link, 
                'post_type'             => 'product',
                'posts_per_page'        => 1
            ) );

            if ( $the_query->have_posts() and function_exists( 'wc_get_product' ) ) {
                
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $_product = wc_get_product( get_the_ID() );
                    $_product_after = str_replace( ',00', '', $_product->get_price_html() );
                    
                    ob_start();
                    do_action( 'woocommerce_simple_add_to_cart' );
                    $woo_button = ob_get_clean();
                }
            }
            wp_reset_postdata();
        }
        
        return "<div class='bw-cproduct bw-table " . esc_attr( $class ) . "'>".
            "<div class='bw-cell'>".
                "<h3 style='font-size:" . (int)$title_font_size . "px'><a href='" . get_permalink() . "'>" . esc_attr( $title ) . "</a></h3>".
                "<p>" . esc_attr( $sub_text ) . "</p>".
                ( $image ? '<img src="' . esc_url( $image ) . '" alt="">' : '' ).'<div class="bw-price" style="font-size:' . (int)$title_font_size * 0.8 . 'px">'.$_product_after.'</div>'.
                $woo_button.
            "</div>".
        "</div>";
        
    }
    
}