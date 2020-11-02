<form role="search" method="get" class="bw-search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
    <div class="bw-search-form-inner">
        <input type="search" class="bw-search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
        <input type="submit" class="bw-search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" />
        <input type="hidden" name="post_type" value="product" />
    </div>
</form>
