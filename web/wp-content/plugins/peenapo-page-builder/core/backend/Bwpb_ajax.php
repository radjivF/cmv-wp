<?php

class Bwpb_back_ajax {
	
	static $callbacks = array(
		'__parse_shortcode',
		'__panel_get_settings',
		'__param_icon',
	);
	
	static function init() {
		
		self::alocate_callbacks();
		
	}
	
	static function alocate_callbacks() {
		
		foreach(self::$callbacks as $callback) {
			
			add_action( 'wp_ajax_nopriv_' . $callback, array( 'Bwpb_back_ajax', $callback ) );
			add_action( 'wp_ajax_' . $callback, array( 'Bwpb_back_ajax', $callback ) );
			
		}
	}
	
    /*----------------------------------*/
    /* PARSE SHORTCODE
    /*----------------------------------*/
	static function __parse_shortcode() {
		
        if( ! isset( $_POST['editor_content'] ) ) { return; }
        $c = stripslashes( $_POST['editor_content'] );
        
        $output = array();
        $output = Bwpb_shortcode_parser::ps_the_shortcodes( $output, $c );
        
        die( json_encode( $output ) );
		
	}
	
    /*----------------------------------*/
    /* GET SETTINGS FOR PANEL
    /*----------------------------------*/
	static function __panel_get_settings() {
        
        function call_function( $param ) {
            
            // check if public
            if( ! ( isset( $param['public'] ) && $param['public'] == 'false' ) ) {
                
                $width = isset( $param['width'] ) ? $param['width'] : 100;
                $style_width = isset( $param['width'] ) ? "style='width:{$param['width']}%;'" : '';
                $depends = isset( $param['dependency'] ) ? "data-depends='{$param['dependency']['element']}'" : '';
                $param_name = isset( $param['param_name'] ) ? "data-name='{$param['param_name']}'" : '';
                
                if( $param['param_name'] !== 'class' ) {
                    
                    echo "<div class='panel-row panel-width-{$width}' {$param_name} data-type='{$param['type']}' {$style_width} {$depends}>";
                    
                    // check if callback function
                    if( isset( Bwpb_map::$params[ $param['type'] ]['callback'] ) ) {
                        
                        $func = Bwpb_map::$params[ $param['type'] ]['callback'];
                        
                        if( function_exists( $func ) ) {
                            
                            // call function
                            call_user_func_array( $func, array( $param ) );
                            
                            call_dependencies( $param );
                            
                        }
                    }
                    
                    echo '</div>';
                    
                }
            }
        }
        
        function call_dependencies( $param ) {
            
            if( isset( $param['dependency'] ) and is_array( $param['dependency'] ) ) {
                $d = $param['dependency'];
                if( isset( $d['element'] ) and ( isset( $d['value'] ) or isset( $d['not_empty'] ) ) ) {
                    
                    $function = $body = '';
                    
                    $body .= "var dType = $('#bwpb-panel *[name=\"" . esc_attr( $d['element'] ) . "\"]').closest('.panel-row').attr('data-type');
                    if( dType == 'radio' || dType == 'checkbox' || dType == 'true_false' || dType == 'radio_image' ) {
                        var mainElement = $('#bwpb-panel *[name=\"" . esc_attr( $d['element'] ) . "\"]:checked');
                    }else{
                        var mainElement = $('#bwpb-panel *[name=\"" . esc_attr( $d['element'] ) . "\"]');
                    }";
                    
                    $show = "Bwpb.elShow('[data-name=\"" . esc_attr( $param['param_name'] ) . "\"]');$('[data-depends=\"" . esc_attr( $param['param_name'] ) . "\"]').removeClass('bwpb-row-depends');";
                    $hide = "Bwpb.elHide('[data-name=\"" . esc_attr( $param['param_name'] ) . "\"]');$('[data-depends=\"" . esc_attr( $param['param_name'] ) . "\"]').addClass('bwpb-row-depends');";
                    
                    if( isset( $d['not_empty'] ) and $d['not_empty'] == true ) {
                        $function .= "{$body} var depVal = mainElement.val(); if( depVal != '' && depVal != '0' && depVal != 0 ) { {$show} }else{ {$hide} }";
                    }else{
                        if( is_array( $d['value'] ) ) {
                            $function .= "{$body} if( $.inArray( mainElement.val(), " . json_encode( $d['value'] ) . " ) !== -1 ) { {$show} }else{ {$hide} }";
                        }else{
                            // condition if empty checkbox
                            if( $d['value'] == '0' or $d['value'] == 'false' or $d['value'] == '' ) {
                                $function .= "{$body} console.log(111);if( typeof mainElement.val() == 'undefined' ) { {$show} }else{ {$hide} }";
                            }else{
                                $function .= "{$body} if( mainElement.val() == '{$d['value']}' ) { {$show} }else{ {$hide} }";
                            }
                        }
                    }
                    
                    echo "<script type='text/javascript'>
                        if( $('#bwpb-panel *[name=\"" . esc_attr( $d['element'] ) . "\"]').length > 0 ) {
                            {$function}
                            $('#bwpb-panel *[name=\"{$d['element']}\"]').on('change', function() { {$function} });
                        }
                    </script>";
                }
            }
        }
        
        $uid = $_POST['mapped_data']['uid'];
        $mapped = $_POST['mapped_data']['data'];
        
        $name = $mapped['name'];
        $base = $mapped['base'];
        $desc = isset( $mapped['description'] ) ? $mapped['description'] : '';
        
        if( ! isset( $mapped['params'] ) ) { return; }
        $params = $mapped['params'];
        
        $output = '';
        
        $tabs = array( __( 'General', PBTD ) );
        foreach( $params as $param ) {
            if( isset( $param['tab'] ) and ! in_array( $param['tab'], $tabs ) ) {
                $tabs[] = $param['tab'];
            }
        }
        
        $has_tabs = count( $tabs ) > 1;
        
        if( $has_tabs ) {
            echo '<div class="panel-tabs"><ul>';
            foreach( $tabs as $key => $tab ) {
                $active = $key === 0 ? 'active' : '';
                echo "<li data-tab='.bwpb-tab-{$key}' class='{$active}'>{$tab}</li>";
            }
            echo '</ul></div>';
        }
        
        if( $has_tabs ) {
            
            foreach( $tabs as $key => $tab ) {
                $active = $key === 0 ? 'tab-visible' : '';
                echo "<div class='bwpb-tab bwpb-tab-{$key} {$active}'>";
                foreach( $params as $param ) {
                    $param_tab = isset( $param['tab'] ) ? $param['tab'] : 'general';
                    
                    if( $param_tab === $tab or ( $tabs[0] === $tab and $param_tab === 'general' ) ) {
                        call_function( $param );
                    }
                }
                echo "</div>";
            }
            
        }else{
            
            foreach( $params as $param ) {
                call_function( $param );
            }
            
        }
        
        foreach( Bwpb_map::$params_scripts as $script ) {
            wp_enqueue_script( 'my-script', $script, array( 'jquery' ) );
        }
        
        exit;
        
    }
}