<?php

require_once( ABSPATH . WPINC . '/nav-menu-template.php' );

if ( !class_exists( "Bw_walker_nav_menu" ) && class_exists( 'Walker_Nav_Menu' ) && Bw_megamenu::$enable ):

class Bw_walker_nav_menu extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $hver = Bw::get_option('heavder_version');
        $output .= ( empty( $hver ) or $hver == 'v1' or $hver == 'v2' ) ? "<div class='bw-sub-menu-holder'>" : '';
        $output .= "<ul class='sub-menu'>";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $output .= "</ul>";
        $hver = Bw::get_option('heavder_version');
        $output .= ( empty( $hver ) or $hver == 'v1' or $hver == 'v2' ) ? "</div>" : '';
    }

    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        
        $id_field = $this->db_fields['id'];
        
        // check whether there are children for the given ID
        $element->hasChildren = isset($children_elements[$element->$id_field]) && !empty($children_elements[$element->$id_field]);
        
        if ( ! empty($children_elements[$element->$id_field])) {
            $element->classes[] = 'menu-item-parent';
        }
        
        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    // add main/sub classes to li's and links
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;

        if (!is_array($args)) {
            $args = (array)$args;
        }

        // depth dependent classes
        $depth_classes = array( 'depth-' . $depth );

        $depth_class_names = esc_attr(implode(' ', $depth_classes));
        
        //lets get the meta associated with the menu item to see what layout to use
        $menu_layout = esc_attr( get_post_meta( $item->ID, 'bw_megamenu_layout', true ) );

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array)$item->classes;
        if ( $depth == 0 && ( $menu_layout == 'supermenu' || $menu_layout == 'supermenu_featured' ) ) {
            $classes[] = 'bw-is-supermega';
        }elseif( $depth == 0 && ( $menu_layout == 'flyout' || $menu_layout == 'flyout_featured' ) ) {
            $classes[] = 'bw-is-flyout';
        }elseif( $depth == 0 && ( empty( $menu_layout ) or $menu_layout == 'default' ) ) {
            $classes[] = 'bw-is-default';
        }
        
        $class_names = esc_attr(implode(' ', apply_filters( 'nav_menu_css_class', array_filter($classes), $item)));

        // build html
        $output .= '<li id="nav-item-'.$item->ID. '" class="nav-item '.$depth_class_names.' '.$class_names.'">';

        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link main_link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
        
        $hver = Bw::float_option('header_version');
        $link_before = ( $hver == 'v2' and $depth == 0 ) ? '<div class="bw-cell">' : '';
        $link_after = ( $hver == 'v2' and $depth == 0 ) ? '</div>' : '';
        
        $item_output = sprintf
            (
                '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                $args['before'],
                $attributes,
                $link_before . $args['link_before'],
                apply_filters( 'the_title', $item->title, $item->ID ),
                $args['link_after'] . $link_after,
                $args['after']
            );
        
        //the supermenu wrapper
        if( $menu_layout == 'supermenu_featured' or $menu_layout == 'flyout_featured' ) {
            $supermenu_class = ' bw-supermenu-featured ';
        }else{
            $supermenu_class = ' ';
        }
        
        if( $depth == 0 && ( $menu_layout == 'supermenu' || $menu_layout == 'supermenu_featured' || $menu_layout == 'supermenu_featured_2' ) ) {
            $item_output .= '<div class="bw-megasuper-holder"><div class="bw-supermenu' . $supermenu_class . 'bw-row">';
        }elseif( $depth == 0 and ( $menu_layout == 'flyout' or $menu_layout == 'flyout_featured' ) ) {
            $item_output .= '<div class="bw-flyout-holder"><div class="bw-flyout' . $supermenu_class . '">';
        }
        
        if( $menu_layout == 'supermenu_featured' || $menu_layout == 'flyout_featured' ) {
            
            $num_products = 1;
            
            $custom_cat_id = $item->object_id;
            if( $item->object == 'page' and $depth == 0 ) {
                if( get_page_template_slug( $item->object_id ) == 'page-shop.php' ) {
                    $custom_cat_id = Bw::get_meta('product_category', $item->object_id);
                }
            }
            
            $post_args = array(
                'post_type'             => 'product',
                'posts_per_page'        => $num_products,
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => true,
                'meta_query'             => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_featured',
                        'value' => 'yes',
                        'compare' => '='
                    )
                ),
                'tax_query'             => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $custom_cat_id,
                        'operator' => 'IN',
                    ),
                )
            );
            
            $featured_product = new WP_Query( $post_args );
            if ( $featured_product->have_posts() ) {
                while ( $featured_product->have_posts() ) { $featured_product->the_post();
                    $item_output .= '<article class="bw-super-featured">';
                    $thumb_img_id = Bw::get_meta('bw_featured_image');
                    $thumb_img_data = wp_get_attachment_image_src( $thumb_img_id, '400x559' );
                    if( isset( $thumb_img_data[0] ) ) {
                        $featured_image = $thumb_img_data[0];
                    }else{
                        $featured_image = Bw::get_image_src( 'shop_catalog', get_the_ID() );
                        if( empty( $featured_image ) ) {
                            $featured_image = Bw::empty_img( '400x559' );
                        }
                    }
                    $_product = wc_get_product( get_the_ID() );
                    $_product_price = str_replace( ',00', '', $_product->get_price_html() );
                    $_product_price_html = ! empty( $_product_price ) ? '<div class="bw-price-label bw-no-pointer bw-pick-small"><div class="bw-table"><div class="bw-cell">' . $_product_price . '</div></div></div>' : '';
                    $item_output .= '<a href="' . get_permalink( $_product->id ) . '" class="bw-super-featured-item">
                        <span class="bw-image" style="background-image:url(' . esc_url( $featured_image ) . ');"></span>
                        <span class="bw-over"></span>
                        ' . $_product_price_html . '
                    </a>';
                    $item_output .= '</article>';
                }
            }else{
                if( $menu_layout == 'supermenu_featured' or $menu_layout == 'flyout_featured' ) {
                    $item_output .= '<div class="bw-super-empty"><p>' . esc_html__('No featured products!', 'midnight') . '</p></div>';
                }
            }
            wp_reset_postdata();
            
            if( $menu_layout == 'supermenu_featured' ) {
                $item_output .= '<div class="bw-super-holder">';
            }
        }
        
        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        
        $menu_layout = esc_attr( get_post_meta( $item->ID, 'bw_megamenu_layout', true ) );
        
        if($depth == 0 && ( $menu_layout == 'supermenu' || $menu_layout == 'supermenu_featured' ) ) {
            $output .= '</div> <!-- bw-supermenu --></div> <!-- bw-super-holder -->';
        }elseif( $depth == 0 && ( $menu_layout == 'flyout' || $menu_layout == 'flyout_featured' ) ) {
            $output .= '</div> <!-- bw-flyout --></div> <!-- bw-flyout-holder -->';
        }
        
        $output .= "</li>";
    }

} # class

endif;