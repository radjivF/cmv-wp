<?php
include 'version.php';

add_action( 'wp_enqueue_scripts', 'cmv_enqueue_scripts' );

function cmv_enqueue_scripts() {
	$base   = get_bloginfo( 'stylesheet_directory' );
	$parent = get_template_directory_uri();

	wp_register_style(  'style', $parent . '/style.css', array(), CMV_VERSION );
	wp_register_style(  'cmv',   $base . '/css/theme.min.css', array( 'bw-woo-layout', 'bw-woo-smallscreen', 'bw-woo-general', 'style', 'bw-reset', 'bw-style', 'bw-media', 'bw-google-fonts', 'bw-add-google-fonts' ), CMV_VERSION );
	//wp_register_script( 'cmv',   $base . '/js/theme.js', array( 'bw-main' ), CMV_VERSION, true );

	wp_enqueue_style( 'cmv' );
	//wp_enqueue_script( 'cmv' );
}

add_filter( 'woocommerce_sale_flash', 'cmv_woocommerce_sales_flash' );

function cmv_woocommerce_sales_flash() {
	return false;
}

add_filter( 'optionsframework_menu', 'cmv_optionsframework_menu' );

function cmv_optionsframework_menu( $options ) {
	$options['page_title'] = __( 'Theme Content', 'cmv');
	$options['menu_title'] = __( 'Theme Content', 'cmv');
	return $options;
}

function cmv_get_option($name, $default = false) {
	$optionsframework_settings = get_option('optionsframework');
	$option_name = $optionsframework_settings['id'];
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}


function cmv_get_percentage_save() {
	global $product;
	if ( $product->product_type != 'simple' ) return;
	$regular_price = $product->regular_price;
	$sales_price   = $product->sale_price;
	$percentage    = number_format( ( ( $regular_price - $sales_price ) / $regular_price ) * 100, 1 );
	return $percentage . '%';
}

function cmv_get_price_regular() {
	global $product;
	$regular_price = wc_price( $product->regular_price );
	$regular_price = str_replace( ',00', '', $regular_price );
	return $regular_price;
}