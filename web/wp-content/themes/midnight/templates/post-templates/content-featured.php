<?php if(get_post_format() == 'image'): ?>
<div class="post-featured">
	
	<?php the_post_thumbnail( Bw::get_meta( 'bw_full_width_featured' ) ? 'bw_980x600' : 'bw_700' ); ?>
	<?php get_template_part( 'templates/post-templates/image-source' ); ?>
	
</div>
<?php endif ?>

<?php if( get_post_format() == 'video' && Bw::get_meta( 'embed_code' ) ): ?>
<div class="post-embed aspect">
	<?php echo do_shortcode( Bw::get_meta('embed_code') ); ?>
</div>
<?php endif; ?>

<?php if(get_post_format() == 'gallery'): ?>
	
	<?php
	$slider_options = 'fade';
	$slider_effect = Bw::get_meta('slider_effect') ? Bw::get_meta('slider_effect') : false;
	if(Bw::get_meta_checkbox('auto_height')) { $slider_options .= ' auto-height'; }
	if(Bw::get_meta_checkbox('auto_play')) { $slider_options .= ' auto-play'; }
	if(Bw::get_meta_checkbox('hide_nav')) { $slider_options .= ' hide-nav'; }
	?>
	
	<?php if( Bw::get_meta('bw_gallery') ): ?>
	<div class="bw-slider-holder gallery">
		<ul class="post-gallery bw-slider slider-pagination <?php echo esc_attr( $slider_options ); ?>" data-effect="<?php echo esc_attr( $slider_effect ); ?>">
		<?php foreach(Bw::gallerize_by_id( Bw::get_meta('bw_gallery'), Bw::get_meta_checkbox('auto_height') ? 'bw_700' : 'bw_980x600' ) as $image): ?>
			<li class="item">
				<div class="article-thumb">
					<img src="<?php echo esc_html( $image['thumb'][0] ) ?>" alt="">
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	
	<?php endif; ?>
	
<?php endif ?>