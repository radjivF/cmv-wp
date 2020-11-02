<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

the_content();

?>

<?php if ( $info = cmv_get_option( 'product_info' ) ) : ?>
	<div class="b-product-info">
		<?php echo wpautop( $info ); ?>
	</div>
<?php endif; ?>
