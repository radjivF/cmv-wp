<?php

class Bw_theme_style {
    
    // option [ default_value ]
    static $options = array(
        'main_color' => '',
    );
    
    static function init() {
        
        self::$options['main_color'] = Bw_theme::$theme_main_color;
        
        $variables = self::collect();
        self::style($variables);
    }
    
    static function collect() {
        foreach(self::$options as $option => $default) {
            $variables[$option] = Bw::get_option($option, $default);
        }
        return $variables;
    }
    
    static function style($ot) {
        
        $style = '';
        
        $theme_styles = Bw_theme::$theme_styles;
        
        if( !empty( $ot['main_color'] ) ) {
            $style .= "/*color*/{$theme_styles['color']}{color:{$ot['main_color']}}".
            "/*background color*/{$theme_styles['background']}{background-color:{$ot['main_color']}}".
            "/*border color*/{$theme_styles['border']}{border-color:{$ot['main_color']}}";
        }
        
        printf("<style>%s</style>", $style);
    }
    
}