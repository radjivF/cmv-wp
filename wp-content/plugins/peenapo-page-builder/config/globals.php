<?php
/*--------------------------------------------*/
/* Peenapo Page Builder - Global Configuration
/*--------------------------------------------*/

# enable the page builder for post types
$GLOBALS["pb_config"]['post_types'] = array('page');
# size of font end main container
$GLOBALS["pb_config"]['container_max_with'] = 1100;
# column sizes
$GLOBALS["pb_config"]['col_sizes'] = array('16','20','25','33','40','50','60','66','75','80','83','100');
# columns combination options
$GLOBALS["pb_config"]['cols'] = array('100','50,50','33,33,33','66,33','25,25,25,25','25,75','25,50,25','83,16','16,16,16,16,16,16','16,66,16','16,16,16,50','20,80','20,20,20,40');
# set to true to hide the main wp editor when the page builder is active
$GLOBALS["pb_config"]['hide_editor'] = true;
# the facebook app id used for facebook comments element
$GLOBALS["pb_config"]['fb_app_id'] = '909404119091496';
# enable licesing
$GLOBALS["pb_config"]['enable_licensing'] = true;
# load the front javascript file on page load
$GLOBALS["pb_config"]['front_end_load_js'] = true;
# align table vertically
$GLOBALS["pb_config"]['align_tables'] = true; //.bwpb-row-inner
$GLOBALS["pb_config"]['cat_icons'] = array(
    'General' => 'fa fa-television',
    'Social' => 'bwpb-lineicon-share',
    'Theme' => 'fa fa-clone',
);
$GLOBALS["pb_config"]['ele_colors'] = array(
    'bw_text'               => '#f3bd54',
    'bw_video_player'       => '#e1595e',
    'bw_embed_player'       => '#e1595e',
    'bw_sidebar'            => '#a278e2',
    'bw_single_image'       => '#65ccd0',
    'bw_button'             => '#9abf7f',
    'bw_icon'               => '#659adb',
    'bw_icon_text'          => '#659adb',
    'bw_heading_section'    => '#78e296',
    'vendors_rev_slider'    => '#f05826',
    'vendors_cf7'           => '#d28bfa',
);