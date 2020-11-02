<?php
/**
 * The Sidebar containing the main widget areas.
 */
?>

<div class="bw-sidebar bw-sidebar-shop">
    
	<?php if ( is_active_sidebar( 'sidebar_shop' ) ) :  ?>

		<?php dynamic_sidebar( 'sidebar_shop' ); ?>

	<?php endif; ?>
    
</div> <!-- .bw-sidebar -->
