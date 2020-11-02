<?php

class Bw_theme_ajax {
    
    static $funcs = array(
        '__call_megamenu_switch',
        '__call_prod_wishlist',
        '__call_quick_look',
        '__call_add_to_cart',
        '__call_featured_products',
        '__call_facebook_login',
        '__call_google_login',
    );

    static function init() {

        # localize script
        add_action( 'wp_footer', array( 'Bw_theme_ajax', 'bw_ajax' ) );

        self::alocate_callbacks();
        
    }

    static function bw_ajax() {
        
        wp_localize_script( 'bw-main', 'bw_theme_ajax', array(
            'ajax' => admin_url( 'admin-ajax.php' ),
            'ismobile' => wp_is_mobile(),
            'home' => home_url(),
            'uri_assets' => BW_URI_ASSETS,
            'nonce' => wp_create_nonce( 'ajax-nonce' ),
            'string_facebook_signin' => esc_html__('Signing in to Facebook', 'midnight'),
            'string_facebook_error' => esc_html__('Could not sign into to Facebook!', 'midnight'),
            'string_google_signin' => esc_html__('Signing in to Google!', 'midnight'),
            'string_google_error' => esc_html__('Could not sign into to Google!', 'midnight'),
        ));
        
    }

    static function alocate_callbacks() {
        
        foreach( self::$funcs as $func ) {
            
            add_action( 'wp_ajax_nopriv_' . $func, array( 'Bw_theme_ajax', $func ) );
            add_action( 'wp_ajax_' . $func, array( 'Bw_theme_ajax', $func ) );
            
        }
    }
    
    static function __call_megamenu_switch() {
        
        $args = array(
            'numberposts'   => 3,
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'ignore_sticky_posts' => false,
            'category'      => (int)$_POST['category'],
        );

        global $post;

        $output = get_posts( $args );
        if( count( $output ) > 0 ) {
            foreach ( $output as $post ) {
                setup_postdata( $post );
                get_template_part('templates/megamenu-item');
            }
        }else{
            echo '<p>' . esc_html__('No articles were found..', 'midnight') . '</p>';
        }
        wp_reset_postdata();
        exit;
    }
    
    static function __call_prod_wishlist() {
        
        get_template_part('templates/header/prod-wishlist');
        exit;
        
    }
    
    static function __call_quick_look() {
        
        get_template_part('templates/modal-quick-look');
        exit;
        
    }
    
    static function __call_add_to_cart() {
        
        WC()->cart->add_to_cart();
        exit;
        
    }
    
    static function __call_featured_products() {
        
        $number_of_posts = (int)$_POST['number_of_posts'];
        $items_per_row = (int)$_POST['items_per_row'];
        $source = esc_attr( str_replace( 'tab_', '', $_POST['tab'] ) );
        $category = isset( $_POST['category'] ) ? esc_attr( $_POST['category'] ) : false;
        
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
            
            global $woocommerce_loop;
            $woocommerce_loop['columns'] = $items_per_row;
            
            while ( $output->have_posts() ) { $output->the_post();
                woocommerce_get_template_part('content', 'product');
            }
        }
        wp_reset_postdata();
        exit;
        
    }
    
    static function reales_social_signup($email, $signin_user, $first_name, $last_name, $pass) {
        $user_data = array(
            'user_login' => $signin_user,
            'user_email' => $email,
            'user_pass'  => $pass,
            'first_name' => $first_name,
            'last_name'  => $last_name
        );

        if(email_exists($email)) {
            if(username_exists($signin_user)) {
                return;
            } else {
                $user_data['user_email'] = ' ';
                $new_user = wp_insert_user($user_data);
                if(is_wp_error($new_user)) {
                    // social user signup failed
                }
            }
        } else {
            if(username_exists($signin_user)) {
                return;
            } else {
                $new_user = wp_insert_user($user_data);
                if(is_wp_error($new_user)) {
                    // social user signup failed
                }
            }
        }
    }
    
    static function __call_facebook_login() {
        
        if( is_user_logged_in() ) { 
            echo json_encode( array( 'signedin' => true, 'message' => esc_html__( 'You are already signed in, redirecting...', 'reales' ) ) );
            exit();
        }
        check_ajax_referer( 'signin_ajax_nonce', 'security' );

        $reales_auth_settings = get_option('reales_auth_settings','');
        $fb_app_id = isset($reales_auth_settings['reales_fb_id_field']) ? $reales_auth_settings['reales_fb_id_field'] : '';
        $fb_app_secret = isset($reales_auth_settings['reales_fb_secret_field']) ? $reales_auth_settings['reales_fb_secret_field'] : '';

        $user_id = isset($_POST['userid']) ? sanitize_text_field($_POST['userid']) : '';
        $signin_user = isset($_POST['signin_user']) ? sanitize_text_field($_POST['signin_user']) : '';
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
        $avatar = isset($_POST['avatar']) ? sanitize_text_field($_POST['avatar']) : '';
        $signin_pass = $fb_app_secret.$user_id;

        self::reales_social_signup($email, $signin_user, $first_name, $last_name, $signin_pass);

        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID');
            session_start();
        }

        wp_clear_auth_cookie();
        $data = array();
        $data['user_login'] = $signin_user;
        $data['user_password'] = $signin_pass;
        $data['remember'] = true;

        $user_signon = wp_signon($data, false);
        update_user_meta($user_signon->ID, 'bw_avatar', $avatar);

        if(is_wp_error($user_signon)) {
            echo json_encode( array( 'signedin' => false, 'message' => esc_html__( 'Something went wrong!', 'reales' ) ) );
            exit();
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode( array( 'signedin' => true, 'message' => esc_html__('Sign in successful, redirecting...', 'reales' ) ) );
        }
        exit;
        
    }
    
    static function __call_google_login() {
        
        if(is_user_logged_in()) { 
            echo json_encode( array( 'signedin' => true, 'message' => esc_html__('You are already signed in, redirecting...', 'reales' ) ) );
            exit();
        }
        check_ajax_referer( 'signin_ajax_nonce', 'security' );

        $reales_auth_settings = get_option('reales_auth_settings','');
        $google_client_id = isset($reales_auth_settings['reales_google_id_field']) ? $reales_auth_settings['reales_google_id_field'] : '';
        $google_client_secret = isset($reales_auth_settings['reales_google_secret_field']) ? $reales_auth_settings['reales_google_secret_field'] : '';

        $user_id = isset($_POST['userid']) ? sanitize_text_field($_POST['userid']) : '';
        $signin_user = isset($_POST['signin_user']) ? sanitize_text_field($_POST['signin_user']) : '';
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
        $avatar = isset($_POST['avatar']) ? sanitize_text_field($_POST['avatar']) : '';
        $signin_pass = $google_client_secret.$user_id;

        self::reales_social_signup($email, $signin_user, $first_name, $last_name, $signin_pass);

        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID');
            session_start();
        }

        wp_clear_auth_cookie();
        $data = array();
        $data['user_login'] = $signin_user;
        $data['user_password'] = $signin_pass;
        $data['remember'] = true;

        $user_signon = wp_signon( $data, false );
        update_user_meta( $user_signon->ID, 'bw_avatar', $avatar );

        if( is_wp_error( $user_signon ) ) {
            echo json_encode( array( 'signedin' => false, 'message' => esc_html__( 'Something went wrong!', 'reales' ) ) );
            exit();
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode( array( 'signedin' => true, 'message' => esc_html__( 'Sign in successful, redirecting...', 'reales' ) ) );
        }
        exit;
        
    }

}