<?php

require_once( ABSPATH . 'wp-admin/includes/nav-menu.php' );

if ( !class_exists( "Bw_walker_nav_menu_edit" ) && class_exists( 'Walker_Nav_Menu_Edit' ) && Bw_megamenu::$enable ):

class Bw_walker_nav_menu_edit extends Walker_Nav_Menu_Edit {
    
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        
        global $_wp_nav_menu_max_depth;
        
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
    
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    
        ob_start();
        $item_id = (int)$item->ID;
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );
    
        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }
    
        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );
    
        $title = $item->title;
    
        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( esc_html__( '%s (Invalid)', 'midnight' ), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( esc_html__('%s (Pending)', 'midnight'), $item->title );
        }
    
        $title = empty( $item->label ) ? $title : $item->label;
        
        ?>
        <li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><?php echo esc_html( $title ); ?></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up"><abbr>&#8593;</abbr></a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down"><abbr>&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo $item_id; ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>"><?php esc_html_e( 'Edit Menu Item', 'midnight' ); ?></a>
                    </span>
                </dt>
            </dl>
    
            <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                <?php if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                            <?php esc_html_e( 'URL', 'midnight' ); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Navigation Label', 'midnight' ); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Title Attribute', 'midnight' ); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php esc_html_e( 'Open link in a new window/tab', 'midnight' ); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'CSS Classes (optional)', 'midnight' ); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Link Relationship (XFN)', 'midnight' ); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Description', 'midnight' ); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'midnight'); ?></span>
                    </label>
                </p>        
                <?php
                /* New fields insertion starts here */
                if( $depth == 0 and ( $item->object == 'product_cat' ) ):
                ?>
                <p class="field-custom description description-wide">
                    <label for="edit-menu-item-bwmegamenu-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Megamenu Layout', 'midnight' ); ?><br />
                        <select class="widefat edit-menu-item-description" name="menu-item-bwmegamenu[<?php echo $item_id; ?>]" id="edit-menu-item-bwmegamenu-<?php echo $item_id; ?>">
                            <option value="">Default</option>
                            <option value="supermenu" <?php echo ( $item->bwmegamenu == 'supermenu' ) ? 'selected' : ''; ?>>Supermenu</option>
                            <option value="supermenu_featured" <?php echo ( $item->bwmegamenu == 'supermenu_featured' ) ? 'selected' : ''; ?>>Supermenu with featured product</option>
                            <option value="flyout" <?php echo ( $item->bwmegamenu == 'flyout' ) ? 'selected' : ''; ?>>Flyout menu</option>
                            <option value="flyout_featured" <?php echo ( $item->bwmegamenu == 'flyout_featured' ) ? 'selected' : ''; ?>>Flyout menu with featured product</option>
                        </select>
                    </label>
                </p>
                <?php
                elseif( $depth == 0 and ( 'custom' == $item->object or 'page' == $item->object ) ):
                ?>
                <p class="field-custom description description-wide">
                    <label for="edit-menu-item-bwmegamenu-<?php echo $item_id; ?>">
                        <?php esc_html_e( 'Megamenu Layout', 'midnight' ); ?><br />
                        <select class="widefat edit-menu-item-description" name="menu-item-bwmegamenu[<?php echo $item_id; ?>]" id="edit-menu-item-bwmegamenu-<?php echo $item_id; ?>">
                            <option value="">Default</option>
                            <option value="supermenu" <?php echo ( $item->bwmegamenu == 'supermenu' ) ? 'selected' : ''; ?>>Supermenu</option>
                            <?php if( get_page_template_slug( $item->object_id ) == 'page-shop.php' ): ?>
                                <option value="supermenu_featured" <?php echo ( $item->bwmegamenu == 'supermenu_featured' ) ? 'selected' : ''; ?>>Supermenu with featured product</option>
                                <option value="flyout" <?php echo ( $item->bwmegamenu == 'flyout' ) ? 'selected' : ''; ?>>Flyout menu</option>
                            <option value="flyout_featured" <?php echo ( $item->bwmegamenu == 'flyout_featured' ) ? 'selected' : ''; ?>>Flyout menu with featured product</option>
                            <?php endif; ?>
                        </select>
                    </label>
                </p>
                <?php
                endif;
                /* New fields insertion ends here */
                ?>
                <div class="menu-item-actions description-wide submitbox">
                    <?php if( 'custom' != $item->object && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( esc_html__('Original: %s', 'midnight'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php esc_html_e('Remove', 'midnight'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                        ?>#menu-item-settings-<?php echo $item_id; ?>"><?php esc_html_e('Cancel', 'midnight'); ?></a>
                </div>
    
                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        <?php
        
        $output .= ob_get_clean();

    }
}

endif;