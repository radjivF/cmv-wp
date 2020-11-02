<?php
class Bwpb_license {
    
    static function build() {
        
        $theme_stylesheet_data = wp_get_theme();
        if( strtolower( $theme_stylesheet_data->get( 'Author' ) ) !== self::getAuth() ) {
            return;
        }
        return true;
    }
    
    static function getAuth() {
		$array = array(
			'p',
			'ee',
			'na',
			'p',
			'o',
		);

		return implode( '', $array );
	}
    
}