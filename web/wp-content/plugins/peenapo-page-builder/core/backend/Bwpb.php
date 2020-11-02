<?php

/*----------------------------------*/
/* Back-end
/*----------------------------------*/
class Bwpb_back {
    
    static function init() {
        # mapping
        Bwpb_map::init();
        # shortcode building
        Bwpb_shortcode_definition::init();
        # ajax and callbacks
        Bwpb_back_ajax::init();
        # on load page post.php and post-new.php
        add_action( 'load-post.php', array( 'Bwpb_back', 'on_load_post' ) );
        add_action( 'load-post-new.php', array( 'Bwpb_back', 'on_load_post' ) );
    }
    
    static function on_load_post() {
        
        // check if user can manage options
        if( current_user_can( 'manage_options' ) ) {
            
            // check if the current post type is handled by the page builder
            if( in_array( self::get_current_post_type(), Bwpb::$global['post_types'] ) ) {
                # enqueue scripts
                add_filter( 'admin_body_class', array( 'Bwpb_back', 'statusCheck' ) );
                # enqueue scripts
                Bwpb_assets::init();
                # register page builder
                add_action( 'add_meta_boxes', array( 'Bwpb_back', 'add_custom_box' ) );
                # load footer templates
                add_action( 'admin_footer', array( 'Bwpb_back', 'footer_templates' ) );
                # on save/edit post
                add_action( 'save_post', array( 'Bwpb_back', 'save' ) );
            }
        }
        
    }
    
    static function statusCheck( $classes ) {
        if( Bwpb::bw_check_status() == 1 ) {
            return "{$classes} bwpb-active";
        }
    }
    
    static function get_current_post_type() {
        global $post, $typenow, $current_screen;
        if ( $post && $post->post_type ) {
            return $post->post_type;
        }elseif( $typenow ) {
            return $typenow;
        }elseif( $current_screen && $current_screen->post_type ) {
            return $current_screen->post_type;
        }elseif( isset( $_REQUEST['post_type'] ) ) {
            return sanitize_key( $_REQUEST['post_type'] );
        }
        return null;
    }
    
    static function add_custom_box() {
        
        if ( is_array( Bwpb::$global['post_types'] ) ) {
            
            foreach ( Bwpb::$global['post_types'] as $post_type ) {
                
                add_meta_box(
                    'bw_page_builder_section',
                    __( 'Peenapo Page Builder', PBTD ),
                    array( 'Bwpb_back', 'bw_page_builder_custom_box' ),
                    $post_type,
                    'normal',
                    'high'
                );
            }
        }
    }
    
    static function modal_list() {
        require_once( PB_TEMPLATES . 'backend/modal.tpl.php' );
    }
    
    static function get_children( $children ) {
        if( is_array( $children ) ) {
            return implode(',', $children );
        }
        return $children;
    }
    
    static function bw_check_custom_css() {
        
        $bwpb_custom_css = get_post_meta( get_the_ID(), '_bwpb_custom_css', true );
        if ( ! isset($bwpb_custom_css) or $bwpb_custom_css == "" ) {
            $bwpb_custom_css = '';
        }
        return $bwpb_custom_css;
        
    }
    
    static function bw_page_builder_custom_box( $post ) {
        require_once( PB_TEMPLATES . 'backend/main.tpl.php' );
    }
    
    static function get_free_id() {
        
        $last_id = get_option( "bwpb_last_block_id", 0 );
        
        if ( $last_id <= 2 ) { $last_id = 2; }
        $last_id++;
        
        update_option( "bwpb_last_block_id", $last_id );

        return $last_id;

    }
    
    static function update_builder_data( $post_id, $value, $data ) {
        
        array_walk_recursive( $data, array( 'Bwpb_back', 'sanitize_array' ) );
        update_post_meta( $post_id, $value, $data );
        
    }
    
    static function sanitize_array( &$item, $key ) {
        
        $item = htmlentities( $item, ENT_QUOTES );
        
    }
    
    static function post_param( $param, $default = null ) {
        return isset( $_POST[$param] ) ? $_POST[$param] : $default;
    }
    
    static function footer_templates() {
        require_once( PB_TEMPLATES . 'backend/elements.tpl.php' );
        require_once( PB_TEMPLATES . 'backend/panel-settings.tpl.php' );
        require_once( PB_TEMPLATES . 'backend/panel-icon-fonts.tpl.php' );
    }
    
    static function save( $post_id ) {
        
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
        if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
        
        $status = self::bw_post_param( 'bw_status' );
        $custom_css = isset( $_POST['bw_custom_css'] ) ? strip_tags($_POST['bw_custom_css']) : '';
        if ( $status !== false ) {
            // Add status
            if ( get_post_meta( $post_id, '_bwpb_status' ) == '' ) {
                add_post_meta( $post_id, '_bwpb_status', $status, true );
            }
            // Update status
            elseif ( $status != get_post_meta( $post_id, '_bwpb_status', true ) ) {
                update_post_meta( $post_id, '_bwpb_status', $status );
            }
            // Delete status
            elseif ( $status == '' ) {
                delete_post_meta( $post_id, '_bwpb_status', get_post_meta( $post_id, '_bwpb_status', true ) );
            }
        }
        if ( $custom_css !== false ) {
            // Add custom css
            if ( get_post_meta( $post_id, '_bwpb_custom_css' ) == '' ) {
                add_post_meta( $post_id, '_bwpb_custom_css', $custom_css, true );
            }
            // Update custom css
            elseif ( $custom_css != get_post_meta( $post_id, '_bwpb_custom_css', true ) ) {
                update_post_meta( $post_id, '_bwpb_custom_css', $custom_css );
            }
            // Delete custom css
            elseif ( $custom_css == '' ) {
                delete_post_meta( $post_id, '_bwpb_custom_css', get_post_meta( $post_id, '_bwpb_custom_css', true ) );
            }
        }
    }
    
    static function bw_post_param( $param, $default = null ) {
        return isset( $_POST[$param] ) ? $_POST[$param] : $default;
    }
    
    # returns the header of the param
    static function get_param_header( $param ) {
        $output  = '';
        if( isset( $param['heading'] ) ) {
            $output .= "<h5>" . esc_attr( $param['heading'] ) . "</h5>";
        }
        if( isset( $param['description'] ) ) {
            $output .= "<p> " . stripslashes( wp_kses(
                $param['description'],
                array(
                    'a' => array(
                        'href' => array(),
                        'title' => array(),
                        'target' => array()
                    ),
                    'br' => array(),
                    'em' => array(),
                    'strong' => array(),
                    'img' => array(
                        'src' => array(),
                        'alt' => array(),
                        'class' => array(),
                        'style' => array(),
                    ),
                )
            ) ) . "</p>";
        }
        return $output;
    }
    
}

?>