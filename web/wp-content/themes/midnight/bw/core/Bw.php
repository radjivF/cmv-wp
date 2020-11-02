<?php

/* This file is property of bad Weather Themes. You may NOT copy, or redistribute
 * it. Please see the license that came with your copy for more information.
 */

/**
 * @package    Bw
 * @category   functions
 * @author     Bad Weather Themes
 * @copyright  (c) 2014, Bad Weather Themes
 */

class Bw {
        
    static $hver = 'v1';
    static $overwrite_header_layout = false;
    static $overwrite_header_opt = false;
    
    # define startup classes
    static $startup_classes = array(
        'setup',        # sets up theme defaults
        'meta',         # initiate option tree and acf plugins
        'woo',          # woocommerce initialization
        'admin',        # initiate admin stuff
        'theme',        # load theme components
        'theme_ajax',   # ajax callbacks
        'assets',       # load css, javascript, erc.
        'widgets',      # widgets
        'page_builder', # page builder
    );
    
    # initiate defined modules in $startup_classes
    static function init() {
        foreach( self::$startup_classes as $stc ) {
            call_user_func( array( 'Bw_' . $stc, 'init' ) );
        }
    }
    
    /**
     * Requires all PHP files in a directory.
     * Use case: callback directory, removes the need to manage callbacks.
     *
     * Should be used on a small directory chunks with no sub directories to
     * keep code clear.
     *
     * @param string path
     */
    static function require_all( $path ) {
        if( is_array( $path ) ) {
            foreach($path as $p) {
                self::require_all($p);
            }
            return;
        }
        $files = self::find_files( rtrim( $path, '\\/' ) );
        foreach ( $files as $file ) {
            if ( strpos( $file, '.php' ) && !strpos( $file, 'Bw.php' ) ) {
                require $file;
            }
        }
    }
    
    /**
     * Recursively finds all files in a directory.
     *
     * @param string directory to search
     * @return array found files
     */
    static function find_files( $dir ) {
        
        $found_files = array();
        $files = scandir( $dir );
        
        foreach ( $files as $value ) {
            // skip special dot files
            if ( $value === '.' || $value === '..' ) {
                continue;
            }

            // is it a file?
            if ( is_file( "$dir/$value" ) ) {
                $found_files[]= "$dir/$value";
                continue;
            }else{ // it's a directory
                foreach ( self::find_files( "$dir/$value" ) as $value ) {
                    $found_files[] = $value;
                }
            }
        }

        return $found_files;
    }
    
    # display navigation to next/previous set of posts when applicable.
    static function paging_nav( $max_num_pages = false ) {
        
        $max_num_pages = $max_num_pages === false ? $GLOBALS['wp_query']->max_num_pages : $max_num_pages;
        
        # Don't print empty markup if there's only one page.
        if ( $max_num_pages < 2 ) { return; }
        ?>
        
        <nav class="navigation paging-navigation">
            <div class="nav-posts-holder">
                <div class="nav-posts">

                    <div class="nav-previous<?php echo ! get_next_posts_link( '', $max_num_pages ) ? ' bw-nav-empty' : ''; ?>">
                        <?php if ( get_next_posts_link( '', $max_num_pages ) ) : ?>
                            <?php next_posts_link( esc_html__( 'Previous', 'midnight' ), $max_num_pages ); ?>
                        <?php endif; ?>
                    </div>

                    <div class="nav-next<?php echo ! get_previous_posts_link() ? ' bw-nav-empty' : ''; ?>">
                        <?php if ( get_previous_posts_link() ) : ?>
                            <?php previous_posts_link( esc_html__( 'Next', 'midnight' ) ); ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </nav><?php
    }
    
    # get the current page
    static function current_page() {
        $var = is_front_page() ? 'page' : 'paged';
        return get_query_var( $var ) ? get_query_var( $var ) : 1;
    }
    
    # display numeric pagination
    static function pagination( $pages = '', $range = 4, $show_map = false ) {
        
        $showitems = ( $range * 2 ) + 1;

        $paged = Bw::current_page();

        if( $pages <= 1 ) { return; }
        
        if( $pages == '' ) {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if( ! $pages ) { $pages = 1; }
        }   

        if( $pages !== 1 ) {
            
            echo "<div class='pagination'>";
            
            if( $show_map ) {
                echo "<span>Page {$paged} of {$pages}</span>";
            }
            
            if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) { echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>"; }
            if( $paged > 1 ) { echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; Previous</a>"; }

            for ( $i=1; $i <= $pages; $i++ ) {
                if ( $pages !== 1  && ( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) ) {
                    echo ($paged == $i)? "<span class='current'>{$i}</span>":"<a href='" . get_pagenum_link($i) . "' class='inactive'>{$i}</a>";
                }
            }
            
            if( $paged < $pages) { echo "<a href='" . get_pagenum_link( $paged + 1 ) . "'>Next &rsaquo;</a>"; }
            if( $paged < $pages-1 &&  $paged + $range-1 < $pages && $showitems < $pages ) { echo "<a href='" . get_pagenum_link( $pages ) . "'>Last &raquo;</a>"; }
            
            echo "</div>";
        }
    }
    
    # display navigation to next/previous post when applicable.
    static function post_nav() {
        
        # Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) { return; } ?>
        
        <div class="nav-links-holder">
            <nav class="navigation post-navigation">
                <h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'midnight' ); ?></h1>
                <div class="nav-links">
                    <?php
                        previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'midnight' ) );
                        next_post_link( '<div class="nav-next">%link</div>', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'midnight' ) );
                    ?>
                </div>
            </nav>
        </div><?php
    }
    
    static function kses( $string ) {
        return wp_kses(
            $string,
            array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array()
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
            )
        );
    }
    
    # returns html of logo, located in \"Bw_theme_header_options\"
    static function logo() {
        echo Bw_theme_header_options::logo();
    }
    
    # generate page title
    static function page_title() {
        return !is_front_page() ? the_title() : bloginfo('name');
    }
    
    # redirect page based on native wp redirect
    static function redirect( $location, $status = '302' ) { // statuc code: temporary redirect
        wp_redirect( $location, $status );
    }
    
    # returns custom option tree option
    static function get_option( $meta_key, $default = '' ) {
        return ot_get_option( $meta_key, $default );
    }
    
    # returns custom meta box
    static function get_meta( $meta_key, $post_id = 0, $single = true ) {
        return get_post_meta( ( ( (int)$post_id > 0 ) ? $post_id : get_the_ID() ), $meta_key, $single );
    }
    
    # echo custom meta box
    static function the_meta( $meta_key, $post_id = 0, $single = true ) {
        echo get_post_meta( ( ( (int)$post_id > 0 ) ? $post_id : get_the_ID() ), $meta_key, $single );
    }
    
    # echo true / false based on custom meta box
    static function get_meta_checkbox( $meta_key, $post_id = 0, $single = true ) {
        $value = get_post_meta( ( ( (int)$post_id > 0 ) ? $post_id : get_the_ID() ), $meta_key, $single );
        return isset($value[0]) ? $value[0] : false;
    }
    
    static function float_option( $meta_key ) {
        
        if( ! self::$overwrite_header_opt ) {
            self::$overwrite_header_layout = Bw::get_meta('overwrite_header_layout');
            self::$overwrite_header_opt = true;
        }
        
        if( self::$overwrite_header_layout ) {
            return self::get_meta( $meta_key );
        }
        
        return Bw::get_option( $meta_key );
        
    }
    
    # add additional css styles to header based on wp_head filter
    static function add_css($css) {
        Bw_theme_header_options::add_css($css);
    }
    
    # generates a list of social icons
    static function go_social() {
        
        // mono social icons unicode
        $unicode = array( "aboutme" => "&#xe001;", "aol" => "&#xe004;", "amazon" => "&#xe003;", "apple" => "&#xe007;", "appstore" => "&#xe006;", "bebo" => "&#xe008;", "behance" => "&#xe009;", "bing" => "&#xe010;", "blogger" => "&#xe012;", "dribble" => "&#xe021;", "delicious" => "&#xe015;", "diggalt" => "&#xe019;", "ebay" => "&#xe023;", "email" => "&#xe024;", "facebook" => "&#xe027;", "googleplus" => "&#xe039;", "pinterest" => "&#xe064;", "instagram" => "&#xe100;", "linkedin" => "&#xe052;", "skype" => "&#xe074;", "tumblr" => "&#xe085;", "github" => "&#xe037;", "flickr" => "&#xe029;", "foodspotting" => "&#xe030;", "googlebuzz" => "&#xe038;", "gowallapin" => "&#xe041;", "grooveshark" => "&#xe043;", "heart" => "&#xe044;", "icq" => "&#xe047;", "imessage" => "&#xe049;", "itunes" => "&#xe050;", "lastfm" => "&#xe051;", "mobileme" => "&#xe056;", "myspace" => "&#xe059;", "picasa" => "&#xe063;", "soundcloud" => "&#xe078;", "star" => "&#xe082;", "twitter" => "&#xe086;", "vimeo" => "&#xe089;", "wordpress" => "&#xe094;", "xing" => "&#xe095;", "yahoo" => "&#xe097;", "youtube" => "&#xe099;", "fivehundredpx" => "&#xe000;" );
        
        $social_icons = Bw::get_option('social_icons');
        if(is_array($social_icons)) {
            $output = '<ul class="bw-social">';
            foreach($social_icons as $media) {
                $output .= '<li><a href="' . esc_url( $media['social_url'] ) . '" target="_blank"><span class="icon">' . esc_attr( $unicode[$media['social_media']] ) . '</span></a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
    
    # generate page breadcrumbs, located in \"Bw_theme_header_options\"
    static function the_breadcrumb() {
        
        // fix the shop
        if( function_exists( 'is_shop' ) and is_shop() ) {
            echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__('Home', 'midnight') . '</a></li><li><span>' . esc_html__('The Shop', 'midnight') . '</span></li></ul>';
            return;
        }
        
        // fix the blog
        if( is_home() ) {
            echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__('Home', 'midnight') . '</a></li><li><span>' . esc_html__('Blog', 'midnight') . '</span></li></ul>';
            return;
        }
        
        echo '<ul>';
        if ( ! is_front_page() ) {
            echo '<li><a href="';
            echo esc_url( home_url( '/' ) );
            echo '">';
            echo 'Home';
            echo "</a></li>";
            if ( is_category() || is_single() ) {
                echo '<li>';
                $first_cat = self::first_cat();
                if( is_object( $first_cat ) ) {
                    echo '<a href="' . esc_url( get_term_link( $first_cat ) ) . '">' . esc_attr( $first_cat->name ) . '</a>';
                }
                if ( is_single() ) {
                    echo "</li><li><span>";
                    the_title();
                    echo '</span></li>';
                }
            } elseif ( is_page() ) {
                echo '<li><span>';
                echo the_title();
                echo '</span></li>';
            }
        }
        elseif ( is_tag() ) { single_tag_title(); }
        elseif ( is_day() ) { echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>'; }
        elseif ( is_month() ) { echo"<li>Archive for "; the_time('F, Y'); echo'</li>'; }
        elseif ( is_year() ) { echo"<li>Archive for "; the_time('Y'); echo'</li>'; }
        elseif ( is_author() ) { echo"<li>Author Archive"; echo'</li>'; }
        elseif ( isset($_GET['paged'] ) && ! empty( $_GET['paged'] ) ) { echo "<li>Blog Archives"; echo'</li>'; }
        elseif ( is_search() ) { echo"<li>Search Results"; echo'</li>'; }
        echo '</ul>';
    }
    
    # returns array with image info based on string of ids
    static function gallerize_by_id($ids, $size = 'thumbnail', $icon = false) {
        
        $ids_array = array_filter(explode(',', $ids));
        $output = array();
        
        if( !empty($ids_array) ) {
            foreach($ids_array as $id) {
                $info = get_post($id);
                if(is_object($info)) {
                    $output[] = array(
                        'permalink' => get_permalink($info->ID),
                        'title' => $info->post_title,
                        'info' => $info->post_content,
                        'thumb' => wp_get_attachment_image_src($id, $size, $icon)
                    );
                }
            }
        }
        return $output;
    }
    
    # native wp truncate string
    static function truncate( $text, $num_words = 55, $more = null ) {
        return wp_trim_words( $text, $num_words, $more );
    }
    
    # get the current post views using jetpack Stats
    static function get_post_views( $current_post_id = 0 ) {
        
        $post_id = ( $current_post_id == 0 ) ? get_the_ID() : $current_post_id;
        
        if( function_exists( 'stats_get_csv' ) ) {
            $result = stats_get_csv('postviews', array(
                'days' => 12, // The length of the desired time frame. Default is 30. "-1" means unlimited.
                'limit' => -1, // The maximum number of records to return. Default is 100. "-1" means unlimited. 
                'period' => 'month',
                'post_id' => $post_id
            ));
            $views = $result[0]['views'];
        }else{
            $views = 0;
        }
        
        return number_format_i18n( $views );
        
    }
    
    # returns the first category from post
    static function first_cat() {
        $category = get_the_category();
        if( isset( $category[0] ) and is_object( $category[0] ) ) {
            return $category[0];
        }
        return;
    }
    
    static function get_cat_color( $cat = false ) {
        
        $c = ! $cat ? self::first_cat() : get_category( $cat );
        
        if( is_object( $c ) ) {
            $color = get_field( 'category_color', $c );
            if( ! empty( $color ) ) {
                return "background-color:{$color};";
            }elseif( (int)$c->parent > 0 ) {
                return self::get_cat_color( $c->category_parent );
            }else{
                return '';
            }
        }
    }
    
    # returns the first category from post + url
    static function first_ucat() {
        $category = get_the_category();
        if( is_object( $category[0] ) ) {
            return '<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->cat_name . '</a>';
        }
        return;
    }
    
    # get database perfix
    static function perfix() {
        global $wpdb;
        return $wpdb->prefix;
    }
    
    # convert string to human readable data
    static function humanize($str) {
        return ucfirst( str_replace( '_', ' ', strtolower( trim( $str ) ) ) );
    }
    
    static function content_class() {
        $content_class = '';
        
        switch(true) {
            case ( is_single() and Bw::get_meta('page_layout') == 'full' ) :
                $content_class .= 'full'; break;
            case is_single() :
                $content_class .= 'right'; break;
            case is_archive():
                $content_class .= 'right'; break;
            case get_post_type() == 'post':
                $content_class .= 'right'; break;
            default:
                $content_class .= Bw::the_meta('page_layout'); break;
        }
        
        return $content_class;
    }
    
    # check if the current post icon and echo
    static function get_format_icon() {
        
        $has_icon = true;
        
        switch( get_post_format() ) {
            case( 'video' ):
                $icon = 'fa-video-camera'; break;
            case( 'gallery' ):
                $icon = 'fa-camera'; break;
            default:
                $has_icon = false;
        }
        
        if( $has_icon ) {
        
            $output  = "<div class=\"post-icons\">";
            $output .= "<div class=\"icon\"><i class=\"fa {$icon}\"></i></div>";
            $output .= "</div>";
            
            return $output;
        
        }
        
        return;
    }
    
    # returns the rating of the post
    static function get_rate() {
        
        if( Bw::has_average_score() ) {
            return "<span class=\"rate bb\">" . Bw::get_average_score() . "</span>";
        }
        
        return;
        
    }
    
    # add some additional class to body tag
    static function add_body_class($class) {
        Bw_theme_header_options::add_body_class($class);
    }
    
    # return the body classes
    static function body_class( $class = '' ) {
        return Bw_theme_header_options::body_class( $class );
    }
    
    # check if post reviews enabled
    static function has_average_score() {
        
        if ( get_field( 'enable_post_review' ) && get_field( 'score_breakdown' ) ) { return true; }
        return false;
        
    }
    
    # get the score of the current post
    static function get_average_score() {
        
        if ( get_field( 'enable_post_review' ) && get_field( 'score_breakdown' ) ):
            $average = 0;
            $scores = 0;
            while ( has_sub_fields( 'score_breakdown' ) ):
                $average = $average + get_sub_field( 'score' );
                $scores++;
            endwhile;
            $average = round( $average / $scores, 1 );
            return $average;
        endif;

        return false;
    }
    
    # returns empty img or placeholder
    static function empty_img( $size = false ) {
        return BW_URI_ASSETS . 'img/empty/' . ( $size ? $size : 'pixel' ) . '.png';
    }
    
    # returns featured image src
    static function get_image_src( $size = 'thumbnail', $id = 0 ) {
        $id = ( $id == 0 ) ? get_the_ID() : $id;
        $thumb_id = get_post_thumbnail_id( $id );
        $thumb_img = wp_get_attachment_image_src( $thumb_id, $size );
        if( isset( $thumb_img[0] ) ) {
            return $thumb_img[0];
        }
        return;
    }
    
    static function get_image_attachment( $size = 'thumbnail', $id ) {
        $img_data = wp_get_attachment_image_src( $id, $size );
        return $img_data[0];
    }
    
    # returns hex color format to rgb
    static function hex2rgb( $hex ) {
        
        $hex = str_replace("#", "", $hex);
        
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);

        return $rgb; // returns an array with the rgb values
    }
    
    static function archive_title( $before = '<h2>', $after = '</h2>' ) {
        switch( true ) {
            case is_category():
                echo $before . esc_html( single_cat_title( '', false ) ) . $after; break;
            case is_search():
                echo $before . esc_html__( 'Search Results for: ', 'midnight' ) . esc_html( get_search_query() ) . $after; break;
            case is_tag():
                echo $before . esc_html( single_tag_title( esc_html__('Tagged as: ', 'midnight'), false ) ) . $after; break;
            case is_year():
                echo $before . esc_html( get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'midnight' ) ) ) . $after; break;
            case is_month():
                echo $before . esc_html( get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'midnight' ) ) ) . $after; break;
            case is_day():
                echo $before . esc_html( get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'midnight' ) ) ) . $after; break;
            case is_post_type_archive():
                echo $before . sprintf( esc_html__( 'Archives: %s', 'midnight' ), esc_html( post_type_archive_title( '', false ) ) ) . $after; break;
            case is_author():
                echo $before . sprintf( esc_html__( 'Author: %s', 'midnight' ), get_the_author() ) . $after; break;
            case is_tax():
                $tax = get_taxonomy( get_queried_object()->taxonomy );
                echo $before . sprintf( esc_html__( '%1$s: %2$s', 'midnight' ), esc_html( $tax->labels->singular_name ), esc_html( single_term_title( '', false ) ) ) . $after; break;
        }
    }
    
    # convert string to slug
    static function slugify( $string = '' ) {
        return sanitize_title( $string );
    }
    
    static function load_more_btn( $output ) {
        
        $next_link = get_next_posts_link( '', $output->max_num_pages );
        if ( ! empty( $next_link ) ) {
            preg_match_all('/href="([^\s"]+)/', $next_link, $match);
            $next_url = $match[1][0];
        }
        echo '<div class="bw-load-more bw-no-select" data-page-load="' . esc_url( $next_url ) . '">';
        if ( isset( $next_url ) and ! empty( $next_url ) ) {
            echo '<div class="bw-load-more-btn">'.
                '<i class="fa fa-refresh"></i>' . esc_html__( 'Load more', 'midnight' ) . ''.
            '</div>';
        }
        echo '</div>';
        
    }
    
    static function bwpb_active() {
        return class_exists( 'Bwpb' ) and Bwpb::bw_check_status();
    }
    
    static function container_class( $class = '' ) {
        $output = $class;
        if( self::bwpb_active() ) {
            return;
        }else{
            $output = ' bw-row';
            $page_layout = Bw::get_meta('page_layout');
            if( ! ( $page_layout == 'full' or empty( $page_layout ) ) ) { $output .= ' bw-has-sidebar'; }
        }
        return $output;
    }
    
    static function icart() {
        if( self::$hver == 'v1' ) {
            if( Bw::float_option('enable_hv1_dark') ) {
                return 'white';
            }
        }elseif( self::$hver == 'v2' ) {
            return 'white';
        }elseif( self::$hver == 'v3' ) {
            if( Bw::float_option('header_hv3_transparent') ) {
                return 'white';
            }
            return 'black';
        }
        return 'black';
    }
    
    static function iwish() {
        if( self::$hver == 'v1' ) {
            if( Bw::float_option('enable_hv1_dark') ) {
                return 'white';
            }
        }elseif( self::$hver == 'v2' ) {
            if( ! Bw::float_option('sticky_header') and Bw::get_meta('header_hv2_transparent') ) {
                return 'white';
            }
            if( Bw::float_option('sticky_header') and Bw::float_option('enable_hv2_dark') ) {
                return 'white';
            }
            return 'black';
        }elseif( self::$hver == 'v3' ) {
            if( Bw::float_option('header_hv3_transparent') ) {
                return 'white';
            }
            return 'black';
        }
        return 'black';
    }
    
    static function imenu() {
        if( Bw::float_option('header_hv3_transparent') ) {
            return 'white';
        }
        return 'black';
    }
    
    static function top_settings_style() {
        $total = self::$hver == 'v3' ? 250 : 200;
        if( ! Bw::get_option('enable_search') ) {
            $total -= 50;
        }
        if( ! Bw::get_option('enable_top_user_login') ) {
            $total -= 50;
        }
        return "width:{$total}px;";
    }
    
    static function avatar( $size = 96, $id = false ) {
        if( ! $id ) {
            global $current_user;
            $current_user = wp_get_current_user();
            $id = $current_user->ID;
        }
        $user_avatar = get_the_author_meta( 'bw_avatar' , $id );
        if( ! empty( $user_avatar ) ) {
            return '<img class="" src="' .  esc_url( $user_avatar ) . '" alt="' . esc_html__('Avatar', 'midnight') . '">';
        }else{
            return get_avatar( $id, $size );
        }
    }
    
}