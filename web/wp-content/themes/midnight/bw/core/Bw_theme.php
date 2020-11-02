<?php

class Bw_theme {
    
    static $theme_main_color = '#b99867';
    static $theme_styles;

    static function init() {
        # main components
        if( ! is_admin() ) { add_action( 'after_setup_theme', array( 'Bw_theme', 'components' ) ); } // hook init
        # add list of thumbnails
        self::add_thumbs();
    }

    static function components() {
        # assets
        self::enqueue_assets();
        # set the theme font styles
        Bw_theme_fonts::init();
        # google fonts
        self::declare_fonts();
        # theme header options
        Bw_theme_header_options::init();
        # theme footer options
        Bw_theme_footer_options::init();
        # add additional scripts.
        add_action( 'wp_enqueue_scripts', array('Bw_theme', 'additional_scripts') );
    }

    // thumb sizes
    static function add_thumbs() {
        
        add_image_size( 'bw_375x370_true', 375, 370, true );
        add_image_size( 'bw_349x245_true', 349, 245, true );
        add_image_size( 'bw_750x500_true', 750, 500, true );
        add_image_size( 'bw_1920x1080_true', 1920, 1080, true );
        add_image_size( 'bw_1120', 1120, 9999 );
        add_image_size( 'bw_1120x600_true', 1120, 600, true );
        add_image_size( 'bw_832', 832, 9999 );
        add_image_size( 'bw_832x480_true', 832, 480, true );
        add_image_size( 'bw_570x400_true', 570, 400, true );
        
    }
    
    static function declare_fonts() {
        
        // APPLY MAIN THEME COLORS
        self::$theme_styles = array(
            'color' => "a, .bw-footer-social li a:hover, .bw-share-meta .bw-share-cell a:hover, .bw-header-top .bw-top-menu ul li:hover > a, .woocommerce table.shop_table td.product-name a:hover, .bw-button-light, .bw-mobile-menu .current-menu-item > a, .bw-hm-nav .bw-mobile-menu .bw-buy-theme > a, .widget_product_categories li.current-cat .count, .bw-cproduct h3 a:hover, .woocommerce-tabs ul.tabs li:after, .woocommerce ul.product_list_widget li a:hover, .bw-csay .bw-cont h4, .bw-shop-thumbs .bw-cont h4 a:hover, .woocommerce.bw-shop-thumbs button.button, .bw-shop-archive .bw-item h4, #bw-v3m .bw-menu-nav li.current-menu-parent > a, #bw-v3m .bw-menu-nav li.current-menu-ancestor > a, #bw-v3m .bw-menu-nav li.current-menu-item > a, .bw-header-v1.bw-dark-header h2, .bw-navigation > ul > li.menu-item-has-children:not(.bw-is-supermega) > .bw-sub-menu-holder > .sub-menu li.current-menu-item > a, .bw-navigation ul li.current-menu-item > a, .bw-navigation ul li.current-menu-ancestor > a, .bw-navigation ul li.current-menu-parent > a, .woocommerce .widget_price_filter .price_slider_amount .price_label > span, .widget_product_categories .product-categories li.current-cat > a, .bw-account-nav li.current-menu-item a, .bw-account-nav .bw-active, .woocommerce table.wishlist_table tbody td.product-name a:hover, .bw-look-info h2, .bw-single-post-title, .bw-blog-grid article h3 a, .bw-blog-list article h3 a, .bw-navigation > ul > li.menu-item-has-children:not(.bw-is-supermega) > .bw-sub-menu-holder > .sub-menu li a:hover, .widget_product_tag_cloud a:hover, .widget_tag_cloud a:hover, .bw-more a:hover, .bw-blog-wide article h3 a, .bw-faq-content h3, .bw-newsletter-content h2, .bw-scroller-counter em, #bw-v3m .bw-social a:hover .icon, #bw-v3m .bw-menu-nav li:hover > a, .bw-price-label strong, .bw-cll .bw-title, .widget-title, .bw-latest-posts .bw-info, .bw-latest-posts .bw-more, .bwpb-testimonial-slider .bwpb-testimonial-content > h4, .bw-featured-tabs li:hover, .bw-featured-tabs li:after, .bwpb-heading-section .bwpb-heading-title, .woocommerce ul.products li.product h3:hover, .woocommerce ul.products li.product .price, .bw-prod-subtotal span, .amount, .bw-icon-text i, .bw-icon-text p, .bw-creanim-box h2, .bw-add-nav:hover, .bw-header .bw-navigation ul li a:hover, .bw-breadcrumb ul li span, .bw-content .bw-creanim-alt-text",
            'background' => ".bw-prodb-focus, .post-link, .bw-cart-title ul li:after, .bw-cart-title ul li.bw-active span, .woocommerce span.onsale.bw-isnew, .woocommerce button.button.alt, .bw-woo-buttons li:hover, .bw-setting-icon sub, .woocommerce .widget_price_filter .price_slider_amount .button:hover, .bw-on-focus:after, .widget-title:after, .bw-header-v2.bw-dark-header .bw-shopcart, .bw-super-featured-item:hover .bw-price-label, .bw-price-label:hover, .bw-sub-title:after, .bwpb-heading-line:after, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .bw-search-submit:hover, .bw-button, input[type='submit'], .bw-wishlist-icon.added, .bw-wishlist-icon:hover, .bw-woo-buttons li.added:hover:after",
            'border' => ".bw-prodb-focus, .bw-button-light, .bw-header-v2.bw-dark-header .bw-shopcart sub, .bw-woo-buttons li:hover:after, bw-shop-thumbs .bw-cont h4 a:hover, .bw-shop-thumbs button.button, .bw-wishlist-icon.added, .bw-wishlist-icon:hover, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce input.button.alt",
        );
        
        // FONTS
        Bw_theme_fonts::$fonts = array(
            
            // RALEWAY
            'body' => array(
                'selectors' => array( 'body, html' ),
                'font' => 'Raleway',
                'weight' => '400'
            ),
            
            // MONTSERRAT
            'heading' => array(
                'selectors' => array(
                    'h1,h2,h3,h4,h5,h6, .bw-paged, .bw-share-cell > span, .widget_rss li .rsswidget, .widget_recent_comments, .widget_meta, .widget_pages ul li a, .widget_nav_menu ul li a, .woocommerce table.shop_table td .amount, .woocommerce table.shop_table th, .comment-form-comment label, .comment-form-rating label, .woocommerce-tabs ul.tabs, .bw-mobile-menu, .bw-hm .bw-hm-top .bw-hm-user, .sku_wrapper > span, .tagged_as > span, .posted_in > span, .bw-cproduct .button, .bwpb-pb .bwpb-pb-title, .product_list_widget .amount, .product_list_widget li a, .bw-price, .price_slider_amount, .widget_product_categories .product-categories, .woocommerce .woocommerce-ordering, .woocommerce .woocommerce-result-count, .woocommerce .woocommerce-ordering select, .bw-account-used-sidebar, .woocommerce table.wishlist_table tbody td, .woocommerce table.wishlist_table thead th, .bw-tags > span, .bw-share > span, .widget_categories, .widget_archive, .bw-date, .widget_product_tag_cloud, .widget_tag_cloud, .nav-posts a, .bw-navigation li a, .bw-modal-title a, .bw-social-separator, .bw-faq-content h3, .bw-faq-title, .woocommerce form .form-row label, .bw-blog-wide .bw-more, .bw-price-label, .bw-menu-nav, .bw-scroller-counter, .bw-newsletter-content input[type="submit"], input[type="submit"], .bw-button, .bw-search-submit, .bw-header, .bw-breadcrumb, .bw-creanim .bw-creanim-bg-text, .bw-quick-look, .price .amount, .bw-variation-label, .bw-creanim-button, .bw-featured-tabs, .bw-deal-counter, .bwpb-testimonial-content > h4, .bw-more',
                ),
                'font' => 'Montserrat',
                'weight' => '400,700'
            ),
            
            // LORA
            'alt' => array(
                'selectors' => array(
                    '.bw-breadcrumb h2, .woocommerce table.shop_table td.product-name a, .woocommerce .cart-empty, .bw-order-received h2, .bw-cart-title ul li span, .bwpb-heading-content, .bw-cproduct h3, .bw-quant input, .bw-shop-thumbs h4, .woocommerce table.wishlist_table tbody td.product-name, .bw-look-info em, .bw-look-info h2, .bw-single-post-title, .bw-blog-grid article h3, .bw-ql-title, .woocommerce-review-link, .bw-ql .product_title, .woocommerce div.product .product_title, .bwpb-heading-title, .bwpb-testimonial-content > div, .bw-latest-posts h4, .bw-latest-posts .bw-info, .widget-title, .bw-cll .bw-title, .bw-cll .bw-sub-title, .bw-cll .bw-summary, .bw-newsletter-content h2, .bw-modal-search .bw-search-field, .bw-blog-wide h3, .widget_recent_entries .bw-cont a, .woocommerce ul.products li.product h3, .bw-creanim h2, .bw-creanim h3, .bw-creanim p, .bw-icon-text p, .bw-wishlist-prods .bw-prod-title, .bw-blog-list article h3',
                ),
                'font' => 'Lora',
                'weight' => '400'
            )
            
        );
        
        # add example Google font via Bw_theme_fonts class
        Bw_theme_fonts::add_font(array(
            array('font' => 'Roboto', 'weight' => '400'),
        ));
        
    }

    static function additional_scripts() {
        wp_enqueue_script( 'comment-reply' );
    }

    static function enqueue_assets() {
        
        # css
        Bw_assets::addStyle('style', 'style.css');
        Bw_assets::addStyle('bw-reset', 'assets/css/reset.css');
        Bw_assets::addStyle('bw-style', 'assets/css/style.css');
        Bw_assets::addStyle('bw-media', 'assets/css/media.css');
        
        # js
        if( Bw::get_option( 'enable_smooth_scroll' ) ) {
            Bw_assets::addScript('bw-smooth-scroll', 'assets/js/vendors/jquery.smooth-scroll/jquery.smooth-scroll.min.js', array('jquery'), BW_VERSION, false);
        }
        if( Bw::get_option('google_login') ) {
            Bw_assets::addScript('bw-google', 'https://plus.google.com/js/client:platform.js', array(), '1.0', true);
        }
        Bw_assets::addScript('bw-vendors', 'assets/js/vendors.js', array('jquery'));
        Bw_assets::addScript('bw-main', 'assets/js/main.js', array('jquery', 'bw-vendors'));
        
    }

}