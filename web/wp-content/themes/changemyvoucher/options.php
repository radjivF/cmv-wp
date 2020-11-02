<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
    $themename = get_option( 'stylesheet' );
    $themename = preg_replace("/\W/", "_", strtolower($themename) );
    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $themename;
    update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'ticketparis'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	$options = array();

    /* General */

    $options[] = array(
        'name' => __('General', 'cmv'),
        'type' => 'heading');

	/*
	$options[] = array(
        'id'   => 'header_title',
        'type' => 'text',
        'name' => __( 'Header Title', 'cmv' ),
	);
	*/

	$options[] = array(
        'id'   => 'product_info',
        'type' => 'editor',
        'name' => __( 'Product Info', 'cmv' ),
        'settings' => array(
	        'textarea_rows' => 8
        ),
	);

	return $options;
}
