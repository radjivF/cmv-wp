<?php

/**
 * Hook in on activation
 */
class Bw_woo {

    static $enable = true;
    static $active_plugins = array();
    static $wishlist_token = false;

    static function init() {
        
        if( self::$enable == false ) {
            return;
        }
        
        self::$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

        # check if woocommerce plugin is active
        if( in_array( 'woocommerce/woocommerce.php', self::$active_plugins ) ) {

            # enqueue styles
            self::enqueue_assets();

            # main settings
            self::setup();

            # get wishlist token
            add_filter( 'init', array( 'Bw_woo', 'wishlist_token' ) );

            # ajaxify add to cart
            add_filter( 'add_to_cart_fragments', array( 'Bw_woo', 'woocommerce_header_add_to_cart_fragment' ) );
            
            // Remove the product rating display on product loops
            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
            
            # change the default image in loop
            
            if( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
                function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
                    
                    global $post, $product;
                    $output = '<div class="bw-woo-image"><div class="bw-woo-image-inner">';

                    if ( has_post_thumbnail() ) {
                        $output .= get_the_post_thumbnail( $post->ID, $size );              
                    }else{
                        $output .= '<img src="' . BW_URI_ASSETS . 'img/empty/400x559.png" alt="">';
                    }
                    
                    $output .= '</div>';
                    $output .= '<ul class="bw-woo-buttons">';
                    
                    if( $product->price and $product->is_in_stock() and $product->product_type == 'simple' ) {
                        $output .= '<li data-product_id="' . $product->id . '" class="add_to_cart_button product_type_simple bw-woo-button-cart' . ( Bw_woo::is_product_in_cart( $product->id ) ? ' added' : '' ) . '"><img src="' . BW_URI_ASSETS . 'img/cart_white.png" alt=""></li>';
                    }
                    
                    if( Bw_woo::wishlist_active_plugin() ) {
                        $output .= '<li data-product-type="simple" data-product-id="' . $product->id . '" class="add_to_wishlist bw-woo-button-wishlist' . ( Bw_woo::is_product_in_wishlist( $product->id ) ? ' added' : '' ) . '"><img src="' . BW_URI_ASSETS . 'img/wishlist_white.png" alt=""></li>';
                    }
                    
                    $output .= '</ul>';
                    
                    $output .= '</div>';

                    if( Bw::get_option('enable_ql')) {
                        $output .= '<span class="bw-quick-look" data-modal="bw-modal-quick-look" data-product_id="' . $product->id . '">' . esc_html__('Quick look', 'midnight') . '</span>';
                    }
                    
                    $average = $product->get_average_rating();
                    if( $average ) {
                        $output .= '<div class="product-rating">'.
                            '<div class="star-rating" title="' . sprintf( esc_html__( 'Rated %s out of 5', 'woocommerce' ), $average ) . '">'.
                                '<span style="width:' . ( ( $average / 5 ) * 100 ) . '%">'.
                                    '<strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . esc_html__( 'out of 5', 'woocommerce' ).
                                '</span>'.
                            '</div>'.
                        '</div>';
                    }
                    
                    return $output;
                }
            }

            # remove default lightbox
            self::remove_prettyphoto();

            # add custom lightbox to gallery
            self::add_lightbox();

            # change the number of related products displayed
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
            add_action( 'woocommerce_after_single_product_summary', array( 'Bw_woo', 'child_after_summary' ), 20 );
            
            # change shop title
            add_filter( 'woocommerce_page_title', array( 'Bw_woo', 'woo_shop_page_title' ) );
            
            // yith wishlist
            if( self::wishlist_active_plugin() ) {
                add_filter( 'yith_wcwl_button_label', array( 'Bw_woo', 'yit_change_wishlist_label' ) );
                add_filter( 'yith-wcwl-browse-wishlist-label', array( 'Bw_woo', 'yit_change_browse_wishlist_label' ) );
                // replace js file
                add_filter( 'wp_enqueue_scripts', array( 'Bw_woo', 'yit_change_script' ) );
            }
            
            add_filter( 'wp_enqueue_scripts', array( 'Bw_woo', 'quick_view_enqueue' ) );
            
            # quick look
            // image
            add_action( 'bw_quick_look_image', 'woocommerce_show_product_sale_flash', 5 );
            add_action( 'bw_quick_look_image', 'woocommerce_show_product_images', 10 );
            
            // content
            //add_action( 'bw_quick_look_content', 'woocommerce_template_single_title', 5 );
            add_action( 'bw_quick_look_content', 'woocommerce_template_single_rating', 10 );
            add_action( 'bw_quick_look_content', 'woocommerce_template_single_price', 15 );
            add_action( 'bw_quick_look_content', 'woocommerce_template_single_excerpt', 25 );
            add_action( 'bw_quick_look_content', 'woocommerce_template_single_add_to_cart', 30 );
            add_action( 'bw_quick_look_content', 'woocommerce_template_single_meta', 35 );
            
        }
    }
    
    static function is_product_in_cart( $product_id ) {
        if ( count( WC()->cart->get_cart() ) > 0 ) {
            foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
                if ( $values['data']->id == $product_id ) {
                    return true;
                }
            }
        }
        return false;
    }
    
    static function is_product_in_wishlist( $product_id ) {
        global $yith_wcwl;
		$token = is_user_logged_in() ? Bw_woo::$wishlist_token : '';
        $w_items = $yith_wcwl->get_products( array( 'wishlist_token' => $token ) );
        if ( count( $w_items ) > 0 ) {
            foreach ( $w_items as $key => $w_item ) {
                if ( $w_item['prod_id'] == $product_id ) {
                    return true;
                }
            }
        }
        return false;
    }
    
    // get wishlist token
    static function wishlist_token() {
        if( self::wishlist_active_plugin() ) {
            $wishlists = YITH_WCWL()->get_wishlists( array( 'user_id' => get_current_user_id(), 'is_default' => 1 ) );
            if( ! empty( $wishlists ) ) {
                self::$wishlist_token = $wishlists[0]['wishlist_token'];
            }
        }
    }
    
    static function quick_view_enqueue() {
        wp_enqueue_script( 'wc-add-to-cart-variation' );
    }
    
    static function yit_change_script() {
        wp_deregister_script( 'jquery-yith-wcwl' );
        wp_register_script( 'jquery-yith-wcwl', BW_URI_ASSETS . 'js/jquery.yith-wcwl.js', array( 'jquery', 'jquery-selectBox' ), BW_VERSION, true );
        wp_enqueue_script( 'jquery-yith-wcwl' );
        
        $yith_wcwl_l10n = array(
            'ajax_url' => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
            'redirect_to_cart' => get_option( 'yith_wcwl_redirect_cart' ),
            'multi_wishlist' => get_option( 'yith_wcwl_multi_wishlist_enable' ) == 'yes' ? true : false,
            'hide_add_button' => apply_filters( 'yith_wcwl_hide_add_button', true ),
            'is_user_logged_in' => is_user_logged_in(),
            'ajax_loader_url' => YITH_WCWL_URL . 'assets/images/ajax-loader.gif',
            'remove_from_wishlist_after_add_to_cart' => get_option( 'yith_wcwl_remove_after_add_to_cart' ),
            'labels' => array(
                'cookie_disabled' => esc_html__( 'We are sorry, but this feature is available only if cookies are enabled on your browser.', 'yith-woocommerce-wishlist' ),
                'added_to_cart_message' => sprintf( '<div class="woocommerce-message">%s</div>', esc_html__( 'Product correctly added to cart', 'yith-woocommerce-wishlist' ) )
            ),
            'actions' => array(
                'add_to_wishlist_action' => 'add_to_wishlist',
                'remove_from_wishlist_action' => 'remove_from_wishlist',
                'move_to_another_wishlist_action' => 'move_to_another_wishlsit',
                'reload_wishlist_and_adding_elem_action'  => 'reload_wishlist_and_adding_elem'
            )
        );
        
        wp_localize_script( 'jquery-yith-wcwl', 'yith_wcwl_l10n', $yith_wcwl_l10n );
    }
    
    static function yit_change_wishlist_label() {
        return apply_filters( 'yit_change_wishlist_label', esc_html__( 'Wishlist', 'midnight' ) );
    }

    static function yit_change_browse_wishlist_label() {
        return apply_filters( 'yit_change_browse_wishlist_label', esc_html__( 'View Wishlist', 'midnight' ) );
    }
    
    static function woo_shop_page_title( $title ) {
        if( $title == 'Shop' ) {
            return '<div class="bw-row bw-page-title">
                <h1>' . esc_html__( 'The Shop', 'midnight' ) . '</h1>
            </div>';
        }
    }

    static function woo_active_plugin() {
        return in_array( 'woocommerce/woocommerce.php', self::$active_plugins );
    }

    static function wishlist_active_plugin() {
        return in_array( 'yith-woocommerce-wishlist/init.php', self::$active_plugins );
    }

    static function is_woo_page() {
        if( ! function_exists('is_woocommerce' ) ) { return; }
        return is_woocommerce() || is_page( 'store' ) || is_shop() || is_product_category() || is_product() || is_cart() || is_checkout();
    }

    static function set_default_thumbnails() {
        
        if( ! self::$enable ) { return; }
        
        $catalog = array(
            'width' => '350', # px
            'height' => '490', # px
            'crop' => true   # true
        );

        $single = array(
            'width' => '482', # px
            'height' => '672', # px
            'crop' => true   # true
        );

        $thumbnail = array(
            'width' => '70', # px
            'height' => '98', # px
            'crop' => true   # true
        );

        # Image sizes
        update_option( 'shop_catalog_image_size', $catalog );   # Product category thumbs
        update_option( 'shop_single_image_size', $single );   # Single product image
        update_option( 'shop_thumbnail_image_size', $thumbnail );  # Image gallery thumbs
    }

    static function shop_items_per_row() {
        add_filter( 'loop_shop_columns', array( 'Bw_woo', 'loop_columns' ), 999 );
    }

    static function loop_columns() {
        return 3;
    }

    static function register_assets() {
        
        wp_enqueue_script( 'jquery-ui-widget' );
        wp_enqueue_script( 'jquery-ui-mouse' );
        wp_enqueue_script( 'jquery-ui-slider' );
        
    }
    
    static function woocommerce_header_add_to_cart_fragment( $fragments ) {

        global $woocommerce;
        ob_start();
        ?>
        <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>">
            <?php $cart_contents_count = WC()->cart->cart_contents_count; ?>
            <?php if( (int)$cart_contents_count > 0 ): ?><sub class="bw-round animated"><?php echo (int)$cart_contents_count; ?></sub><?php endif; ?>
            <script>App.woocommerce.cartPut(<?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?>);</script>
        </a>
        <?php
        $fragments['a.cart-contents'] = ob_get_clean();
        return $fragments;
    }

    static function enqueue_assets() {

        # Remove default woocommerce styles
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );

        # enqueue theme\'s woocommerce styles
        Bw_assets::addStyle( 'bw-woo-layout',       'assets/css/woocommerce/woocommerce-layout.css' );
        Bw_assets::addStyle( 'bw-woo-smallscreen',  'assets/css/woocommerce/woocommerce-smallscreen.css', array(), BW_VERSION, 'only screen and (max-width: 768px)' );
        Bw_assets::addStyle( 'bw-woo-general',      'assets/css/woocommerce/woocommerce.css' );
    }

    static function setup() {

        add_theme_support( 'woocommerce' );

        add_action( 'init', array( 'Bw_woo', 'jk_remove_wc_breadcrumbs' ) );
    }

    static function jk_remove_wc_breadcrumbs() {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }

    static function is_woo() {

        if( ! function_exists( 'is_woocommerce' ) ) {
            return false;
        }

        return is_woocommerce() or is_cart();
    }

    static function remove_prettyphoto() {
        add_action( 'wp_print_scripts', array( 'Bw_woo', 'deregister_js' ), 100 );
        add_action( 'wp_print_styles', array( 'Bw_woo', 'deregister_css' ), 100 );
    }

    static function deregister_js() {
        if( self::is_woo_page() ) {
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
        }
    }

    static function deregister_css() {
        if( self::is_woo_page() ) {
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
        }
    }

    static function add_lightbox() {
        add_action( 'wp_enqueue_scripts', array( 'Bw_woo', 'enqueue_lighbox_scripts' ) );
    }

    static function enqueue_lighbox_scripts() {
        if( self::is_woo_page() ) {
            //Bw_assets::addStyle( 'bw-magnific-popup', 'assets/css/vendors/jquery.magnific-popup/magnific-popup.css' );
            //Bw_assets::addScript( 'bw-magnific-popup-js', 'assets/js/vendors/jquery.magnific-popup/jquery.magnific-popup.min.js' );
        }
    }

    static function child_after_summary() {
        woocommerce_related_products( array( 'posts_per_page' => 4, 'columns' => 4 ) );
    }
}

if( class_exists('YITH_WCWL_UI') ) {
	class BW_YITH extends YITH_WCWL_UI {
		
        public static function add_to_wishlist_button( $url, $product_type, $exists ) {
			global $product;
			$html = '<span data-product-id="' . $product->id . '" data-product-type="' . $product->product_type . '" class="bw-no-select bw-wishlist-icon add_to_wishlist bw-woo-button-wishlist' . ( Bw_woo::is_product_in_wishlist( $product->id ) ? ' added' : '' ) . '"></span>';
			echo $html;
		}
	}
}