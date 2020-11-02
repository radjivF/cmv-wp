<?php

/*--------------------------------------------*/
/* Peenapo Page Builder - Map default params
/*--------------------------------------------*/

/*----------------------------------*/
/* textfield
/*----------------------------------*/
function bwpb_param_textfield( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'placeholder' => '',
        'value' => '',
    ), $param );
    
	$placeholder = ! empty( $p['placeholder'] ) ? 'placeholder="' . esc_html( $p['placeholder'] ) . '"' : '';
    echo Bwpb_back::get_param_header( $param ) . 
        '<input type="text" name="' . esc_attr( $p['param_name'] ) . '" value="' . Bwpb::quote_decode( $p['value'] ) . '" ' . $placeholder . ' />';
}

Bwpb_map::map_param( 'textfield', 'bwpb_param_textfield' );



/*----------------------------------*/
/* heading
/*----------------------------------*/
function bwpb_param_heading( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param );
}

Bwpb_map::map_param( 'heading', 'bwpb_param_heading' );



/*----------------------------------*/
/* textarea
/*----------------------------------*/
function bwpb_param_textarea( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
        'rows' => 6,
    ), $param );
    
    echo Bwpb_back::get_param_header( $param ) . 
        "<textarea name='{$p['param_name']}' rows='{$p['rows']}'>{$p['value']}</textarea>";
}

Bwpb_map::map_param( 'textarea', 'bwpb_param_textarea' );



/*----------------------------------*/
/* base64 encode
/*----------------------------------*/
function bwpb_param_base64( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
        'rows' => 6,
    ), $param );
    
    echo Bwpb_back::get_param_header( $param )
        ."<input name='{$p['param_name']}' value='{$p['value']}' />"
        ."<textarea rows='{$p['rows']}'>" . str_replace( '_', '=', base64_decode( $p['value'] ) ) . "</textarea>";
}

Bwpb_map::map_param( 'base64', 'bwpb_param_base64' );



/*----------------------------------*/
/* editor tinymce
/*----------------------------------*/
function bwpb_param_editor( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    $content = Bwpb::autop( $p['value'] );
    $content = Bwpb::quote_decode_raw( $content );
    
    $editor_id  = "bwpb_tinymce_{$p['param_name']}";
    
    $buttons = '<button type="button" data-switch="tmce" class="wp-switch-editor switch-tmce" onclick="Bwpb.switchEditor(this);">' . __('Visual') . "</button>\n";
    $buttons .= '<button type="button" data-switch="html" class="wp-switch-editor switch-html" onclick="Bwpb.switchEditor(this);">' . _x( 'Text', 'Name for the Text editor tab (formerly HTML)' ) . "</button>\n";
    
    echo Bwpb_back::get_param_header( $param ) . 
    "<div class='bwpb-tinymce-container tmce-active' data-editor-id='{$editor_id}'>";
    
    // buttons
    echo "<div id='wp-{$editor_id}-editor-tools' class='wp-editor-tools hide-if-no-js'>";

    // media button
    if ( current_user_can( 'upload_files' ) ) {
        if ( ! function_exists('media_buttons') ) {
            include(ABSPATH . 'wp-admin/includes/media.php');
        }
        echo "<div id='wp-{$editor_id}-media-buttons' class='wp-media-buttons'>" . do_action( 'media_buttons', $editor_id ) . "</div>";
    }
    echo "<div class='wp-editor-tabs'>{$buttons}</div>
        </div>
        <textarea id='{$editor_id}' class='bwpb-tinymce-textarea' name= '{$p['param_name']}'>" . preg_replace( "/\r|\n/", "", wpautop( $content, true ) ) . "</textarea>
        <script type='text/javascript'>
            // tinymce
            if(window.tinyMCEPreInit && window.tinyMCEPreInit.mceInit[wpActiveEditor]) {
                window.tinyMCEPreInit.mceInit['{$editor_id}'] = _.extend({}, window.tinyMCEPreInit.mceInit[wpActiveEditor], {
                    id: '{$editor_id}',
                    setup: function (ed) {
                       if (typeof(ed.on) != 'undefined') {
                            ed.on('init', function (ed) {
                                ed.target.focus();
                                wpActiveEditor = '{$editor_id}';
                            });
                        } else {
                            ed.onInit.add(function (ed) {
                                ed.focus();
                                wpActiveEditor = '{$editor_id}';
                            });
                        }
                    },
                });
                window.tinyMCEPreInit.mceInit['{$editor_id}'].plugins = window.tinyMCEPreInit.mceInit['{$editor_id}'].plugins.replace(/,?wpfullscreen/, '').replace(/,?fullscreen/, '');
                window.tinyMCEPreInit.mceInit['{$editor_id}'].toolbar1 = window.tinyMCEPreInit.mceInit['{$editor_id}'].toolbar1.replace(/,?dfw/, '');
                window.tinyMCEPreInit.mceInit['{$editor_id}'].wp_autoresize_on = false;

            }
            
            /*
            var tinyOptions = _.extend({}, window.tinyMCEPreInit.mceInit[wpActiveEditor], {
                id          : '{$editor_id}',
                height      : '300',
                resize      : 'vertical'
            });
            
            tinyOptions.plugins = tinyOptions.plugins.replace(/,?wpfullscreen/, '').replace(/,?fullscreen/, '');
            tinyOptions.toolbar1 = tinyOptions.toolbar1.replace(/,?dfw/, '');
            tinyOptions.wp_autoresize_on = false;
            
            console.log( tinyOptions );
            tinyMCE.init( tinyOptions );
            */
            
            if(window.tinymce) {
                tinymce.execCommand( 'mceAddEditor', true, '{$editor_id}' );
            }
            
            // quicktags
            window.tinyMCEPreInit.qtInit['{$editor_id}'] = _.extend({}, window.tinyMCEPreInit.qtInit[wpActiveEditor], {id: '{$editor_id}'});
            qt = quicktags( window.tinyMCEPreInit.qtInit['{$editor_id}'] );
            QTags._buttonsInit();
            
        </script>
        
    </div>";
    
}

Bwpb_map::map_param( 'editor', 'bwpb_param_editor', PB_ASSEST );



/*----------------------------------*/
/* image
/*----------------------------------*/
function bwpb_param_image( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    $has_thumbnail = false;
    $thumbnail = $placeholder = PB_ASSEST . 'img/thumbnail-placeholder.png';
    if( ! empty( $p['value'] ) ) {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", esc_url( $p['value'] ) ));
        if( isset( $attachment[0] ) ) {
            $image_data = wp_get_attachment_image_src( $attachment[0], 'thumbnail' );
            if( isset( $image_data[0] ) ) {
                $has_thumbnail = true;
                $thumbnail = $image_data[0];
            }
        }
    }
    
    $thumbnail_src = ! empty( $p['value'] ) ? "<img src='{$p['value']}' alt=''>" : "<img src='{$thumbnail}' alt=''>";
    $upload_thumbnail_class = $has_thumbnail ? 'has-image' : '';
    
    echo Bwpb_back::get_param_header( $param ) . 
        "<div class='input-upload-image'>
            <div class='upload-thumbnail {$upload_thumbnail_class}'>
                <img src='{$thumbnail}' alt='' data-placeholder='{$placeholder}'>
                <span class='after-remove'></span>
            </div>
            <input type='text' name='{$p['param_name']}' value='{$p['value']}' />
        </div>";
}

Bwpb_map::map_param( 'image', 'bwpb_param_image', PB_ASSEST . 'js/params/image.js' );



/*----------------------------------*/
/* attach_file
/*----------------------------------*/
function bwpb_param_attach_file( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param ) . 
        "<div class='input-upload-file'>
            <input type='text' name='{$p['param_name']}' value='{$p['value']}' />
            <div class='upload-button'>
                <span type='button' class='select-file-image bwpb-button bwpb-btnsmall'>Select file</span>
            </div>
        </div>";
}

Bwpb_map::map_param( 'attach_file', 'bwpb_param_attach_file', PB_ASSEST . 'js/params/file.js' );



/*----------------------------------*/
/* colorpicker
/*----------------------------------*/
function bwpb_param_colorpicker( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param ) . 
        "<input type='text' name='{$p['param_name']}' value='{$p['value']}' class='bwpb-colorpicker cs-wp-color-picker' data-default-color='transparent' />";
}

Bwpb_map::map_param( 'colorpicker', 'bwpb_param_colorpicker', PB_ASSEST . 'js/params/colorpicker.js' );



/*----------------------------------*/
/* true_false
/*----------------------------------*/
function bwpb_param_true_false( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    $checked = $p['value'] == true ? 'checked="checked"' : '';
    $active = $p['value'] == true ? 'active' : '';
    
    echo Bwpb_back::get_param_header( $param ) . 
        "<label class='bwpb-true-false {$active}' for='bwpb_true_false_{$p['param_name']}'>
            <input type='checkbox' name='{$p['param_name']}' id='bwpb_true_false_{$p['param_name']}' value='1' {$checked} class='bwpb-true-false' />
        </label>";
}

Bwpb_map::map_param( 'true_false', 'bwpb_param_true_false', PB_ASSEST . 'js/params/true-false.js' );



/*----------------------------------*/
/* checkbox
/*----------------------------------*/
function bwpb_param_checkbox( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'type' => '',
        'fields' => array(),
        'value' => '',
    ), $param );
    
    $p['value'] = is_array( $p['value'] ) ? $p['value'] : array_filter( explode( ',', $p['value'] ) );
    
    echo Bwpb_back::get_param_header( $param );
    echo "<div class='bwpb-multi-fields' data-type='{$p['type']}'>";
    
    $c = 0;
    
    foreach( $p['fields'] as $field_value => $field_label ) {
        
        $c++;
        $checked = '';
        
        if( is_array( $p['value'] ) ) {
            foreach( $p['value'] as $v ) {
                if( $v == $field_value ) {
                    $checked = 'checked="checked"';
                    break;
                }
            }
        }else{
            if( $p['value'] == $field_value ) {
                $checked = 'checked="checked"';
            }
        }
        
        echo "<div class='bwpb-checkbox-row'>
            <label for='bw_checkbox_{$p['param_name']}-{$c}'>
                <input type='checkbox' name='{$p['param_name']}' id='bw_checkbox_{$p['param_name']}-{$c}' value='{$field_value}' {$checked} />
                {$field_label}
            </label>
        </div>";
    }
    echo '</div>';
}

Bwpb_map::map_param( 'checkbox', 'bwpb_param_checkbox' );



/*----------------------------------*/
/* radio
/*----------------------------------*/
function bwpb_param_radio( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'type' => '',
        'fields' => array(),
        'value' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param );
    echo "<div class='bwpb-multi-fields' data-type='{$p['type']}'>";
    
    $c = 0;
    
    foreach( $p['fields'] as $field_value => $field_label ) {
        
        $c++;
        $checked = '';
        
        if( $p['value'] == $field_value ) {
            $checked = 'checked="checked"';
        }
        
        echo "<div class='bwpb-radio-row'>
            <label for='bw_radio_{$p['param_name']}-{$c}'>
                <input type='radio' name='{$p['param_name']}' id='bw_radio_{$p['param_name']}-{$c}' value='{$field_value}' {$checked} />
                {$field_label}
            </label>
        </div>";
    }
    echo '</div>';
}

Bwpb_map::map_param( 'radio', 'bwpb_param_radio' );



/*----------------------------------*/
/* radio_image
/*----------------------------------*/
function bwpb_param_radio_image( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'type' => '',
        'fields' => array(),
        'value' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param );
    echo "<div class='bwpb-multi-fields' data-type='{$p['type']}'>";
    
    $c = 0;
    
    foreach( $p['fields'] as $field ) {
        
        $c++;
        $checked = '';
        
        if( $p['value'] === $field['value'] ) {
            $checked = 'checked';
        }
        
        echo "<label class='bwpb-radio-image-row {$checked}' for='bw_radio_{$p['param_name']}-{$c}'>
            <div class='bwpb-radio-img-holder'>
                <input type='radio' name='{$p['param_name']}' id='bw_radio_{$p['param_name']}-{$c}' value='{$field['value']}' {$checked} />
                <img src='{$field['image']}' alt=''>
            </div>
            <span>{$field['label']}</span>
        </label>";
    }
    echo '</div>';
}

Bwpb_map::map_param( 'radio_image', 'bwpb_param_radio_image', PB_ASSEST . 'js/params/radio-image.js' );



/*----------------------------------*/
/* select
/*----------------------------------*/
function bwpb_param_select( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'fields' => array(),
        'value' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param ) . 
    "<select name='{$p['param_name']}'>";
        foreach( $p['fields'] as $select_value => $select_name ) {
            $selected = $p['value'] == $select_value ? 'selected="selected"' : '';
            echo "<option value='{$select_value}' {$selected}>{$select_name}</option>";
        }
    echo "</select>";
}

Bwpb_map::map_param( 'select', 'bwpb_param_select' );



/*----------------------------------*/
/* select2
/*----------------------------------*/
function bwpb_param_select2( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'fields' => array(),
        'value' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param ) . 
    "<select name='{$p['param_name']}'>";
        foreach( $p['fields'] as $select_value => $select_name ) {
            $selected = $p['value'] == $select_value ? 'selected="selected"' : '';
            echo "<option value='{$select_value}' {$selected}>{$select_name}</option>";
        }
    echo "</select>";
}

Bwpb_map::map_param( 'select2', 'bwpb_param_select2', PB_ASSEST . 'js/params/select2.js' );



/*----------------------------------*/
/* post
/*----------------------------------*/
function bwpb_param_post( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'post_type' => 'post',
        'value' => '',
        'allow_empty' => true,
        'multiple' => false,
    ), $param );
    
    $multiple = $p['multiple'] == 'true' ? 'multiple' : '';
    $p['value'] = is_array( $p['value'] ) ? $p['value'] : array_filter( explode( ',', $p['value'] ) );
    
    $query = new WP_Query( array(
        'post_type' => $p['post_type'],
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
        'posts_per_page' => 999,
        'offset' => 0,
    ));
    
    echo Bwpb_back::get_param_header( $param );
    
    if( $p['multiple'] ) { echo "<div class='bwpb-multi-fields'>"; }
    echo "<select name='{$p['param_name']}' {$multiple}>";
    if( $p['allow_empty'] !== 'false' and $p['multiple'] !== 'true' ) { echo "<option value=''>Select post type</option>"; }
    
    while ( $query->have_posts() ) { $query->the_post();
        $select_value = get_the_ID();
        $label = get_the_title();
        $selected = '';
        if( is_array( $p['value'] ) ) {
            foreach( $p['value'] as $v ) {
                if( $v == $select_value ) {
                    $selected = 'selected="selected"';
                    break;
                }
            }
        }else{
            if( $p['value'] == $select_value ) {
                $selected = 'selected="selected"';
            }
        }
        echo "<option value='{$select_value}' {$selected}>{$label}</option>";
    }
    
    wp_reset_postdata();
    
    echo "</select>";
    if( $p['multiple'] ) { echo "</div>"; }
    
}


Bwpb_map::map_param( 'post', 'bwpb_param_post' );



/*----------------------------------*/
/* post_types
/*----------------------------------*/
function bwpb_param_post_types( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'fields' => array(),
        'value' => '',
        'allow_empty' => true,
        'multiple' => false,
    ), $param );
    
    $post_types = get_post_types( array( 'public' => true ) );
    if( isset( $post_types['attachment'] ) ) { unset( $post_types['attachment'] ); }
    if( isset( $post_types['page'] ) ) { unset( $post_types['page'] ); }
    $multiple = $p['multiple'] == 'true' ? 'multiple' : '';
    $p['value'] = is_array( $p['value'] ) ? $p['value'] : array_filter( explode( ',', $p['value'] ) );
    
    echo Bwpb_back::get_param_header( $param );
    
    if( $p['multiple'] ) { echo "<div class='bwpb-multi-fields'>"; }
    echo "<select name='{$p['param_name']}' {$multiple}>";
    if( $p['allow_empty'] !== 'false' and $p['multiple'] !== 'true' ) { echo "<option value=''>Select post type</option>"; }
    foreach( $post_types as $select_value => $select_name ) {
        $selected = '';
        if( is_array( $p['value'] ) ) {
            foreach( $p['value'] as $v ) {
                if( $v == $select_value ) {
                    $selected = 'selected="selected"';
                    break;
                }
            }
        }else{
            if( $p['value'] == $select_value ) {
                $selected = 'selected="selected"';
            }
        }
        $label = ucfirst( strtolower( $select_name ) );
        echo "<option value='{$select_value}' {$selected}>{$label}</option>";
    }
    echo "</select>";
    if( $p['multiple'] ) { echo "</div>"; }
}


Bwpb_map::map_param( 'post_types', 'bwpb_param_post_types' );



/*----------------------------------*/
/* taxonomies
/*----------------------------------*/
function bwpb_param_taxonomies( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'tx_type' => 'post',
        'fields' => array(),
        'value' => '',
        'allow_empty' => true,
        'multiple' => false,
    ), $param );
    
    $post_types = get_terms( $p['tx_type'], array( 'hide_empty' => false ) );
    $multiple = $p['multiple'] == 'true' ? 'multiple' : '';
    $p['value'] = is_array( $p['value'] ) ? $p['value'] : array_filter( explode( ',', $p['value'] ) );
    
    echo Bwpb_back::get_param_header( $param );
    
    if( $p['multiple'] ) { echo "<div class='bwpb-multi-fields'>"; }
    echo "<select name='{$p['param_name']}' {$multiple}>";
    if( $p['allow_empty'] !== 'false' and $p['multiple'] !== 'true' ) { echo "<option value=''>Select post type</option>"; }
    foreach( $post_types as $key => $obj ) {
        $selected = '';
        if( is_array( $p['value'] ) ) {
            foreach( $p['value'] as $v ) {
                if( $v == $obj->term_id ) {
                    $selected = 'selected="selected"';
                    break;
                }
            }
        }else{
            if( $p['value'] == $obj->term_id ) {
                $selected = 'selected="selected"';
            }
        }
        $label = $obj->name;
        echo "<option value='{$obj->term_id}' {$selected}>{$label}</option>";
    }
    echo "</select>";
    if( $p['multiple'] ) { echo "</div>"; }
}


Bwpb_map::map_param( 'taxonomies', 'bwpb_param_taxonomies' );



/*----------------------------------*/
/* post_formats
/*----------------------------------*/
function bwpb_param_post_formats( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'fields' => array(),
        'value' => '',
        'allow_empty' => true,
        'multiple' => false,
        'push_standard' => true,
    ), $param );
    
    $post_formats = get_theme_support( 'post-formats' );
    $post_formats = is_array( $post_formats[0] ) ? $post_formats[0] : array();
    
    $multiple = $p['multiple'] == 'true' ? 'multiple' : '';
    $p['value'] = is_array( $p['value'] ) ? $p['value'] : array_filter( explode( ',', $p['value'] ) );
    
    echo Bwpb_back::get_param_header( $param );
    
    if( $p['multiple'] ) { echo "<div class='bwpb-multi-fields'>"; }
    echo "<select name='{$p['param_name']}' {$multiple}>";
    if( $p['allow_empty'] !== 'false' and $p['multiple'] !== 'true' ) { echo "<option value=''>Select post type</option>"; }
    // add "standard" post format manually, as it is not an option.
    if( $p['push_standard'] == 'true' ) { echo "<option value='standard'>Standard</option>"; }
    foreach( $post_formats as $post_format ) {
        $selected = '';
        if( is_array( $p['value'] ) ) {
            foreach( $p['value'] as $v ) {
                if( $v == $post_format ) {
                    $selected = 'selected="selected"';
                    break;
                }
            }
        }else{
            if( $p['value'] == $post_format ) {
                $selected = 'selected="selected"';
            }
        }
        $label = ucfirst( strtolower( $post_format ) );
        echo "<option value='{$post_format}' {$selected}>{$label}</option>";
    }
    echo "</select>";
    if( $p['multiple'] ) { echo "</div>"; }
}


Bwpb_map::map_param( 'post_formats', 'bwpb_param_post_formats' );



/*----------------------------------*/
/* sidebars
/*----------------------------------*/
function bwpb_param_sidebars( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    global $wp_registered_sidebars;
    $sidebars = $wp_registered_sidebars;
    //d($wp_registered_sidebars);
    echo Bwpb_back::get_param_header( $param ) . 
    "<select name='{$p['param_name']}'>";
        foreach( $sidebars as $key => $sidebar ) {
            $selected = $p['value'] == $sidebar['id'] ? 'selected="selected"' : '';
            echo "<option value='{$sidebar['id']}' {$selected}>{$sidebar['name']}</option>";
        }
    echo "</select>";
}


Bwpb_map::map_param( 'sidebars', 'bwpb_param_sidebars' );



/*----------------------------------*/
/* number_slider
/*----------------------------------*/
function bwpb_param_number_slider( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'min' => 0,
        'max' => 100,
        'step' => 1,
        'value' => 0,
        'append_before' => '',
        'append_after' => '',
    ), $param );
    
    $p['value'] = (float)$p['value'];
    
    echo Bwpb_back::get_param_header( $param ) . "
        <span class='bwpb-ns-counter'>{$p['append_before']} <i>{$p['value']}</i> {$p['append_after']}</span>
        <div class='bwpb-number-slider' data-min='{$p['min']}' data-max='{$p['max']}' data-step='{$p['step']}' data-value='{$p['value']}'>
            <input type='hidden' name='{$p['param_name']}' value='{$p['value']}' />
        </div>";
}

Bwpb_map::map_param( 'number_slider', 'bwpb_param_number_slider', PB_ASSEST . 'js/params/number-slider.js' );



/*----------------------------------*/
/* icon
/*----------------------------------*/
function bwpb_param_icon( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    $value = explode(',', $p['value']);
    
    $font = $icon = $font_options = '';
    
    if( isset( $value[0] ) && isset( $value[1] ) ) {
        $font = $value[0];
        $icon = $value[1];
    }
    
    $fonts = array(
        'font-awesome' => 'Font Awesome',
        'lineicons' => 'Lineicons',
        '7s' => 'Pe icon 7 Stroke'
    );
    
    foreach( $fonts as $fk => $fn ) {
        $fs = $fk == $font ? 'selected="selected"' : '';
        $font_options .= "<option value='{$fk}' {$fs}>{$fn}</option>";
    }
    
    echo Bwpb_back::get_param_header( $param );
    echo "<div class='bwpb-icon-select'>
    <p>" . __( 'Select icon library.', PBTD ) . "</p>
    <select>{$font_options}</select>
    <p class='bwpb-icon-libinfo'>" . __( 'Click the plus to expand the icon library.', PBTD ) . "</p>
    <input type='text' name='{$p['param_name']}' value='{$p['value']}'>
    <div class='bwpb-icon-buttons'>
        <div class='bwpb-icon-label'><i class='{$icon}'></i></div>
        <div class='bwpb-icon-expand'><i class='fa fa-plus'></i></div>
        <div class='bwpb-icon-search'><input type='text' placeholder='Search for icon..' /></div>
    </div>
    <ul class='bwpb-icon-container' data-font='{$font}' data-icon='{$icon}'></ul>
    </div>";
}

Bwpb_map::map_param( 'icon', 'bwpb_param_icon', PB_ASSEST . 'js/params/icon.js' );



/*----------------------------------*/
/* css
/*----------------------------------*
function bwpb_param_css( $param ) {
    
    $p = shortcode_atts( array(
        'heading' => '',
        'description' => '',
        'param_name' => '',
        'value' => '',
    ), $param );
    
    echo Bwpb_back::get_param_header( $param ) . "
        <div class='bwpb-css-editor' id='bwpb_css_editor_{$p['param_name']}' data-name='{$p['param_name']}'>{$p['value']}</div>
        <textarea name='{$p['param_name']}'>{$p['value']}</textarea>";
}

Bwpb_map::map_param( 'css', 'bwpb_param_css', PB_ASSEST . 'js/params/editor-css.js' );*/
