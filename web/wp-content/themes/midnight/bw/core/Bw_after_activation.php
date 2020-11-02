<?php

class Bw_after_activation {

    static function init() {

        if( self::on_theme_activation() ) {

            # load option tree settings - call always after activating the theme
            self::ot_settings();

            # load option tree theme options - call only with the first theme activation
            self::ot_theme_options();

            # woocommerce set default thumbnails
            if( Bw_woo::$enable and method_exists( 'Bw_woo', 'set_default_thumbnails' ) ) {
                Bw_woo::set_default_thumbnails();
            }

            # tell wp that the configuration was done
            self::theme_was_installed();

            # redirect to option panel after theme activation
            self::redirect_to_options();
        }
    }

    static function on_theme_activation() {
        global $pagenow;
        return is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php';
    }

    static function theme_was_installed() {
        update_option( 'bw_theme_was_installed_' . 'midnight', true );
    }

    static function is_theme_installed() {
        return get_option( 'bw_theme_was_installed_' . 'midnight', false );
    }

    static function ot_settings() {

        $theme_options_file = BW_DEMO . 'theme-options.php';

        if( file_exists( $theme_options_file ) ) {

            load_template( $theme_options_file );
        }
    }

    static function ot_theme_options() {

        if( !self::is_theme_installed() ) {

            $theme_options_settings = BW_DEMO . 'theme-options-default.txt';

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
    }

    static function redirect_to_options() {
        Bw::redirect( 'themes.php?page=ot-theme-options' );
    }

}