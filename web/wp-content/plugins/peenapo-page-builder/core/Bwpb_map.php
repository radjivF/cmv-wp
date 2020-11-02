<?php
class Bwpb_map {
    
    static $shortcode_arr = array();
    static $shortcodes = array();
    static $shortcodes_unmap = array();
    static $params = array();
    static $params_scripts = array();
    
    static function init() {
        
        add_action( 'after_setup_theme', array( 'Bwpb_map', 'map_init' ) );
        
    }
    
    static function map_init() {
        
        // don't load if page builder is not enabled.
        // TODO
        
        require_once( PB_ROOT . 'config/map.php');
        require_once( PB_ROOT . 'config/params.php');
        
        if( is_admin() ) {
            add_action( 'admin_footer', array( 'Bwpb_map', 'map_js_object_admin' ) );
        }else{
            add_action( 'wp_footer', array( 'Bwpb_map', 'front_params' ) );
        }
        
        do_action( 'bwpb_after_mapping' );
        
    }
    
    static function map( $shortcode ) {
        if( ! isset( $shortcode['base'] ) ) {
            die('Wrong mapping. Missing base.');
        }else{
            array_push( self::$shortcode_arr, $shortcode['base'] );
            self::$shortcodes[] = $shortcode;
        }
    }
    
    static function unmap( $shortcode ) {
        if( ( $key = array_search( $shortcode, self::$shortcode_arr ) ) !== false ) {
            unset( self::$shortcode_arr[$key] );
            unset( self::$shortcodes[$key] );
        }
    }
    
    static function add_param( $base, $param_data ) {
        if( ( $key = array_search( $base, self::$shortcode_arr ) ) !== false ) {
            if( isset( self::$shortcodes[$key] ) and isset( self::$shortcodes[$key]['params'] ) ) {
                $param_exists = false;
                foreach( self::$shortcodes[$key]['params'] as $k => $current_param ) {
                    if( $current_param['param_name'] == $param_data['param_name'] ) {
                        self::$shortcodes[$key]['params'][ $k ] = $param_data;
                        $param_exists = true;
                        break;
                    }
                }
                if( ! $param_exists ) {
                    array_push( self::$shortcodes[$key]['params'], $param_data );
                }
            }
        }
    }
    
    static function remove_param( $base, $param_name ) {
        if( ( $key = array_search( $base, self::$shortcode_arr ) ) !== false ) {
            if( isset( self::$shortcodes[$key] ) and isset( self::$shortcodes[$key]['params'] ) ) {
                foreach( self::$shortcodes[$key]['params'] as $k => $param ) {
                    if( is_array( $param_name ) ) {
                        if( in_array( $param['param_name'], $param_name ) ) {
                            unset(self::$shortcodes[$key]['params'][$k]);
                        }
                    }else{
                        if( $param['param_name'] == $param_name ) {
                            unset(self::$shortcodes[$key]['params'][$k]);
                        }
                    }
                    
                }
            }
        }
    }
    
    static function map_param( $param_name, $callback, $enqueue_script = false ) {
        
        if( function_exists( 'bwpb_param_' . $param_name ) ) {
            self::$params[$param_name] = array(
                'callback' => $callback
            );
            if( $enqueue_script ) {
                self::$params_scripts[] = $enqueue_script;
            }
        }
        
    }
    
    static function front_params() {
        $options['ismobile'] = wp_is_mobile();
        $options['front_end_load_js'] = Bwpb::$global['front_end_load_js'];
        wp_localize_script( 'bwpb-front', 'bwpb_params', $options );
    }
    
    static function map_js_object_admin() {
        
        $js_map = array();
        foreach( self::$shortcodes as $shortcode ) {
            $js_params = array();
            foreach( $shortcode['params'] as $param ) {
                $js_params[ $param[ 'param_name' ] ] = $param;
            }
            $js_map[ $shortcode['base'] ] = $shortcode;
            $js_map[ $shortcode['base'] ][ 'params' ] = $js_params;
        }
        
        wp_localize_script( 'bwpb-mapper', 'bwpb_data', array(
            
            'map' => json_encode( $js_map ),
            'status' => Bwpb::bw_check_status(),
            'post_id' => get_the_ID(),
            'enqueue_params_scripts' => json_encode( self::$params_scripts ),
            'col_sizes' => Bwpb::$global['col_sizes'],
            'ele_colors' => Bwpb::$global['ele_colors']
            
        ));
        
    }
    
}

if( ! function_exists('recursive_array_search') ) {
    function recursive_array_search($needle,$haystack) {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }
}