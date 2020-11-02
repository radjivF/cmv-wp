<?php
/**
 * Initialize the custom theme options.
 */
//add_action( 'admin_init', 'custom_theme_options' );
custom_theme_options();

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet, or this is not an admin request */
  if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => 'Getting started',
        'icon'       => 'fa-check'
      ),
      array(
        'id'          => 'header_layout',
        'title'       => 'Header layout',
        'icon'       => 'fa-desktop'
      ),
      array(
        'id'          => 'style',
        'title'       => 'Style',
        'icon'       => 'fa-flask'
      ),
      array(
        'id'          => 'social',
        'title'       => 'Social',
        'icon'       => 'fa-share-alt'
      ),
      array(
        'id'          => 'fonts',
        'title'       => 'Fonts',
        'icon'       => 'fa-font'
      ),
      array(
        'id'          => 'blog',
        'title'       => 'Blog &amp; Pages',
        'icon'       => 'fa-newspaper-o'
      ),
      array(
        'id'          => 'section_newsletter',
        'title'       => 'Newsletter',
        'icon'       => 'fa fa-envelope-o'
      ),
      array(
        'id'          => 'account',
        'title'       => 'Account',
        'icon'       => 'fa fa-user'
      ),
      array(
        'id'          => 'shop',
        'title'       => 'Shop',
        'icon'       => 'fa fa-dollar'
      ),
      array(
        'id'          => 'tab_demo_import',
        'title'       => 'Demo import',
        'icon'       => 'fa fa-server'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'logo',
        'label'       => 'Logo',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'logo_mobile',
        'label'       => 'Logo mobile version',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'fav_icon',
        'label'       => 'Fav icon',
        'desc'        => 'Icon must be: 16px X 16px or 32px X 32px',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_site_desc',
        'label'       => 'Enable site description under logo',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'custom_site_desc',
        'label'       => 'Custom site description',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'enable_site_desc:is(1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_smooth_scroll',
        'label'       => 'Enable smooth scroll',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_copy',
        'label'       => 'Footer copy',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_version',
        'label'       => 'Header version',
        'desc'        => '',
        'std'         => '',
        'type'        => 'radio-image',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'v1',
            'label'       => 'Header version 1',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_header/1.png'
          ),
          array(
            'value'       => 'v2',
            'label'       => 'Header version 2',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_header/2.png'
          ),
          array(
            'value'       => 'v3',
            'label'       => 'Header version 3',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_header/3.png'
          )
        )
      ),
      array(
        'id'          => 'header_v1_height',
        'label'       => 'Header minimum height',
        'desc'        => '',
        'std'         => '',
        'type'        => 'numeric-slider',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '50,300,1',
        'class'       => '',
        'condition'   => 'header_version:is(v1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_hv1_borders',
        'label'       => 'Enable frame borders',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'header_version:is(v1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_hv2_dark',
        'label'       => 'Dark header',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'header_version:is(v2)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_hv1_dark',
        'label'       => 'Dark header',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'header_version:is(v1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'disable_hv1_nav_borders',
        'label'       => 'Hide main navigation borders',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'header_version:is(v1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'sticky_header',
        'label'       => 'Sticky header',
        'desc'        => 'Check this to make the sidebar position fixed.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'header_version:is(v2)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '0',
            'label'       => 'Disabled',
            'src'         => ''
          ),
          array(
            'value'       => '1',
            'label'       => 'Enabled',
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'menu_logo',
        'label'       => 'Menu logo',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'header_version:is(v3)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'breadcrumb',
        'label'       => 'Display breadcrumb by default',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'enabled',
            'label'       => 'Enabled',
            'src'         => ''
          ),
          array(
            'value'       => 'disabled',
            'label'       => 'Disabled',
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'enable_search',
        'label'       => 'Enable search option',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'show_wp_bar',
        'label'       => 'Show default wp admin bar',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'header_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'main_color',
        'label'       => 'Main color',
        'desc'        => '',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'custom_css',
        'label'       => 'Custom CSS',
        'desc'        => 'Add custom styles to theme. Example: body {color:red;}',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'custom_js',
        'label'       => 'Custom Javascript',
        'desc'        => 'Add custom Javascript. Example: alert(1);',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_facebook_sharing',
        'label'       => 'Enable Facebook sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_twitter_sharing',
        'label'       => 'Enable Twitter sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_google_sharing',
        'label'       => 'Enable Google plus sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_tumblr_sharing',
        'label'       => 'Enable Tumblr sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_digg_sharing',
        'label'       => 'Enable Digg sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_delicious_sharing',
        'label'       => 'Enable Delicious sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_icons',
        'label'       => 'Social icons',
        'desc'        => 'Click the "Add New" button, choose the social media and add the url, example: http://www.facebook.com/envato',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'social_media',
            'label'       => 'Social media',
            'desc'        => '',
            'std'         => '',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and',
            'choices'     => array( 
              array(
                'value'       => 'aboutme',
                'label'       => 'Aboutme',
                'src'         => ''
              ),
              array(
                'value'       => 'amazon',
                'label'       => 'Amazon',
                'src'         => ''
              ),
              array(
                'value'       => 'aol',
                'label'       => 'Aol',
                'src'         => ''
              ),
              array(
                'value'       => 'apple',
                'label'       => 'Apple',
                'src'         => ''
              ),
              array(
                'value'       => 'appstore',
                'label'       => 'Appstore',
                'src'         => ''
              ),
              array(
                'value'       => 'bebo',
                'label'       => 'Bebo',
                'src'         => ''
              ),
              array(
                'value'       => 'behance',
                'label'       => 'Behance',
                'src'         => ''
              ),
              array(
                'value'       => 'bing',
                'label'       => 'Bing',
                'src'         => ''
              ),
              array(
                'value'       => 'blogger',
                'label'       => 'Blogger',
                'src'         => ''
              ),
              array(
                'value'       => 'delicious',
                'label'       => 'Delicious',
                'src'         => ''
              ),
              array(
                'value'       => 'diggalt',
                'label'       => 'Diggalt',
                'src'         => ''
              ),
              array(
                'value'       => 'dribble',
                'label'       => 'Dribble',
                'src'         => ''
              ),
              array(
                'value'       => 'ebay',
                'label'       => 'Ebay',
                'src'         => ''
              ),
              array(
                'value'       => 'email',
                'label'       => 'Email',
                'src'         => ''
              ),
              array(
                'value'       => 'facebook',
                'label'       => 'Facebook',
                'src'         => ''
              ),
              array(
                'value'       => 'flickr',
                'label'       => 'Flickr',
                'src'         => ''
              ),
              array(
                'value'       => 'foodspotting',
                'label'       => 'Foodspotting',
                'src'         => ''
              ),
              array(
                'value'       => 'github',
                'label'       => 'Github',
                'src'         => ''
              ),
              array(
                'value'       => 'googlebuzz',
                'label'       => 'Googlebuzz',
                'src'         => ''
              ),
              array(
                'value'       => 'gowallapin',
                'label'       => 'Gowallapin',
                'src'         => ''
              ),
              array(
                'value'       => 'grooveshark',
                'label'       => 'Grooveshark',
                'src'         => ''
              ),
              array(
                'value'       => 'googleplus',
                'label'       => 'Google plus',
                'src'         => ''
              ),
              array(
                'value'       => 'heart',
                'label'       => 'Heart',
                'src'         => ''
              ),
              array(
                'value'       => 'icq',
                'label'       => 'Icq',
                'src'         => ''
              ),
              array(
                'value'       => 'instagram',
                'label'       => 'Instagram',
                'src'         => ''
              ),
              array(
                'value'       => 'imessage',
                'label'       => 'Imessage',
                'src'         => ''
              ),
              array(
                'value'       => 'itunes',
                'label'       => 'Itunes',
                'src'         => ''
              ),
              array(
                'value'       => 'lastfm',
                'label'       => 'Lastfm',
                'src'         => ''
              ),
              array(
                'value'       => 'linkedin',
                'label'       => 'Linkedin',
                'src'         => ''
              ),
              array(
                'value'       => 'mobileme',
                'label'       => 'Mobileme',
                'src'         => ''
              ),
              array(
                'value'       => 'myspace',
                'label'       => 'Myspace',
                'src'         => ''
              ),
              array(
                'value'       => 'picasa',
                'label'       => 'Picasa',
                'src'         => ''
              ),
              array(
                'value'       => 'pinterest',
                'label'       => 'Pinterest',
                'src'         => ''
              ),
              array(
                'value'       => 'soundcloud',
                'label'       => 'Soundcloud',
                'src'         => ''
              ),
              array(
                'value'       => 'twitter',
                'label'       => 'Twitter',
                'src'         => ''
              ),
              array(
                'value'       => 'vimeo',
                'label'       => 'Vimeo',
                'src'         => ''
              ),
              array(
                'value'       => 'skype',
                'label'       => 'Skype',
                'src'         => ''
              ),
              array(
                'value'       => 'star',
                'label'       => 'Star',
                'src'         => ''
              ),
              array(
                'value'       => 'tumblr',
                'label'       => 'Tumblr',
                'src'         => ''
              ),
              array(
                'value'       => 'wordpress',
                'label'       => 'Wordpress',
                'src'         => ''
              ),
              array(
                'value'       => 'xing',
                'label'       => 'Xing',
                'src'         => ''
              ),
              array(
                'value'       => 'yahoo',
                'label'       => 'Yahoo',
                'src'         => ''
              ),
              array(
                'value'       => 'youtube',
                'label'       => 'Youtube',
                'src'         => ''
              ),
              array(
                'value'       => 'fivehundredpx',
                'label'       => '500px',
                'src'         => ''
              )
            )
          ),
          array(
            'id'          => 'social_url',
            'label'       => 'Url',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          )
        )
      ),
      array(
        'id'          => 'custom_fonts_desc',
        'label'       => 'Custom fonts',
        'desc'        => 'In this page you can set the typefaces to be used throughout the theme. For each elements listed below you can choose any front from the Google Web Font library. Once you have chosen a font from the list, you will see a preview of this font immediately beneath the list box. The icons on the bottom of the font preview, indicate what weights are available for that typeface.

R -- Regular,
B -- Bold,
I -- Italics,
BI -- Bold Italics

When deciding what font to use, ensure that the chosen font contains the font weight required by the element. For example, main headings are bold, so you need to select a new font for these elements which supports a bold font weight. If you select a font which does not have a bold icon, the font will not be applied.

Browse the online Google Font Library

Custom fonts (Advanced Users):
Other then those available from Google fonts, custom fonts may also be applied to the elements listed below. To do this an additional field is provided below the google fonts list. Here you may enter the details of a font family, size, line-height etc. for a custom font. This information is entered in the form of the shorthand \'font:\' CSS declaration, for example:

bold italic small-caps 1em/1.5em arial,sans-serif

If a font is specified in this field then the font listed in the Google font drop menu above will not be applied to the element in question. If you wish to use the Google font specified in the drop down list and just specify a new font size or line height, you can do so in this field also, however the name of the Google font MUST also be entered into this field. You may need to visit the Google fonts web page to find the exact CSS name for the font you have chosen.',
        'std'         => '',
        'type'        => 'bw-text-content',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'body_font',
        'label'       => 'Body font',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-select-font',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'body_font_declaration',
        'label'       => 'Body font declaration',
        'desc'        => 'Here you can add a custom font declaration, useful when you want to change size or  use a common (not google) font.Example: <b>15px arial,sans-serif</b>',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'heading_font',
        'label'       => 'Heading font',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-select-font',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'heading_font_declaration',
        'label'       => 'Heading font declaration',
        'desc'        => 'Here you can add a custom font declaration, useful when you want to change size or  use a common (not google) font.Example: <b>15px arial,sans-serif</b>',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'alt_font',
        'label'       => 'Additional elements font',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-select-font',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'alt_font_declaration',
        'label'       => 'Additional font elements declaration',
        'desc'        => 'Here you can add a custom font declaration, useful when you want to change size or  use a common (not google) font.Example: <b>15px arial,sans-serif</b>',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'single_author',
        'label'       => 'Enable single post author',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'blog',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'comment_type_blog',
        'label'       => 'Comment type',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'blog',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'default',
            'label'       => 'Default wordpress comments',
            'src'         => ''
          ),
          array(
            'value'       => 'facebook',
            'label'       => 'Facebook comment box',
            'src'         => ''
          ),
          array(
            'value'       => 'none',
            'label'       => 'None',
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'comment_type_page',
        'label'       => 'Page comment type',
        'desc'        => '',
        'std'         => 'default',
        'type'        => 'select',
        'section'     => 'blog',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'default',
            'label'       => 'Default wordpress comments',
            'src'         => ''
          ),
          array(
            'value'       => 'facebook',
            'label'       => 'Facebook comment box',
            'src'         => ''
          ),
          array(
            'value'       => 'none',
            'label'       => 'None',
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'newsletter',
        'label'       => 'Enable newsletter',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'section_newsletter',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'newsletter_once',
        'label'       => 'Show newsletter once per user?',
        'desc'        => 'Mark this option if you want to display the popup only for the first customer\'s visit, every 30 days.',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'section_newsletter',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'newsletter:is(1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'newsletter_page',
        'label'       => 'Page to show newsletter',
        'desc'        => 'This will be the page where to show the popup.',
        'std'         => '',
        'type'        => 'page-select',
        'section'     => 'section_newsletter',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'newsletter:is(1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'newsletter_bg',
        'label'       => 'Newsletter background image',
        'desc'        => 'Leave empty for white background color.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'section_newsletter',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'newsletter:is(1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'newsletter_content',
        'label'       => 'Newsletter content',
        'desc'        => 'Here you can put your newsletter content. You can use html elements or even shortcodes. We used contact from 7 plugin to display the email input. Please check the theme\'s documentation for more tips.',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'section_newsletter',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'newsletter:is(1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'enable_top_user_login',
        'label'       => 'Enable top navigation user data',
        'desc'        => 'Remove top navigation user login / registration / drop-down user info.',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'facebook_login',
        'label'       => 'Enable Facebook login',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'facebook_id',
        'label'       => 'Facebook App Id',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'facebook_login:is(1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'google_login',
        'label'       => 'Enable Google login',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'google_id',
        'label'       => 'Google Client Id',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'google_login:is(1)',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'login_logo',
        'label'       => 'Add logo for login popup',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'shop_enable_title',
        'label'       => 'Shop page - enable title',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'shop',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'shop_default_layout',
        'label'       => 'Default layout',
        'desc'        => '',
        'std'         => 'boxed_3_cols_right_sidebar',
        'type'        => 'radio-image',
        'section'     => 'shop',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'boxed_4_cols',
            'label'       => 'I',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/1.png'
          ),
          array(
            'value'       => 'boxed_3_cols_right_sidebar',
            'label'       => 'II',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/2.png'
          ),
          array(
            'value'       => 'boxed_3_cols_left_sidebar',
            'label'       => 'III',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/3.png'
          ),
          array(
            'value'       => 'boxed_3_cols',
            'label'       => 'IV',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/4.png'
          ),
          array(
            'value'       => 'boxed_2_cols_right_sidebar',
            'label'       => 'V',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/5.png'
          ),
          array(
            'value'       => 'boxed_2_cols_left_sidebar',
            'label'       => 'VI',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/6.png'
          ),
          array(
            'value'       => 'boxed_list_right_sidebar',
            'label'       => 'VII',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/7.png'
          ),
          array(
            'value'       => 'boxed_list_left_sidebar',
            'label'       => 'VIII',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/8.png'
          ),
          array(
            'value'       => 'full_6_cols',
            'label'       => 'IX',
            'src'         => 'OT_THEME_URL/bw/assets/img/admin/layout_shop/9.png'
          )
        )
      ),
      array(
        'id'          => 'enable_ql',
        'label'       => 'Enable quick look',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'shop',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'shop_search_enabled',
        'label'       => 'Search in shop',
        'desc'        => 'If you enable this option, when you search in the site, it will only output products in the default shopping layout. Otherwise you will have standard Wordpress search with any posts.',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'shop',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'shop_img_zoom',
        'label'       => 'Enable image zoom on products',
        'desc'        => '',
        'std'         => '',
        'type'        => 'bw-on-off',
        'section'     => 'shop',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'demo_import',
        'label'       => 'One click demo import',
        'desc'        => '*NOTE: If you import demo content it will overwrite the existing data and settings. Choose the demo you want and then click the button "Import demo content".',
        'std'         => '',
        'type'        => 'bw-import-data',
        'section'     => 'tab_demo_import',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'Default demo version',
            'src'         => ''
          )
        )
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}