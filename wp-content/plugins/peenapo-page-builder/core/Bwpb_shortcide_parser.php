<?php

class Bwpb_shortcode_parser {
	
    static $uid = 0;
    
    static function get_uid() {
        return rand( 1111111, 9999999 ) . '-' . uniqid();
    }
    
    static function get_shortcode_regex() {
        return '\[(\[?)(' . implode( '|', Bwpb_map::$shortcode_arr ) . ')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
    }
    
    static function ps_get_pattern( $text ) {
        
        $pattern = self::get_shortcode_regex();
        preg_match_all( "/$pattern/s", $text, $c );
        
        return $c;
    }
    
    static function ps_parse_atts( $content ) {
        $content = preg_match_all( '/([^ ]*)=(\'([^\']*)\'|\"([^\"]*)\"|([^ ]*))/', trim( $content ), $c );
        list( $dummy, $keys, $values ) = array_values( $c );
        $c = array();
        foreach ( $keys as $key => $value ) {
            $value = trim( $values[ $key ], "\"'" );
            $type = is_numeric( $value ) ? 'float' : 'string';
            $type = in_array( strtolower( $value ), array( 'true', 'false' ) ) ? 'bool' : $type;
            switch ( $type ) {
                case 'float': $value = (float) $value; break;
                case 'bool': $value = strtolower( $value ) == 'true'; break;
            }
            $c[ $keys[ $key ] ] = $value;
        }
        return $c;
    }
    
    static function ps_the_shortcodes( &$output, $text, $child = false, $level = 0, $parent_id = 0 ) {
        $patts = self::ps_get_pattern( $text );
        $t = array_filter( self::ps_get_pattern( $text ) );
        if ( ! empty( $t ) ) {
            list( $d, $d, $parents, $params, $d, $contents ) = $patts;
            $n = 0;
            $level++;
            $parent_id = $level > 1 ? self::get_uid() : 0;
            
            foreach( $parents as $k => $parent ) {
                
                if($parent == 'bw_text') {
                    $content = ! empty( $t ) && ! empty( $t_s ) ? $t_s : $contents[ $k ];
                }
                
                $out2 = array();
                ++$n;
                $name = $child ? 'child' . $n : $n;
                $t = array_filter( self::ps_get_pattern( $contents[ $k ] ) );
                $t_s = self::ps_the_shortcodes( $out2, $contents[ $k ], true, $level, $parent_id );
                $output[ $name ] = array( 'base' => $parents[ $k ] );
                $output[ $name ]['params'] = self::ps_parse_atts( $params[ $k ] );
                
                $uid = ( self::$uid == 0 or self::$uid == $parent_id or ( empty( $t ) && empty( $t_s ) ) ) ? self::get_uid() : self::$uid;
                $output[ $name ]['uid'] = $uid;
                
                self::$uid = $parent_id;
                
                $output[ $name ]['parent_id'] = $parent_id;
                $output[ $name ]['level'] = $level;
                
                if( empty( $t ) && empty( $t_s ) ) {
                    $output[ $name ]['is_content'] = true;
                    $output[ $name ]['children'] = $contents[ $k ];
                }else{
                    $output[ $name ]['children'] = $t_s;
                }
            }
        }
        return array_values( $output );
    }
    
}