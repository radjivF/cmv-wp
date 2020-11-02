<?php

if(function_exists("register_field_group")) {
    
    register_field_group(array(
		'id' => 'acf_page-layout',
		'title' => 'Page &#8211; Layout',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_5661828e4ad11',
				'label' => 'Page layout',
				'name' => 'page_layout',
				'_name' => 'page_layout',
				'type' => 'radio_image',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-page_layout',
				'class' => 'radio_image',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array(
					'sidebar' => 
					array(
						'label' => 'Sidebar',
						'img' => 'layout_page/portfolio-right.png',
					),
					'full' => 
					array(
						'label' => 'Fullwidth',
						'img' => 'layout_page/portfolio-no-sidebar.png',
					),
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'sidebar',
				'layout' => 'vertical',
				'field_group' => 4188,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				1 => 
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_post-layout',
		'title' => 'Post &#8211; Layout',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_56434e54ebf16',
				'label' => 'Post layout',
				'name' => 'post_layout',
				'_name' => 'post_layout',
				'type' => 'radio_image',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-post_layout',
				'class' => 'radio_image',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array(
					'sidebar' => 
					array(
						'label' => 'Sidebar',
						'img' => 'layout_page/portfolio-right.png',
					),
					'full' => 
					array(
						'label' => 'Fullwidth',
						'img' => 'layout_page/portfolio-no-sidebar.png',
					),
					'sidebar_left' => 
					array(
						'label' => 'Left sidebar',
						'img' => 'layout_page/portfolio-left.png',
					),
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'sidebar',
				'layout' => 'vertical',
				'field_group' => 2514,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_post-format-gallery',
		'title' => 'Post format &#8211; gallery',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_53cd164750f27',
				'label' => 'Click the button below and create your gallery',
				'name' => 'bw_gallery',
				'_name' => 'bw_gallery',
				'type' => 'gallery-advanced',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-bw_gallery',
				'class' => 'gallery-advanced',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'advanced' => 0,
				'field_group' => 1044,
				'layout' => 'vertical',
				'choices' => 
				array(
				),
				'default_value' => '',
				'other_choice' => 0,
				'save_other_choice' => 0,
			),
			1 => 
			array(
				'key' => 'field_53ce28a6a6303',
				'label' => 'Auto height',
				'name' => 'auto_height',
				'_name' => 'auto_height',
				'type' => 'true_false',
				'order_no' => 1,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-auto_height',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_53ce28f0a6304',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1044,
			),
			2 => 
			array(
				'key' => 'field_53ce28f0a6304',
				'label' => 'Auto play',
				'name' => 'auto_play',
				'_name' => 'auto_play',
				'type' => 'true_false',
				'order_no' => 2,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-auto_play',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_53ce28a6a6303',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1044,
			),
			3 => 
			array(
				'key' => 'field_53ce28fea6305',
				'label' => 'Hide gallery navigation',
				'name' => 'hide_nav',
				'_name' => 'hide_nav',
				'type' => 'true_false',
				'order_no' => 3,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-hide_nav',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_53ce28a6a6303',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1044,
			),
			4 => 
			array(
				'key' => 'field_5454d50227aa4',
				'label' => 'Hide pagination',
				'name' => 'hide_pag',
				'_name' => 'hide_pag',
				'type' => 'true_false',
				'order_no' => 4,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-hide_pag',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_53ce28a6a6303',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1044,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				1 => 
				array(
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'gallery',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_post-format-link',
		'title' => 'Post format &#8211; link',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_545518b92c1af',
				'label' => 'Link content',
				'name' => 'link_content',
				'_name' => 'link_content',
				'type' => 'text',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-link_content',
				'class' => 'text',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'field_group' => 1640,
			),
			1 => 
			array(
				'key' => 'field_545518cd2c1b0',
				'label' => 'Link url',
				'name' => 'link_url',
				'_name' => 'link_url',
				'type' => 'text',
				'order_no' => 1,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-link_url',
				'class' => 'text',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_545518d52c1b1',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => 'http://',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'field_group' => 1640,
			),
			2 => 
			array(
				'key' => 'field_545518d52c1b1',
				'label' => 'New tab',
				'name' => 'new_tab',
				'_name' => 'new_tab',
				'type' => 'true_false',
				'order_no' => 2,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-new_tab',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1640,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				1 => 
				array(
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'link',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_post-format-quote',
		'title' => 'Post format &#8211; quote',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_53ce7ed078d52',
				'label' => 'Quote content',
				'name' => 'quote_content',
				'_name' => 'quote_content',
				'type' => 'textarea',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-quote_content',
				'class' => 'textarea',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
				'field_group' => 1159,
			),
			1 => 
			array(
				'key' => 'field_53ce7ee578d53',
				'label' => 'Quote author',
				'name' => 'quote_author',
				'_name' => 'quote_author',
				'type' => 'text',
				'order_no' => 1,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-quote_author',
				'class' => 'text',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'field_group' => 1159,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				1 => 
				array(
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'quote',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_post-format-video',
		'title' => 'Post format &#8211; video',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_53ce7cddd18f7',
				'label' => 'Embed code',
				'name' => 'embed_code',
				'_name' => 'embed_code',
				'type' => 'textarea',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-embed_code',
				'class' => 'textarea',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
				'field_group' => 1155,
			),
			1 => 
			array(
				'key' => 'field_53ce7e4ff3e1a',
				'label' => 'Aspect ratio 16:9',
				'name' => 'aspect_ratio',
				'_name' => 'aspect_ratio',
				'type' => 'true_false',
				'order_no' => 1,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-aspect_ratio',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 1,
				'field_group' => 1155,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				1 => 
				array(
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'video',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_product-category-settings',
		'title' => 'Product category &#8211; settings',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_564a04d279d6d',
				'label' => 'Layout',
				'name' => 'layout',
				'_name' => 'layout',
				'type' => 'radio_image',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-layout',
				'class' => 'radio_image',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array(
					'default' => 
					array(
						'label' => 'Default',
						'img' => '',
					),
					'boxed_4_cols' => 
					array(
						'label' => 'I',
						'img' => 'layout_shop/1.png',
					),
					'boxed_3_cols_right_sidebar' => 
					array(
						'label' => 'II',
						'img' => 'layout_shop/2.png',
					),
					'boxed_3_cols_left_sidebar' => 
					array(
						'label' => 'III',
						'img' => 'layout_shop/3.png',
					),
					'boxed_3_cols' => 
					array(
						'label' => 'IV',
						'img' => 'layout_shop/4.png',
					),
					'boxed_2_cols_right_sidebar' => 
					array(
						'label' => 'V',
						'img' => 'layout_shop/5.png',
					),
					'boxed_2_cols_left_sidebar' => 
					array(
						'label' => 'VI',
						'img' => 'layout_shop/6.png',
					),
					'boxed_list_right_sidebar' => 
					array(
						'label' => 'VII',
						'img' => 'layout_shop/7.png',
					),
					'boxed_list_left_sidebar' => 
					array(
						'label' => 'VIII',
						'img' => 'layout_shop/8.png',
					),
					'full_6_cols' => 
					array(
						'label' => 'IX',
						'img' => 'layout_shop/9.png',
					),
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'default',
				'layout' => 'vertical',
				'field_group' => 2624,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'ef_taxonomy',
					'operator' => '==',
					'value' => 'product_cat',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			1 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
				1 => 
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-shop.php',
					'order_no' => 1,
					'group_no' => 1,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_product-settings',
		'title' => 'Product settings',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_56222e37a85e7',
				'label' => 'Product is new',
				'name' => 'is_new',
				'_name' => 'is_new',
				'type' => 'true_false',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-is_new',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1799,
			),
			1 => 
			array(
				'key' => 'field_5639c700e047d',
				'label' => 'Featured image',
				'name' => 'bw_featured_image',
				'_name' => 'bw_featured_image',
				'type' => 'image',
				'order_no' => 1,
				'instructions' => 'Add featured image that will replace the featured image displayed in the supermenu. If you leave it empty, it will use the product featured image.',
				'required' => 0,
				'id' => 'acf-field-bw_featured_image',
				'class' => 'image',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56222e37a85e7',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'field_group' => 1799,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_template-journal-page',
		'title' => 'Template &#8211; Journal Page',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_56435c7d8ffdf',
				'label' => 'Layout',
				'name' => 'layout',
				'_name' => 'layout',
				'type' => 'radio_image',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-layout',
				'class' => 'radio_image',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array(
					'standard' => 
					array(
						'label' => 'Standard',
						'img' => 'layout_blog/standard.png',
					),
					'list' => 
					array(
						'label' => 'List no sidebar',
						'img' => 'layout_blog/list_standard.png',
					),
					'grid' => 
					array(
						'label' => 'Grid no sidebar',
						'img' => 'layout_blog/grid_standard.png',
					),
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'standard',
				'layout' => 'vertical',
				'field_group' => 1660,
			),
			1 => 
			array(
				'key' => 'field_56154ccfdb1f7',
				'label' => 'Select categories',
				'name' => 'categories',
				'_name' => 'categories',
				'type' => 'taxonomy',
				'order_no' => 1,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-categories',
				'class' => 'taxonomy',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56156e1b03222',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'taxonomy' => 'category',
				'field_type' => 'multi_select',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'id',
				'field_group' => 1660,
				'multiple' => 0,
			),
			2 => 
			array(
				'key' => 'field_561627e438559',
				'label' => 'Number of posts',
				'name' => 'number_of_posts',
				'_name' => 'number_of_posts',
				'type' => 'number_slider',
				'order_no' => 2,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-number_of_posts',
				'class' => 'number_slider',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56156e1b03222',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 10,
				'prepend' => '',
				'append' => 'posts.',
				'min' => 2,
				'max' => 50,
				'step' => '',
				'field_group' => 1660,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				1 => 
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-journal.php',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_template-shop-page',
		'title' => 'Template &#8211; Shop page',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_564afad865320',
				'label' => 'Select product category',
				'name' => 'product_category',
				'_name' => 'product_category',
				'type' => 'taxonomy',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-product_category',
				'class' => 'taxonomy',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_564b0fbbaf6f6',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'taxonomy' => 'product_cat',
				'field_type' => 'multi_select',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'id',
				'field_group' => 2667,
				'multiple' => 0,
			),
			1 => 
			array(
				'key' => 'field_564b0fbbaf6f6',
				'label' => 'Display content outside the container',
				'name' => 'content_outside',
				'_name' => 'content_outside',
				'type' => 'true_false',
				'order_no' => 1,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-content_outside',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 1,
				'field_group' => 2667,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				1 => 
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-shop.php',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 0,
	)); 
    register_field_group(array(
		'id' => 'acf_page-settings',
		'title' => 'Page &#8211; Settings',
		'fields' => 
		array(
			0 => 
			array(
				'key' => 'field_56507cd50e81f',
				'label' => 'General',
				'name' => '',
				'_name' => '',
				'type' => 'tab',
				'order_no' => 0,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-',
				'class' => 'tab',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'field_group' => 1655,
			),
			1 => 
			array(
				'key' => 'field_559e0cc26fcf8',
				'label' => 'Hide page title',
				'name' => 'hide_title',
				'_name' => 'hide_title',
				'type' => 'true_false',
				'order_no' => 1,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-hide_title',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			2 => 
			array(
				'key' => 'field_561ceb6a704bf',
				'label' => 'Sub title',
				'name' => 'sub_title',
				'_name' => 'sub_title',
				'type' => 'text',
				'order_no' => 2,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-sub_title',
				'class' => 'text',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '!=',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				'field_group' => 1655,
			),
			3 => 
			array(
				'key' => 'field_561cea0a15166',
				'label' => 'Breadcrumb',
				'name' => 'breadcrumb',
				'_name' => 'breadcrumb',
				'type' => 'select',
				'order_no' => 3,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-breadcrumb',
				'class' => 'select',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array(
					'default' => 'Default',
					'enabled' => 'Enabled',
					'disabled' => 'Disabled',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
				'field_group' => 1655,
			),
			4 => 
			array(
				'key' => 'field_563b77a8a92f7',
				'label' => 'Enable scroller',
				'name' => 'enable_scroller',
				'_name' => 'enable_scroller',
				'type' => 'true_false',
				'order_no' => 4,
				'instructions' => 'Enable this option if you want to display section scroller. It will only works if you have enabled the page builder and have multiple row sections.',
				'required' => 0,
				'id' => 'acf-field-enable_scroller',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			5 => 
			array(
				'key' => 'field_564ae185ab69b',
				'label' => 'Use dark color for scroller',
				'name' => 'scroller_dark',
				'_name' => 'scroller_dark',
				'type' => 'true_false',
				'order_no' => 5,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-scroller_dark',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_563b77a8a92f7',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 1,
				'field_group' => 1655,
			),
			6 => 
			array(
				'key' => 'field_5652c752d44b2',
				'label' => 'Overlap header',
				'name' => 'overlap_header',
				'_name' => 'overlap_header',
				'type' => 'true_false',
				'order_no' => 6,
				'instructions' => 'This options will overlap the header with the page content.',
				'required' => 0,
				'id' => 'acf-field-overlap_header',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			7 => 
			array(
				'key' => 'field_56507d0917fa2',
				'label' => 'Custom header layout',
				'name' => '',
				'_name' => '',
				'type' => 'tab',
				'order_no' => 7,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-',
				'class' => 'tab',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'field_group' => 1655,
			),
			8 => 
			array(
				'key' => 'field_56507d2417fa3',
				'label' => 'Overwrite header layout',
				'name' => 'overwrite_header_layout',
				'_name' => 'overwrite_header_layout',
				'type' => 'true_false',
				'order_no' => 8,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-overwrite_header_layout',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			9 => 
			array(
				'key' => 'field_565086495facc',
				'label' => 'Logo for current page',
				'name' => 'logo',
				'_name' => 'logo',
				'type' => 'image',
				'order_no' => 9,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-logo',
				'class' => 'image',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'field_group' => 1655,
			),
			10 => 
			array(
				'key' => 'field_56507d79f0530',
				'label' => 'Header version',
				'name' => 'header_version',
				'_name' => 'header_version',
				'type' => 'radio_image',
				'order_no' => 10,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-header_version',
				'class' => 'radio_image',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array(
					'v1' => 
					array(
						'label' => 'Header version 1',
						'img' => 'layout_header/1.png',
					),
					'v2' => 
					array(
						'label' => 'Header version 2',
						'img' => 'layout_header/2.png',
					),
					'v3' => 
					array(
						'label' => 'Header version 3',
						'img' => 'layout_header/3.png',
					),
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => '',
				'layout' => 'vertical',
				'field_group' => 1655,
			),
			11 => 
			array(
				'key' => 'field_565080d356de5',
				'label' => 'Header minimum height',
				'name' => 'header_v1_height',
				'_name' => 'header_v1_height',
				'type' => 'number_slider',
				'order_no' => 11,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-header_v1_height',
				'class' => 'number_slider',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 50,
				'prepend' => '',
				'append' => 'px.',
				'min' => 50,
				'max' => 300,
				'step' => 1,
				'field_group' => 1655,
			),
			12 => 
			array(
				'key' => 'field_5650849fdca1a',
				'label' => 'Enable frame borders',
				'name' => 'enable_hv1_borders',
				'_name' => 'enable_hv1_borders',
				'type' => 'true_false',
				'order_no' => 12,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-enable_hv1_borders',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			13 => 
			array(
				'key' => 'field_5650856215c30',
				'label' => 'Dark header',
				'name' => 'enable_hv1_dark',
				'_name' => 'enable_hv1_dark',
				'type' => 'true_false',
				'order_no' => 13,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-enable_hv1_dark',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			14 => 
			array(
				'key' => 'field_565085f29c598',
				'label' => 'Hide main navigation borders',
				'name' => 'disable_hv1_nav_borders',
				'_name' => 'disable_hv1_nav_borders',
				'type' => 'true_false',
				'order_no' => 14,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-disable_hv1_nav_borders',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			15 => 
			array(
				'key' => 'field_565089d94c441',
				'label' => 'Dark header',
				'name' => 'enable_hv2_dark',
				'_name' => 'enable_hv2_dark',
				'type' => 'true_false',
				'order_no' => 15,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-enable_hv2_dark',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v2',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			16 => 
			array(
				'key' => 'field_56508a339343a',
				'label' => 'Sticky header',
				'name' => 'sticky_header',
				'_name' => 'sticky_header',
				'type' => 'select',
				'order_no' => 16,
				'instructions' => 'Check this to make the sidebar position fixed.',
				'required' => 0,
				'id' => 'acf-field-sticky_header',
				'class' => 'select',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v2',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array(
					0 => 'Disabled',
					1 => 'Enabled',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
				'field_group' => 1655,
			),
			17 => 
			array(
				'key' => 'field_56508ad415644',
				'label' => 'Set transparent header',
				'name' => 'header_hv2_transparent',
				'_name' => 'header_hv2_transparent',
				'type' => 'true_false',
				'order_no' => 17,
				'instructions' => 'This option will also hide the breadcrumb.',
				'required' => 0,
				'id' => 'acf-field-header_hv2_transparent',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56508a339343a',
							'operator' => '==',
							'value' => '0',
						),
						2 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v2',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			18 => 
			array(
				'key' => 'field_56508b1015647',
				'label' => 'Use dark menu color',
				'name' => 'header_hv2_on_trans_page_dark_color',
				'_name' => 'header_hv2_on_trans_page_dark_color',
				'type' => 'true_false',
				'order_no' => 18,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-header_hv2_on_trans_page_dark_color',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v2',
						),
						2 => 
						array(
							'field' => 'field_56508a339343a',
							'operator' => '==',
							'value' => '0',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			19 => 
			array(
				'key' => 'field_56508cfca359b',
				'label' => 'Header on bottom',
				'name' => 'header_hv2_on_bottom',
				'_name' => 'header_hv2_on_bottom',
				'type' => 'true_false',
				'order_no' => 19,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-header_hv2_on_bottom',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56508a339343a',
							'operator' => '==',
							'value' => '1',
						),
						2 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v2',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			20 => 
			array(
				'key' => 'field_565091436a4f2',
				'label' => 'Set transparent header',
				'name' => 'header_hv3_transparent',
				'_name' => 'header_hv3_transparent',
				'type' => 'true_false',
				'order_no' => 20,
				'instructions' => 'This option will also hide the breadcrumb.',
				'required' => 0,
				'id' => 'acf-field-header_hv3_transparent',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_56507d2417fa3',
							'operator' => '==',
							'value' => '1',
						),
						1 => 
						array(
							'field' => 'field_56507d79f0530',
							'operator' => '==',
							'value' => 'v3',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			21 => 
			array(
				'key' => 'field_566e980f6b3fd',
				'label' => 'Breadcrumb',
				'name' => '',
				'_name' => '',
				'type' => 'tab',
				'order_no' => 21,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-',
				'class' => 'tab',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'field_group' => 1655,
			),
			22 => 
			array(
				'key' => 'field_566e98276b3fe',
				'label' => 'Enable background image',
				'name' => 'brc_enable_background_image',
				'_name' => 'brc_enable_background_image',
				'type' => 'true_false',
				'order_no' => 22,
				'instructions' => 'This option will only work if you have a breadcrumb visible on the page.',
				'required' => 0,
				'id' => 'acf-field-brc_enable_background_image',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 0,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_559e0cc26fcf8',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
			23 => 
			array(
				'key' => 'field_566e98366b3ff',
				'label' => 'Background image',
				'name' => 'brc_background_image',
				'_name' => 'brc_background_image',
				'type' => 'image',
				'order_no' => 23,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-brc_background_image',
				'class' => 'image',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_566e98276b3fe',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'field_group' => 1655,
			),
			24 => 
			array(
				'key' => 'field_566e987e6b402',
				'label' => 'Color',
				'name' => 'brc_color',
				'_name' => 'brc_color',
				'type' => 'color_picker',
				'order_no' => 24,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-brc_color',
				'class' => 'color_picker',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_566e98276b3fe',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'field_group' => 1655,
			),
			25 => 
			array(
				'key' => 'field_566e9d5e9ad83',
				'label' => 'Display title',
				'name' => 'brc_title',
				'_name' => 'brc_title',
				'type' => 'true_false',
				'order_no' => 25,
				'instructions' => '',
				'required' => 0,
				'id' => 'acf-field-brc_title',
				'class' => 'true_false',
				'conditional_logic' => 
				array(
					'status' => 1,
					'rules' => 
					array(
						0 => 
						array(
							'field' => 'field_566e98276b3fe',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
				'field_group' => 1655,
			),
		),
		'location' => 
		array(
			0 => 
			array(
				0 => 
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => 
		array(
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array(
			),
		),
		'menu_order' => 2,
	)); 
}