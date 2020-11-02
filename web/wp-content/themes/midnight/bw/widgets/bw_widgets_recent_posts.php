<?php

/**
 * Extend Recent Posts Widget 
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */

if ( ! class_exists ( 'bw_widgets_recent_posts' ) ) {
    class bw_widgets_recent_posts extends WP_Widget_Recent_Posts {
     
        function widget($args, $instance) {
            
            extract( $args );
            
            $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Recent Posts', 'midnight') : $instance['title'], $instance, $this->id_base);
            
            if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 10;
            }
            
            $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
            if( $r->have_posts() ) :
                
                echo $before_widget;
                
                if( $title ) echo $before_title . $title . $after_title; ?>
                <ul class="bw-sidebar-posts">
                    <?php while( $r->have_posts() ) : $r->the_post(); ?>				
                    <li class="<?php if( ! has_post_thumbnail() ) { echo 'auto'; } ?>">
                        
                        <?php if( has_post_thumbnail() ): ?>
                        <div class="bw-thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                
                                <?php if( Bw::get_option('enable_lazy_image') ): ?>
                                    <img class="lazy" src="<?php echo Bw::get_image_src( 'thumbnail' ); ?>" alt="" >
                                <?php else: ?>
                                    <img src="<?php echo Bw::get_image_src( 'thumbnail' ); ?>" alt="" >
                                <?php endif; ?>
                                
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <div class="bw-cont bw-table <?php if( !has_post_thumbnail() ) { echo ' no-thumb'; } ?>">
                            <div class="bw-cell">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php the_title(); ?>
                                </a>
                                <span class="bw-date"><?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                        
                    </li>
                    <?php endwhile; ?>
                </ul>
                 
                <?php
                echo $after_widget;
            
            wp_reset_postdata();
            
            endif;
        }
    }
}