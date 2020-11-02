<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>

<?php $classes = 'article' . ( has_post_thumbnail() ? " thumb" : " no-thumb" ); ?>

<article <?php post_class( $classes ); ?>>
	
	<div class="article-header">
		<a href="<?php the_permalink(); ?>">
			<div class="article-thumb">
                
                <?php if( has_post_thumbnail() ): ?>
                    <div class="image-wrap"><?php the_post_thumbnail('bw_350x300'); ?></div>
                <?php endif; ?>
                
                <span class="over"></span>
                
                <?php echo Bw::get_format_icon(); ?>
                
                <?php echo Bw::get_rate(); ?>
				
			</div>
		</a>
		
	</div>
	
	<div class="article-content">
		
		<div class="article-title">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		</div>
		
		<div class="cat-tags-list">
            <?php $grid_date = get_the_date(); ?>
            <?php $grid_category = get_the_category_list(', '); ?>
            <?php $grid_separator = ( !empty( $grid_date ) and !empty( $grid_category ) ) ? ' / ' : ''; ?>
            <?php echo "{$grid_date}{$grid_separator}{$grid_category}"; ?>
		</div>
		
		<?php the_excerpt(); ?>
		
	</div>

</article> <!-- .article -->