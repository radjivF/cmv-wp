<?php
/**
 * The Sidebar containing the main widget areas.
 */
?>

<div class="bw-sidebar">
    
	<?php if ( is_active_sidebar( 'sidebar' ) ) :  ?>

		<?php dynamic_sidebar( 'sidebar' ); ?>

	<?php endif; ?>
    
</div> <!-- .bw-sidebar -->
