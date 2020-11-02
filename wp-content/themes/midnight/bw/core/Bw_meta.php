<?php

class Bw_meta {
    
    # allow loading acf options by cached file
    static $acf_load_export = true;
    
    # automatic acf field export on modification
    static $acf_export_on_update = true;
    
    # automatic option tree settings export on modification
    static $ot_export_on_update = true;
    
    # provide a list of usernames who can edit custom field definitions here
    static $user_display = array(
        'badweather',
        'midnight',
        'pandamo'
    );
    static $is_peenapo_user = false;
    static $acf_export_path;
    static $ot_export_path;

    static function init() {
        # path to export file
        self::$acf_export_path = BW_FRAME_ROOT . 'demo/theme-acf-options.php';
        self::$ot_export_path = BW_FRAME_ROOT . 'demo/theme-options.php';
        # check user
        self::is_peenapo_user();
        # option tree
        self::option_tree();
        # after theme is on
        add_action( 'after_setup_theme', array( 'Bw_meta', 'after_setup_theme' ) );
        # check if acf on and fix fn get_field
        add_action( 'wp', array( 'Bw_meta', 'acf_fn_get_field' ) );
    }
    
    static function option_tree() {
        
        $enable_ot_menu_item = self::$is_peenapo_user ? '__return_true' : '__return_false';

        add_filter( 'ot_theme_mode', '__return_true' ); // init option tree
        add_filter( 'ot_show_pages', $enable_ot_menu_item ); // This will hide/show the settings & documentation pages
        add_filter( 'ot_show_new_layout', '__return_false' ); // This will hide the "New Layout" section on the Theme Options page
        load_template( BW_FRAME_LIB . 'option-tree/ot-loader.php' ); // load option tree
        
        # automatic option settings export
        if( is_admin() and self::$is_peenapo_user and self::$ot_export_on_update ) {
            self::automatic_ot_export();
        }
    }
    
    static function automatic_ot_export() {
        
        if ( isset( $_REQUEST['action'] ) and $_REQUEST['action'] == 'save-settings' and isset( $_REQUEST['message'] ) and $_REQUEST['message'] == 'success' ) {
            if( is_main_site() and ! is_child_theme() ) {
                add_action( 'admin_init', array( 'Bw_meta', 'ot_custom_export' ), 5 );
            }
        }
        
    }

    static function ot_custom_export() {
        
        ot_export_php_settings_array( self::$ot_export_path );
        
    }

    static function after_setup_theme() {
        
        # add wp admin bar menu items
        add_filter( 'admin_bar_menu', array( 'Bw_meta', 'ot_top_menu_item' ), 999 );
    }

    static function acf_fn_get_field() {
        
        if( ! function_exists( 'get_field' ) ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
                function get_field() { return; }
            }
        }
    }
    
    static function remove_acf_menu() {
        if( ! self::$is_peenapo_user and ! self::is_acf_plugin_active() ) {
            remove_menu_page( 'edit.php?post_type=acf' );
        }
    }
    
    static function is_acf_plugin_active() {
        return in_array( 'advanced-custom-fields/acf.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ? true : false;
    }
    
    static function is_peenapo_user() {
        
        # get the current user
        global $current_user;
        get_currentuserinfo();
        
        # check list of admin users
        self::$is_peenapo_user = in_array( strtolower( $current_user->user_login ), self::$user_display ) ? true : false;
    }
    
    static function automatic_acf_export() {
        
        # only continue if saving acf post, is not a micro site, is not a child theme
        if( get_post_type() !== 'acf' or ! is_main_site() or is_child_theme() or ! defined( 'ACF_PRODUCTION' ) ) { return; }
     
        # only continue if we're saving a field group
        if ( empty( $_GET['message'] ) || ( $_GET['message'] != '1' && $_GET['message'] != '6' ) ) { return; }
        
        $acf = new acf_field_group();
     
        $fields = array();
        $fields = get_posts(array(
            'numberposts'   => -1,
            'post_type'     => 'acf',
            'orderby'       => 'menu_order title',
            'order'         => 'asc',
        ));

        if( $fields ) {
            
            $output = '<?php

if(function_exists("register_field_group")) {
    ';

            foreach( $fields as $field ) {
                
                $uniqid = uniqid();
                
                $var = array(
                    'id' => $field->post_name,
                    'title' => get_the_title($field->ID),
                    'fields' => $acf->get_fields(array(), $field->ID),
                    'location' => $acf->get_location(array(), $field->ID),
                    'options' => $acf->get_options(array(), $field->ID),
                    'menu_order' => $field->menu_order,
                );
                
                $html = var_export($var, true);
                $html = str_replace("  ", "\t", $html); // change double spaces to tabs
                $html = str_replace("\n", "\n\t", $html); // add extra tab at start of each line
                $html = str_replace("array (", "array(", $html); // remove excess space from beginning of arrays
                
                $output .= '
    register_field_group('.$html.'); ';

            }

            $output .= '
}';
            
        }else{
            $output = esc_html__( 'ACF Export: No field groups were selected', 'acf' );
        }
        
        $file = self::$acf_export_path;
        
        if ( is_writable( $file ) ) {
            
            # Initialize the Wordpress filesystem, no more using file_put_contents function
            global $wp_filesystem;
            if ( empty( $wp_filesystem ) ) {
                require_once( ABSPATH . '/wp-admin/includes/file.php' );
                WP_Filesystem();
            }
            $wp_filesystem->put_contents( $file, $output, FS_CHMOD_FILE );
            //file_put_contents( $file, $output );
            define( 'ACF_EXPORT_FILE', $file );
            add_action( 'admin_notices', array( 'Bw_meta', 'acf_export_success' ) );
        }  else {
            add_action( 'admin_notices', array( 'Bw_meta', 'acf_export_fail' ) );
        }
    }
     
    /**
     * Notices to display when export is completed
     */
    static function acf_export_success( $file = '' ) {
        if ( defined( 'ACF_EXPORT_FILE' ) ) {
            $destination = ' to <strong>' . ACF_EXPORT_FILE . '</strong>';
        } else {
            $destination = '';
        }
        echo '<div class="updated"><p>All fields successfully exported'.$destination.'.</p></div>';
    }
    
    static function acf_export_fail( $file = '' ) {
        echo '<div class="error"><p><strong>Automated Export Error:</strong> The export file you\'ve specified is not writeable.</p></div>';
    }
    
    static function ot_export_success( $file = '' ) {
        echo '<div class="updated"><p><strong>All fields successfully exported</strong>: ' . OT_EXPORT_FILE . '.</p></div>';
    }
    
    static function ot_export_fail( $file = '' ) {
        echo '<div class="error"><p><strong>Automated Export Error: </strong> The export file: <strong>' . OT_EXPORT_FILE . '</strong> you\'ve specified is not writeable.</p></div>';
    }

    static function ot_top_menu_item( $wp_admin_bar ) {
        if ( is_admin() && current_user_can( 'manage_options' ) ) {
            $args = array(
                'id' => 'bw_theme_options',
                'title' => 'Theme Options',
                'href' => admin_url( 'themes.php?page=ot-theme-options' ),
                'meta' => array( 'class' => 'bw-admin-bar-options' )
            );
            $wp_admin_bar->add_node( $args );
        }
    }

}