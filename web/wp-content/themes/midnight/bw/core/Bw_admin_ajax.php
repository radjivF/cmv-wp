<?php

class Bw_admin_ajax {

    static $callbacks = array(
        
        '__call_import_theme_options',
        '__call_import_sample_data',
        '__call_import_menus',
        '__call_import_static_pages',
        '__call_import_permalink_format',
        '__call_import_custom_post_meta',
        '__call_import_custom_options',
        
        '__call_gallery_preview',
        '__call_gallery_advanced_preview'
    );

    static function init() {

        # localize script
        add_action( 'admin_footer', array( 'Bw_admin_ajax', 'bw_ajax' ) );

        self::alocate_callbacks();
    }

    static function bw_ajax() {

        wp_localize_script( 'bw-admin', 'bw_admin_root', array( 'ajax' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('ajax-nonce') ) );
    }

    static function alocate_callbacks() {

        foreach( self::$callbacks as $callback ) {

            add_action( 'wp_ajax_nopriv_' . $callback, array( 'Bw_admin_ajax', $callback ) );
            add_action( 'wp_ajax_' . $callback, array( 'Bw_admin_ajax', $callback ) );
        }
    }

    static function __call_import_theme_options() {
        die( Bw_import::ot_theme_options_import() );
    }

    static function __call_import_sample_data() {
        die( Bw_import::create_importer() );
    }

    static function __call_import_menus() {
        die( Bw_import::assign_menus() );
    }

    static function __call_import_static_pages() {
        die( Bw_import::assign_static_pages() );
    }

    static function __call_import_permalink_format() {
        die( Bw_import::assign_permalink_format() );
    }

    static function __call_import_custom_post_meta() {
        die( Bw_import::assign_custom_post_meta() );
    }

    static function __call_import_custom_options() {
        die( Bw_import::assign_custom_options() );
    }

    static function __call_gallery_preview() {

        $result = array( 'success' => false, 'output' => '' );

        $ids = isset( $_REQUEST['attachments_ids'] ) ? $_REQUEST['attachments_ids'] : null;

        if( empty( $ids ) ) {
            die( json_encode( $result ) );
        }

        foreach( explode( ',', $ids ) as $id ) {
            $attach = wp_get_attachment_image_src( $id, 'thumbnail', false );
            $result["output"] .= '<li><img src="' . $attach[0] . '" /></li>';
        }

        $result["success"] = true;
        die( json_encode( $result ) );
    }

    static function __call_gallery_advanced_preview() {

        $result = array( 'success' => false, 'output' => '' );

        $ids = isset( $_REQUEST['attachments_ids'] ) ? $_REQUEST['attachments_ids'] : null;

        $post_meta = get_post_meta( $_REQUEST['post_id'], $_REQUEST['field_name'], true );

        if( isset( $post_meta['items'] ) and is_array( $post_meta['items'] ) ) {
            $items_data = $post_meta['items'];
        }

        if( empty( $ids ) ) {
            die( json_encode( $result ) );
        }

        $default = array(
            'title' => '',
            'caption' => '',
            'video' => false,
            'video_url' => '',
            'video_autoplay' => false
        );

        foreach( explode( ',', $ids ) as $id ) {

            $attach = wp_get_attachment_image_src( $id, 'thumbnail', false );
            $item_data = array_merge( $default, isset( $items_data[$id] ) ? $items_data[$id] : array()  );

            $im = @getimagesize( $attach[0] );

            $popup = '';

            if( $_REQUEST['enabled_advanced'] == 'true' ) {

                $popup = '
                    <div class="gallery-popup-settings">
                        <div class="header"><h4>Text settings</h4><span class="close-popup fa fa-times"></span></div>
                        <div class="cont">
                            
                            <div class="row">
                                <label>' . esc_html__( 'Title', 'midnight' ) . ':</label>
                                <input type="text" name="' . $_POST['field_key'] . '[items][' . $id . '][title]" value="' . $item_data['title'] . '">
                            </div>
                            
                            <div class="row">
                                <label>' . esc_html__( 'Caption', 'midnight' ) . ':</label>
                                <textarea name="' . $_POST['field_key'] . '[items][' . $id . '][caption]">' . $item_data['caption'] . '</textarea>
                            </div>
                            
                            <div class="row">
                                <label>' . esc_html__( 'Add video', 'midnight' ) . ':</label>
                                <label class="bw-on-off enable-video ' . ( $item_data['video'] ? 'checked' : '' ) . '">
                                    <input type="checkbox" ' . ( $item_data['video'] ? 'checked="checked"' : '' ) . ' value="1" name="' . $_POST['field_key'] . '[items][' . $id . '][video]">
                                </label>
                            </div>
                            
                            <div class="enabled-video">
                            
                                <div class="row">
                                    <label>' . esc_html__( 'Video url', 'midnight' ) . ':</label>
                                    <span class="sub-label">
                                        Examples:<br>
                                        Youtube - http://www.youtube.com/watch?v=6v2L2UGZJAM<br>
                                        Vimeo - http://vimeo.com/47989207<br>
                                    </span>
                                    <input type="text" name="' . $_POST['field_key'] . '[items][' . $id . '][video_url]" value="' . $item_data['video_url'] . '">
                                </div>
                                
                                <div class="row">
                                    <label>' . esc_html__( 'Autoplay video', 'midnight' ) . ':</label>
                                    <label class="bw-on-off ' . ( $item_data['video_autoplay'] ? 'checked' : '' ) . '">
                                        <input type="checkbox" ' . ( $item_data['video_autoplay'] ? 'checked="checked"' : '' ) . ' value="1" name="' . $_POST['field_key'] . '[items][' . $id . '][video_autoplay]" class="">
                                    </label>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <span class="btn-done"><i class="fa fa-check"></i>Done</span>
                            </div>
                            
                        </div>
                    </div>
                ';
            }

            $result["output"] .= '
            <li class="' . ( ( $item_data['video'] == true ) ? 'video' : '' ) . '">
                ' . $popup . '
                <div class="item-holder">
                    <img src="' . ( $im ? $attach[0] : BW_URI_FRAME_ASSETS . 'img/admin/empty.png' ) . '">
                    <span class="fa fa-pencil"></span>
                </div>
            </li>';
        }

        $result["success"] = true;
        die( json_encode( $result ) );
    }

}