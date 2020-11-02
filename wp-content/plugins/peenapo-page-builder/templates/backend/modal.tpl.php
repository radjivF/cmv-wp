<?php
echo "<div class='bwpb-modal-content'>";
echo "<div class='modal-subcontent'>";
echo "<ul class='bwpb-ele-categories'>";
$cat_array = array();
foreach( Bwpb_map::$shortcodes as $key => $shortcode ) {
    if( isset( $shortcode['category'] ) and ! array_key_exists( $shortcode['category'], $cat_array ) ) {
        $cat_array[ $shortcode['category'] ] = uniqid() . '-' . rand( 1000, 9999 );
        $active = $key == 0 ? 'class="active"' : '';
        $icon = isset( Bwpb::$global['cat_icons'][ $shortcode['category'] ] ) ? "<i class='" . Bwpb::$global['cat_icons'][ $shortcode['category'] ] . "'></i>" : '<i class="fa fa-circle"></i>';
        echo "<li {$active} data-filter='.cat-" . $cat_array[ $shortcode['category'] ] . "'>{$icon}{$shortcode['category']}</li>";
    }
}
echo "</ul>";
echo "<div class='bwpb-helper-links'>&copy; Peenapo Page Builder, by <a target='_blank' href='http://themeforest.net/user/Peenapo/portfolio?ref=Peenapo'>Peenapo</a>. <a target='_blank' href='#'>User guide</a>, <a target='_blank' href='http://docs.bwdesk.com/peenapo-page-builder/'>Developers</a></div>";
echo "</div>";
echo "<ul class='bwpb-elements no-selection'>";
foreach( Bwpb_map::$shortcodes as $shortcode ) {
    $shortcode['view'] = isset( $shortcode['view'] ) ? $shortcode['view'] : 'block';
    if( $shortcode['view'] !== 'column' ) {
        $cat = ( isset( $shortcode['category'] ) and isset( $cat_array[ $shortcode['category'] ] ) ) ? 'cat-' . $cat_array[ $shortcode['category'] ] : '';
        $parent = isset( $shortcode['container_parent'] ) ? " data-parent='{$shortcode['container_parent']}'" : '';
        $children = isset( $shortcode['container_child'] ) ? ' data-children="' . self::get_children( $shortcode['container_child'] ) . '"' : '';
        $tpl_desc = isset( $shortcode['description'] ) ? "<span class='element-description'>{$shortcode['description']}</span>" : '';
        echo "<li data-module='{$shortcode['base']}'{$parent}{$children} class='{$cat}'>".
            "<div class='element-icon'><i class='bwpb-icon {$shortcode['icon']}'></i></div>".
            "<div class='element-content'>".
                "<h4 class='element-label'>{$shortcode['name']}</h4>".
                $tpl_desc.
            "</div>".
        "</li>";
    }
}
echo "</ul>";
echo "</div>";