<?php

class Bw_megamenu {
    
    static $enable = true;
    
    static function init() {
        
        if( self::$enable == false and is_admin() ) { return; }
        
        # provide another admin menu walker class.
        add_action( 'wp_edit_nav_menu_walker', array('Bw_megamenu', 'bw_edit_nav_menu_walker') , 10, 2 );
        # add custom menu fields to menu
        add_filter( 'wp_setup_nav_menu_item', array('Bw_megamenu', 'bw_add_nav_menu_fields'), 10, 2 );
        # save menu custom fields
        add_action( 'wp_update_nav_menu_item', array('Bw_megamenu', 'bw_update_nav_menu_item'), 10, 3 );
        
    }
    
    static function bw_edit_nav_menu_walker( $walker ) {
        if ( $walker == 'Walker_Nav_Menu_Edit' ) {
            $walker = 'Bw_walker_nav_menu_edit';
        }
        return $walker;
    }
    
    static function bw_add_nav_menu_fields( $menu_item ) {

        $menu_item->bwmegamenu = get_post_meta( $menu_item->ID, 'bw_megamenu_layout', true );
        return $menu_item;

    }
    
    static function bw_update_nav_menu_item( $menu_id, $menu_item_id, $args ) {
        if ( isset( $_POST['menu-item-bwmegamenu'][$menu_item_id] ) ) {
            update_post_meta( $menu_item_id, 'bw_megamenu_layout', $_POST['menu-item-bwmegamenu'][$menu_item_id] );
        }else{
            delete_post_meta( $menu_item_id, 'bw_megamenu_layout' );
        }
    }
    
    static function main_nav() {
        
        $args = array(
            'theme_location'  => 'primary',
            'menu'            => '',
            'container'       => '',
            'container_id'    => '',
            'menu_class'      => 'menu',
            'menu_id'         => '',
            'fallback_cb'     => 'wp_page_menu',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'walker'          => new Bw_walker_nav_menu()
        );
        
        echo '<div class="bw-navigation ' . ( Bw::$hver == 'v1' ? '' : 'bw-cell' ) . '">';
        if( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( $args );
        }else{
            echo '<a href="' . esc_url( admin_url('nav-menus.php') ) . '" class="bw-add-nav">' . esc_html__('Add menu location', 'midnight') . '</a>';
        }
        echo '</div>';
        
    }
    
}