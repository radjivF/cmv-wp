<?php

class Bwpb_shortcode_definition {
    
	static function init() {
        add_action( 'init', array( 'Bwpb_shortcode_definition', 'loop_and_define' ) );
	}
    
    static function loop_and_define() {
        foreach( Bwpb_map::$shortcodes as $shortcode ) {
            //d($shortcode);
            $file = "{$shortcode['base']}.php";
            if( file_exists( PBTH_VIEW . $file ) or file_exists( PBTH_ROOT . 'bwpb' . PB_DS . 'view' . PB_DS . $file ) or file_exists( PB_CONF . 'view' . PB_DS . $file ) ) {
                self::the_shortcode( $shortcode['base'], array( 'Bwpb_shortcode_definition', 'render' ) );
            }
        }
    }
    
    static function the_shortcode( $tag, $func ) {
        add_shortcode( $tag, $func );
    }
    
    static function render( $atts, $content = null, $base = '' ) {
        return Bwpb_shortcode_definition::bwpb_require_view( $atts, $content, $base );
    }
    
    static function bwpb_require_view( $atts, $content, $base ) {
        
        $bwpb_theme_bw_view_root = PBTH_VIEW . "{$base}.php";
        $bwpb_theme_view_root = PBTH_ROOT . 'bwpb' . PB_DS . 'view' . PB_DS . "{$base}.php";
        $bwpb_view_root = PB_CONF . 'view' . PB_DS . $base . '.php';
        
        if( file_exists( $bwpb_theme_bw_view_root ) ) {
            return include $bwpb_theme_bw_view_root;
        }elseif( file_exists( $bwpb_theme_view_root ) ) {
            return include $bwpb_theme_view_root;
        }else{
            return include $bwpb_view_root;
        }
    }
}