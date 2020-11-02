<?php

class Bw_required_plugins {
    
    static $plugins;
    static $config;
    
    static function init() {
        
        require_once( BW_FRAME_LIB . 'tgm-plugin-activation/class-tgm-plugin-activation.php' );
        
        # required plugins
        add_action( 'tgmpa_register', array('Bw_required_plugins', 'required_plugins') );
        
    }
    
    static function required_plugins() {
        
        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        self::$plugins = array(
            # required
            array(
                'name'                  => 'Peenapo Codes', // The plugin name
                'slug'                  => 'peenapo-codes', // The plugin slug (typically the folder name)
                'source'                => BW_FRAME_PLUGINS . 'peenapo-codes-1.3.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => 'http://peenapo.com/', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => 'Peenapo Page Builder',
                'slug'                  => 'peenapo-page-builder',
                'source'                => BW_FRAME_PLUGINS . 'peenapo-page-builder-1.3.zip',
                'required'              => true,
                'version'               => '1.3',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'http://peenapo.com/',
            ),
            # recomended
            array(
                'name'                  => 'Login With Ajax',
                'slug'                  => 'login-with-ajax',
                'source'                => BW_FRAME_PLUGINS . 'login-with-ajax-3.1.5.zip',
                'required'              => false,
                'version'               => '3.1.5',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://wordpress.org/plugins/login-with-ajax/',
            ),
            array(
                'name'                  => 'Envato Wordpress Toolkit',
                'slug'                  => 'envato-wordpress-toolkit',
                'source'                => BW_FRAME_PLUGINS . 'envato-wordpress-toolkit-1.7.3.zip',
                'required'              => false,
                'version'               => '1.7.3',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://github.com/envato/envato-wordpress-toolkit',
            ),
            array(
                'name'                  => 'Contact Form 7',
                'slug'                  => 'contact-form-7',
                'source'                => BW_FRAME_PLUGINS . 'contact-form-7-4.3.1.zip',
                'required'              => false,
                'version'               => '4.3.1',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://wordpress.org/plugins/contact-form-7/',
            ),
            array(
                'name'                  => 'Woocommerce',
                'slug'                  => 'woocommerce',
                'source'                => BW_FRAME_PLUGINS . 'woocommerce.2.4.12.zip',
                'required'              => false,
                'version'               => '2.4.12',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://wordpress.org/plugins/woocommerce/installation/',
            ),
            array(
                'name'                  => 'Yith Woocommerce Wishlist',
                'slug'                  => 'yith-woocommerce-wishlist',
                'source'                => BW_FRAME_PLUGINS . 'yith-woocommerce-wishlist.2.0.13.zip',
                'required'              => false,
                'version'               => '2.0.13',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://wordpress.org/plugins/yith-woocommerce-wishlist/',
            ),
            
        );
        
        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        self::$config = array(
            'domain'            => 'fnews',                     // Text domain - likely want to be the same as your theme.
            'default_path'      => '',                          // Default absolute path to pre-packaged plugins
            'menu'              => 'install-required-plugins',  // Menu slug
            'has_notices'       => true,                        // Show admin notices or not
            'is_automatic'      => false,                       // Automatically activate plugins after installation or not
            'message'           => '',                          // Message to output right before the plugins table
            'strings'           => array(
                'page_title'                                => esc_html__( 'Install Required Plugins', 'midnight' ),
                'menu_title'                                => esc_html__( 'Install Plugins', 'midnight' ),
                'installing'                                => esc_html__( 'Installing Plugin: %s', 'midnight' ), // %1$s = plugin name
                'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', 'midnight' ),
                'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'midnight' ), // %1$s = plugin name(s)
                'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'midnight' ), // %1$s = plugin name(s)
                'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'midnight' ), // %1$s = plugin name(s)
                'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'midnight' ), // %1$s = plugin name(s)
                'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'midnight' ), // %1$s = plugin name(s)
                'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'midnight' ), // %1$s = plugin name(s)
                'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'midnight' ), // %1$s = plugin name(s)
                'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'midnight' ), // %1$s = plugin name(s)
                'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'midnight' ),
                'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'midnight' ),
                'return'                                    => esc_html__( 'Return to Required Plugins Installer', 'midnight' ),
                'plugin_activated'                          => esc_html__( 'Plugin activated successfully.', 'midnight' ),
                'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', 'midnight' ), // %1$s = dashboard link
                'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )
        );
        
        tgmpa( self::$plugins, self::$config );
        
    }
    
}