<?php

if ( ! class_exists ( 'bw_widgets_recent_posts_slider' ) ) {
    class bw_widgets_recent_posts_slider extends WP_Widget {
     
        function __construct() {
            parent::__construct(
                'bw_slider_widget', // Base ID
                esc_html__('BW Recent Posts Slider', 'midnight'), // Name
                array( 'description' => esc_html__( 'BW slider widget', 'midnight' ), ) // Args
            );
        }
        
        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );

            echo $args['before_widget'];
            
            if ( !empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            
            $category = $instance['category'];
            $unserialized_categories = unserialize($category);
            $cat_string = is_array($unserialized_categories) ? join(',', $unserialized_categories) : '';
            $max_posts = (int)$instance['max_posts'];
            $autoplay = (int)$instance['autoplay'];
            
            // the query
            $q = new WP_Query(
                array(
                    'orderby' => 'date',
                    'posts_per_page' => ($max_posts > 0 && $max_posts <= 10) ? $max_posts : 5,
                    'category__in' => $unserialized_categories,
                    'meta_key'    => '_thumbnail_id',
                )
            );
            
            $data  = ' data-slides="1" data-autoheight="true" data-loop="true" data-nav="true"';
            $data .= ( $autoplay ? 'data-autoplay="true" ' : '' );
            
            
            $list = '<div class="bw-widget-slider bw-slider" ' . $data . '>';
            
            while($q->have_posts()) : $q->the_post();
                
                ob_start();
                echo "<div>";
                echo "<div class='gallery_banner'>";
                echo "<div class='image'>
                    <a href='" . get_permalink() . "'>
                        <img src='" . Bw::get_image_src( 'bw_370x269' ) . "' alt=''>
                    </a>
                </div>
                <div class='description'>
                    <a href='" . get_permalink() . "'>" . get_the_title() . "</a>
                </div>
                <div class='links'>";
                
                $comments = get_comments_number() ? "<li><span><img src='" . BW_URI_ASSETS . "img/bubble.png' alt=''></span><em><strong>" . get_comments_number() . "</strong></em></li>" : '';
                $camera = '';
                $add_class = 'bar_info_no_camera';
                
                if( get_post_format() == 'gallery' ) {
                    $gallery = Bw::get_meta('bw_gallery');
                    if( isset( $gallery['ids'] ) and !empty( $gallery['ids'] ) ) {
                        $camera_count = count( array_filter( explode( ',', $gallery['ids'] ) ) );
                        $camera = "<li><a href=''><span>{$camera_count}</span><img src='" . BW_URI_ASSETS . "img/camera.png' alt=''></a></li>";
                        $add_class = '';
                    }
                }
                
                $eye = Bw::get_option('enable_post_views') ? "<li><span><img src='" . BW_URI_ASSETS . "img/eye.png' alt=''></span><em><strong>" . Bw::get_post_views() . "</strong></em></li>" : '';
                
                echo "<div class='bar_info {$add_class}'>
                    <ul>
                        {$camera}
                        <li><span><img src='" . BW_URI_ASSETS . "img/clock.png' alt=''></span><em>" . get_the_date() . "</em></li>
                        {$comments}
                        {$eye}
                    </ul>
                </div>";
                
                echo "</div>";
                echo "</div>";
                echo "</div>";
                
                $list .= ob_get_clean();

            endwhile;

            wp_reset_postdata();
            
            $list .= "</div>";
            
            echo $list;
            
            echo $args['after_widget'];
        }
        
        public function form( $instance ) {
            
            $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
            $max_posts = isset( $instance[ 'max_posts' ] ) ? $instance[ 'max_posts' ] : '';
            $category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
            $autoplay = isset( $instance[ 'autoplay' ] ) ? $instance[ 'autoplay' ] : '';
            
            ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'midnight' ); ?></label> 
            <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            
            <p>
            <label for="<?php echo $this->get_field_id( 'max_posts' ); ?>"><?php esc_html_e( 'Number of posts (between 1 and 10):', 'midnight' ); ?></label> 
            <input class="widefat" name="<?php echo $this->get_field_name( 'max_posts' ); ?>" type="text" value="<?php echo esc_attr( $max_posts ); ?>">
            </p>
            
            <!--input class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo esc_attr( $category ); ?>"-->
            
            <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category (leave empty for all categories):', 'midnight' ); ?></label> 
            <?php $unserilized_category = is_array(unserialize( $category )) ? unserialize( $category ) : array(); ?>
            <?php $categories = get_categories(  ); ?>
            <select name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple" style="width:100%;" >
                <?php foreach($categories as $key => $category): ?>
                    <option value="<?php echo $category->cat_ID; ?>" <?php if( in_array($category->cat_ID, $unserilized_category) ) { echo 'selected="selected"'; } ?>><?php echo $category->name; ?></option>
                <?php endforeach; ?>
            </select>
            </p>
            
            <p>
            <input class="widefat" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" type="checkbox" value="1" <?php if(esc_attr($autoplay) == 1) {echo 'checked="checked"';}?>>
            <span>Autoplay</span>
            </p>
            
            <?php 
        }
        
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['max_posts'] = ( ! empty( $new_instance['max_posts'] ) ) ? strip_tags( $new_instance['max_posts'] ) : '';
            $instance['category'] = serialize($new_instance['category']);
            $instance['autoplay'] = ( ! empty( $new_instance['autoplay'] ) ) ? strip_tags( $new_instance['autoplay'] ) : '';

            return $instance;
        }
    }
}