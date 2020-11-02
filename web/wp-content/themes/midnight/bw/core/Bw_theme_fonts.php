<?php

class Bw_theme_fonts {

    static $fonts = array();
    static $add_fonts = array();

    static function init() {
        
        add_action( 'wp_enqueue_scripts', array( 'Bw_theme_fonts', 'font_hook' ) );
    }

    static function font_hook() {

        self::generate_fonts();
        self::enqueue_fonts();
    }

    static function add_font( $fonts ) {
        foreach($fonts as $font) {
            $enqueue = '';
            if( isset( $font['font'] ) ) {
                
                $enqueue .= str_replace( " ", "+", $font['font'] );
                $enqueue .= isset( $font['weight'] ) ? ':' . $font['weight'] : '';
                $enqueue .= isset( $font['attr'] ) ? $font['attr'] : '';
            }
            self::$add_fonts[] = $enqueue;
        }
    }

    static function enqueue_fonts() {
        $font_string = join( '|', self::$add_fonts );
        $protocol = is_ssl() ? 'https' : 'http';
        if( !empty( $font_string ) ) {
            wp_enqueue_style( 'bw-add-google-fonts', "{$protocol}://fonts.googleapis.com/css?family={$font_string}" );
        }
    }

    static function generate_fonts() {

        if( is_array( self::$fonts ) ) {

            $protocol = is_ssl() ? 'https' : 'http';
            $generate_font_req = '';
            $generate_font_css = '';

            foreach( self::$fonts as $name => $font ) {

                $custom = false;

                # check for ot default google fonts
                $ot_font = Bw::get_option( $name . '_font' );
                if( !empty( $ot_font ) ) {
                    $font['font'] = $ot_font;
                }

                # check for ot declared fonts
                $ot_font_declaration = Bw::get_option( $name . '_font_declaration' );
                if( ! empty( $ot_font_declaration ) ) {
                    $font['font'] = $ot_font_declaration;
                    $custom = true;
                }

                if( $font['font'] ) {
                    $generate_weight = isset( $font['weight'] ) ? ':' . $font['weight'] : '';
                    $generate_font_req = str_replace( " ", "+", $font['font'] ) . ( ( empty( $ot_font ) ) ? $generate_weight : '' );
                    $rule = join( ',', $font['selectors'] );
                    $generate_font_css .= $custom ? "{$rule}{font:{$font['font']}}" : "{$rule}{font-family:'{$font['font']}'}";
                }
            }

            $output_css = join( '|', $generate_font_req );
            wp_enqueue_style( 'bw-google-fonts', "{$protocol}://fonts.googleapis.com/css?family={$output_css}" );
            Bw::add_css( $generate_font_css );
        }
    }

}
