<?php if( get_field('enable_image_source') ): ?>
<?php if( get_field('image_src_url') ): ?><a href="<?php echo esc_url( get_field('image_src_url') ); ?>" target="_blank"><?php endif; ?>
	<i class="image-source"><?php echo esc_html( get_field('image_src_label') ); ?></i>
<?php if( get_field('image_src_url') ): ?></a><?php endif; ?>
<?php endif; ?>