<?php

if ( ! class_exists ( 'bw_widgets_popular_posts' ) ) {
    class bw_widgets_popular_posts extends WP_Widget {
     
        function __construct() {
            parent::__construct(
                'bw_polupal_widget', // Base ID
                esc_html__('BW Popular Posts', 'midnight'), // Name
                array( 'description' => esc_html__( 'BW Popular posts', 'midnight' ) ) // Args
            );
        }
        
        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );

            echo $args['before_widget'];
            
            if ( !empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            
            $unserialized_categories = unserialize($instance['category']);
            $categories = is_array($unserialized_categories) ? $unserialized_categories : array();
            
            $real_times = array();
            foreach($categories as $rt) {
                
                if( term_exists( (int)$rt, 'category' ) ) {
                    
                    $real_times[] = $rt;
                }
            }
            
            echo '<div class="bw-polular-widget-holder">';
            
            // time navigation
            if(count($real_times) > 0) {
                
                if(count($real_times) > 1) {
                    echo '<ul class="fast_links">'; 
                    $nav_c = 0;
                    foreach( $real_times as $time ) {
                        $class = ($nav_c == 0) ? 'class="active"' : '';
                        $get_cat = get_category($time);
                        echo '<li ' . $class . '><a href="#" data-parent="' . trim($time) . '">' . $get_cat->name . '</a></li>';
                        $nav_c++;
                    }
                    echo '</ul>';
                }
                
                foreach( $real_times as $time ) {
                    $this->query_by_id($time, $instance);
                    
                }
            }else{
                
                $this->query_by_id('bw-all-time', $instance);
                
            }
            
            echo '</div>';
            
            echo $args['after_widget'];
        }
        
        public function form( $instance ) {
            
            $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
            $max_posts = isset( $instance[ 'max_posts' ] ) ? $instance[ 'max_posts' ] : '';
            $category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
            
            ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'midnight' ); ?></label> 
            <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            
            <p>
            <label for="<?php echo $this->get_field_id( 'max_posts' ); ?>"><?php esc_html_e( 'Number of posts (between 1 and 10):', 'midnight' ); ?></label> 
            <input class="widefat" name="<?php echo $this->get_field_name( 'max_posts' ); ?>" type="text" value="<?php echo esc_attr( $max_posts ); ?>">
            </p>
            
            <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Categories (leave empty for all categories):', 'midnight' ); ?></label>
            <!--input class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo esc_attr( $category ); ?>"-->
            
            <?php $unserilized_category = is_array(unserialize( $category )) ? unserialize( $category ) : array(); ?>
            <?php $categories = get_categories(  ); ?>
            <select name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple" style="width:100%;" >
                <?php foreach($categories as $key => $category): ?>
                    <option value="<?php echo $category->cat_ID; ?>" <?php if( in_array($category->cat_ID, $unserilized_category) ) { echo 'selected="selected"'; } ?>><?php echo $category->name; ?></option>
                <?php endforeach; ?>
            </select>
            
            </p>
            
            <?php 
        }
        
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['max_posts'] = ( ! empty( $new_instance['max_posts'] ) ) ? strip_tags( $new_instance['max_posts'] ) : '';
            $instance['category'] = serialize($new_instance['category']);

            return $instance;
        }
        
        public function query_by_id($time, $instance) {
            
            global $wpdb;
            global $post;
            
            $limit = ((int)$instance['max_posts'] > 0 && (int)$instance['max_posts'] <= 10) ? (int)$instance['max_posts'] : 5;
            
            //$categories = unserialize( $instance['category'] );
            //$joined_categories = is_array( $categories ) ? join( ',', $categories ) : null;
            
            
            if ( $time !== 'bw-all-time' && $time > 0 ) {
                
                $joins = "
                    LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
                    LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
                    LEFT JOIN $wpdb->terms ON($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
                ";
                $where = "
                    AND $wpdb->term_taxonomy.taxonomy = 'category'
                    AND $wpdb->terms.term_id  = '" . $time . "'
                ";
            }else{
                $joins = '';
                $where = '';
            }
            $querystr = "
                
                SELECT *, CAST( $wpdb->posts.post_date AS DATE ) as bw_date
                FROM $wpdb->posts
                LEFT JOIN $wpdb->postmeta ON($wpdb->posts.ID = $wpdb->postmeta.post_id)
                    
                    " . $joins . "
                
                WHERE $wpdb->postmeta.meta_key = 'post_views_count'
                AND $wpdb->posts.post_status = 'publish'
                AND $wpdb->posts.post_date < NOW()
                AND $wpdb->posts.post_type = 'post'
                    
                    " . $where . "
                
                ORDER BY bw_date desc, $wpdb->postmeta.meta_value+0 desc
                
                LIMIT " . $limit . "
                
            ";
            
            $pageposts = $wpdb->get_results($querystr, object);
            
            $c = 1;
            
            echo '<div class="top_news top_news_time_' . trim($time) . '"><div class="slides">';
            foreach ( $pageposts as $post ) : setup_postdata( $post );
                
                ?><div class="short_news">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><strong><?php the_title(); ?></strong></a>
                    <?php get_template_part('templates/bar-info'); ?>
                </div><?php
            
            $c++;endforeach; 
            wp_reset_postdata();
            echo '</div></div>';
            
        }
    }
}