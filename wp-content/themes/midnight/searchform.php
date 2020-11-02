<form method="get" class="bw-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="bw-search-form-inner">
        <input type="text" class="bw-search-field" value="" placeholder="<?php esc_html_e('Search here...', 'midnight'); ?>" name="s" />
        <?php if( Bw::get_option('shop_search_enabled') ): ?><input type="hidden" name="post_type" value="product" /><?php endif; ?>
        <button type="submit" class="bw-search-submit"><?php esc_html_e('Search', 'midnight'); ?></button>
    </div>
</form>