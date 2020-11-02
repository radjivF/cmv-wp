<?php

/*----------------------------------*/
/* Front-end
/*----------------------------------*/
class Bwpb_front {
	
	static function init() {
        
        # enqueue javascript and css files
        Bwpb_assets::init();
		# define shortcodes
		Bwpb_shortcode_definition::init();
        # set custom css
        add_action( 'wp_head', array( 'Bwpb_front', 'custom_css' ) );
        # map
        Bwpb_map::init();
        
        # custom class settings
        add_filter('body_class', array( 'Bwpb_front', 'body_class_settings' ));
		
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
    
    static function custom_css() {
        
        $cont_max = Bwpb::$global['container_max_with'];
        
        echo "<style>".
            ".bwpb-row-holder.bwpb-row-full_width_background > .bwpb-row, .bwpb-row-holder.bwpb-row-in_container, .bwpb-wrapper {max-width:{$cont_max}px;}".
        "</style>";
        
        $post_css = get_post_meta( get_the_ID(), '_bwpb_custom_css', true );
        echo "<style>" . strip_tags( $post_css ) . "</style>";
        
        // mobile styles
        if( wp_is_mobile() ) {
            echo "<style>.reveal-scrolling {opacity:1;}</style>";
        }
        
    }
    
    static function body_class_settings( $classes ) {
        if( Bwpb::$global['align_tables'] ) {
            $classes[] = 'bwpb-align-tables';
        }
        return $classes;
    }
    
    static function get_animation_data() {
        return array(
            'animation' => false,
            'animation_type' => 'fadeIn',
            'animation_delay' => 0
        );
    }
    
    static function get_background_data( $a ) {
        
        $bg = array(
            'style' => '',
            'style_holder' => '',
            'class' => '',
            'class_holder' => '',
            'overlay' => '',
            'data' => '',
            'parallax' => '',
            'multi' => '',
            'video' => ''
        );
        
        $bg_image_position = $a['bg_image_position'] == 'default' ? 'center center' : $a['bg_image_position'];
        
        if( $a['background_type'] !== 'none' ) {
            
            switch( $a['background_type'] ) {
                case 'color':
                    $bg['style_holder'] .= $a['bg_color'] ? "background-color:{$a['bg_color']};" : '';
                    break;
                case 'image':
                    $cover = $a['bg_image_fullscreen'] ? 'background-size:cover;' : '';
                    $fixed = $a['bg_image_fixed'] ? 'background-attachment:fixed;' : '';
                    $bg['style_holder'] .= "background:transparent url({$a['bg_image']}) {$a['bg_image_repeat']} {$bg_image_position};{$cover};{$fixed}";
                    $bg['style_holder'] .= $a['bg_image_bg_color'] ? "background-color:{$a['bg_image_bg_color']};" : '';
                    $bg['overlay'] = $a['bg_image_overlay'] ? "<div class='bwpb-overlay' style='background-color:{$a['bg_image_overlay']}'></div>" : '';
                    break;
                case 'moving':
                    $bg['style_holder'] .= $a['bg_moving_bg_color'] ? "background:{$a['bg_moving_bg_color']} url({$a['bg_moving_image']}) repeat 0 0;" : '';
                    $bg['class_holder'] .= ' bwpb-moving-background';
                    $bg['data'] = "data-direction='{$a['bg_moving_direction']}'";
                    break;
                case 'parallax':
                    $bg['style_holder'] .= $a['bg_parallax_bg_color'] ? "background-color:{$a['bg_parallax_bg_color']};" : '';
                    $bg['class'] .= ' bwpb-parallax-background';
                    $bg['overlay'] = $a['bg_parallax_overlay_color'] ? "<div class='bwpb-overlay' style='background-color:{$a['bg_parallax_overlay_color']};'></div>" : '';
                    for( $i = 1; $i <= 6; $i++ ) {
                        if( $a["bg_parallax_enable_{$i}"] ) {
                            $datasize = $a["bg_parallax_fullwidth_{$i}"] ? "cover;" : "nostretch";
                            $bg['parallax'] .= "<img class='bwpb-background-parallax' src='" . $a["bg_parallax_image_{$i}"] . "' alt='' data-speed='" . $a["bg_parallax_speed_{$i}"] . "' data-sizemode='{$datasize}' data-position='" . $a["bg_parallax_position_{$i}"] . "' />";
                        }
                    }
                    break;
                case 'multi_parallax':
                    $patterns = array('/top/', '/right/', '/bottom/', '/left/');
                    $replacements = array('margin-top:-10%;', 'margin-right:-10%;', 'margin-bottom:-10%;', 'margin-left:-10%;');
                    $bg['style_holder'] .= $a['bg_multi_parallax_bg_color'] ? "background-color:{$a['bg_multi_parallax_bg_color']};" : '';
                    $bg['multi'] .= "<div class='bwpb-multilayer-parallax'>";
                    if( wp_is_mobile() ) {
                        $bg['multi'] .= "<div class='bwpb-mobile-preview' style='background-image: url({$a['bg_multi_mobile_placeholder']})'></div>";
                    }else{
                        for( $i = 1; $i <= 8; $i++ ) {
                            if( $a["bg_multi_parallax_enable_{$i}"] ) {
                                $margins = preg_replace( $patterns, $replacements, $a["bg_multi_parallax_position_{$i}"] );
                                if( $a["bg_multi_parallax_position_{$i}"] == 'center center' and $a["bg_multi_parallax_fullwidth_{$i}"] ) {
                                    $margins = 'margin-top:-10%!important;right:-10%;bottom:-10%;margin-left:-10%!important;';
                                }
                                if( $a["bg_multi_parallax_depth_{$i}"] == 0 ) {
                                    $margins = '';
                                }
                                $bg_size = $a["bg_multi_parallax_fullwidth_{$i}"] ? "background-size:cover;" : '';
                                $bg['multi'] .= "<div data-depth='" . $a["bg_multi_parallax_depth_{$i}"] . "' class='layer bwpb-multilayer-layer' style='background:transparent url(" . $a["bg_multi_parallax_image_{$i}"] . ") " . $a["bg_multi_parallax_position_{$i}"] . " no-repeat;{$bg_size}{$margins}'></div>";
                            }
                        }
                    }
                    $bg['multi'] .= '</div>';
                    break;
                case 'video':
                    $bg['video'] = "<div class='bwpb-video-wrap'>";
                    if( wp_is_mobile() ) {
                        $bg['video'] .= "<div class='bwpb-mobile-preview' style='background-image: url({$a['bg_video_preview']})'></div>";
                    }else{
                        $bg['video'] .= "<video class='bwpb-video-bg' width='1280' height='720' preload='auto' loop autoplay muted>";
                        if( ! empty( $a['bg_video_file_mp4'] ) ) { $bg['video'] .= "<source type='video/webm' src='{$a['bg_video_file_mp4']}'>"; }
                        if( ! empty( $a['bg_video_file_webm'] ) ) { $bg['video'] .= "<source type='video/mp4' src='{$a['bg_video_file_webm']}'>"; }
                        if( ! empty( $a['bg_video_file_ogv'] ) ) { $bg['video'] .= "<source type='video/ogg' src='{$a['bg_video_file_ogv']}'>"; }
                        $bg['video'] .="</video>";
                    }
                    $bg['video'] .="</div>";
                    $bg['overlay'] = $a['bg_video_overlay'] ? "<div class='bwpb-overlay' style='background-color:{$a['bg_video_overlay']}'></div>" : '';
                    break;
            }
        }
        return $bg;
    }
	
}