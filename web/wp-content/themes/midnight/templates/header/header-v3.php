<?php
$header_trans = Bw::float_option('header_hv3_transparent');

$hclass = array();

if( $header_trans ) {
    $hclass[] = 'bw-is-transparent';
}

if( Bw::get_option('enable_top_user_login') and ! is_user_logged_in() ) { get_template_part('templates/modal-profile'); }

?>
<header class="bw-header bw-header-v2 bw-header-v3 <?php echo implode( ' ', $hclass ); ?>">
    
    <div class="bw-table">
    
        <div class="bw-logo bw-cell">
            <?php Bw::logo(); ?>
        </div>
        
        <?php //Bw_megamenu::main_nav(); ?>
        <div class="bw-navigation"></div>
        
        <div class="bw-top-settings bw-cell" style="<?php echo esc_attr( Bw::top_settings_style() ); ?>">
            <div class="bw-table">
                <?php get_template_part('templates/header/settings-icons'); ?>
                <?php get_template_part('templates/header/shopping-icons'); ?>
                <div class="bw-setting-icon bw-cell bw-menuicon">
                    <a href="#"></a>
                    <img src="<?php echo BW_URI_ASSETS . 'img/menu_' . Bw::imenu() . '.png'; ?>" alt="">
                </div>
            </div>
        </div>
    
    </div>
    
</header>

<div id="bw-v3m">
    
    <div class="bw-v3m-col">
        <div class="bw-table">
            <div class="bw-cell">
                
                <?php $menu_logo = Bw::get_option('menu_logo'); ?>
                <div class="bw-v3m-logo">
                    <?php if( ! empty( $menu_logo ) ) : ?>
                        <img src="<?php echo esc_url( $menu_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                    <?php else: ?>
                        <h2><?php bloginfo( 'name' ); ?></h2>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="bw-v3m-col bw-v3m-col-middle">
        <div class="bw-table">
            <div class="bw-cell">
                
                <nav class="bw-v3m-navigation">
                    <?php if( has_nav_menu( 'primary' ) ) : ?>
                        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'items_wrap' => '<ul id="%1$s" class="%2$s bw-menu-nav">%3$s</ul>' ) ); ?>
                    <?php else: ?>
                        <p><?php esc_html_e('Please select a menu from Appearance > Menus.', 'midnight'); ?></p>
                    <?php endif; ?>
                </nav>
                
            </div>
        </div>
    </div>
    
    <div class="bw-v3m-col bw-v3m-col-bottom">
        <div class="bw-table">
            <div class="bw-cell">
                
                <?php Bw::go_social(); ?>
                
            </div>
        </div>
    </div>
    
    <span class="bw-v3m-close fa fa-close"></span>
    
</div>