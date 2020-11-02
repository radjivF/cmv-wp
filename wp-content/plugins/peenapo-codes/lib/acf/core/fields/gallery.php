<?php

class acf_field_gallery extends acf_field
{
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'gallery';
		$this->label = __("Gallery",'acf');
		$this->category = __("Content",'acf');
		$this->defaults = array(
			'layout'			=>	'vertical',
			'choices'			=>	array(),
			'default_value'		=>	'',
			'other_choice'		=>	0,
			'save_other_choice'	=>	0,
		);
		
		
		// do not delete!
    	parent::__construct();
  
	}
	
		
	/*
	*  create_fiele)
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field ) {
		
		// vars
		$i = 0;
		
		$e = '<ul class="acf-radio-list ' . esc_attr($field['class']) . ' ' . esc_attr($field['layout']) . '">';
		
		// add choices
		
		if( is_array($field['choices']) )
		{
			foreach( $field['choices'] as $key => $value )
			{
				// vars
				$i++;
				$atts = '';
				
				
				// if there is no value and this is the first of the choices, select this on by default
				if( $field['value'] === false )
				{
					if( $i === 1 )
					{
						$atts = 'checked="checked" data-checked="checked"';
					}
				}
				else
				{
					if( strval($key) === strval($field['value']) )
					{
						$atts = 'checked="checked" data-checked="checked"';
					}
				}
				
				// HTML
				$e .= '
				<li class="acf-radio-image ' . (empty($value['img']) ? 'default' : '') . '" title="' . $value['label'] . '">
					<label>
						<img src="' . BW_URI_FRAME_ASSETS . 'img/admin/' . $value['img'] . '" alt="">
						<input id="' . esc_attr($field['id']) . '-' . esc_attr($key) . '" type="radio" name="' . esc_attr($field['name']) . '" value="' . esc_attr($key) . '" ' . esc_attr( $atts ) . ' />
						<p>' . $value['label'] . '</p></label>
				</li>';
			}
		}
		
		
		// other choice
		if( $field['other_choice'] )
		{
			// vars
			$atts = '';
			$atts2 = 'name="" value="" style="display:none"';
			
			
			if( $field['value'] !== false )
			{
				if( !isset($field['choices'][ $field['value'] ]) )
				{
					$atts = 'checked="checked" data-checked="checked"';
					$atts2 = 'name="' . esc_attr($field['name']) . '" value="' . esc_attr($field['value']) . '"' ;
				}
			}
			
			
			$e .= '<li><label>
			
			
			<input id="' . esc_attr($field['id']) . '-other" 
			type="radio" 
			name="' . esc_attr($field['name']) . '" 
			value="other" ' . $atts . ' />' . __("Other", 'acf') . '</label> <input type="text" ' . $atts2 . ' /></li>';
		}


		$e .= '</ul>';
		
		//echo $e;
		
		
		/* bw gallery */
		echo '<div class="format-setting">';
		echo '<div id="bw-gallery">'.
			 '<ul></ul>'.
			 '<a id="bw-gallery-add" href="#" >'.
				'<input type="hidden" 
					name="' . esc_attr( $field['name'] ) . '" 
					id="' . esc_attr( $field['id'] ) . '" 
					value="' . esc_attr( $field['value'] ) . '" 
					class="' . esc_attr( $field['class'] ) . '" />'.
				'<i class="fa fa-camera-retro"></i>'.
			 '</a>'.
			 '</div>';
		echo '</div>';
		
		
		
	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field ) {
		// ...
	}
	
	
	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/
	
	function update_value( $value, $post_id, $field )
	{
		// validate
		if( $field['save_other_choice'] )
		{
			// value isn't in choices yet
			if( !isset($field['choices'][ $value ]) )
			{
				// update $field
				$field['choices'][ $value ] = $value;
				
				
				// can save
				if( isset($field['field_group']) )
				{
					do_action('acf/update_field', $field, $field['field_group']);
				}
				
			}
		}		
		
		return $value;
	}
	
}

new acf_field_gallery();

?>