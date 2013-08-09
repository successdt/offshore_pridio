<?php
/*
Plugin Name: Banner Widget
Plugin URI: http://www.basvanderlans.nl/wordpress/banner-widget-to-promote-posts-and-pages
Description: The Banner Widget. Links Featured Images To Posts And Pages. Use me to promote your <a href="http://www.salespress.org">Products</a>, Workshops &amp; Content.
Author: Bas van der Lans
Version: 0.1
Author URI: http://www.basvanderlans.nl
*/

/**
 * Banner Widget Class
 */
 
class BannerWidget extends WP_Widget {
    /** constructor */
    function BannerWidget() {
        parent::WP_Widget(false, $name = 'Banner to Post or Page');	
    }

    /** @see WP_Widget::widget */
	function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $banner_to_id = apply_filters('widget_title', $instance['banner_to_id']);
        $banner_width = apply_filters('widget_title', $instance['banner_width']);
        $banner_height = apply_filters('widget_title', $instance['banner_height']);
        ?>
		<?php echo $before_widget; ?>
			<?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
				<a href="<?php echo get_permalink( $banner_to_id ); ?>"><?php echo get_the_post_thumbnail( $id = $banner_to_id, array( $banner_width,$banner_height ) ); ?></a>
			<?php echo $after_widget; ?>
		<?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {	
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['banner_to_id'] = strip_tags($new_instance['banner_to_id']);
		$instance['banner_width'] = strip_tags($new_instance['banner_width']);
		$instance['banner_height'] = strip_tags($new_instance['banner_height']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
        $banner_to_id = esc_attr($instance['banner_to_id']);
        $banner_width = esc_attr($instance['banner_width']);
        $banner_height = esc_attr($instance['banner_height']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('banner_to_id'); ?>"><?php _e('Link <strong>Banner</strong> to ID (<strong>Post</strong> or <strong>Page</strong>) *:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('banner_to_id'); ?>" name="<?php echo $this->get_field_name('banner_to_id'); ?>" type="text" value="<?php echo $banner_to_id; ?>" /></label></p>
			<p>Banner Size:<br />
				<label for="<?php echo $this->get_field_id('banner_width'); ?>"><input id="<?php echo $this->get_field_id('banner_width'); ?>" name="<?php echo $this->get_field_name('banner_width'); ?>" type="text" value="<?php echo $banner_width; ?>" size="3" /> <?php _e('width'); ?></label>
				<label for="<?php echo $this->get_field_id('banner_height'); ?>"><input id="<?php echo $this->get_field_id('banner_height'); ?>" name="<?php echo $this->get_field_name('banner_height'); ?>" type="text" value="<?php echo $banner_height; ?>" size="3" /> <?php _e('height'); ?></label></p>
			<p><small>This Widget will display the <strong>Featured Image</strong> as Banner. She's Clickable and will link to the <strong>Post</strong> or <strong>Page</strong>.</small></p>
			<!-- SEO Responsible --><!-- Use me. To promote workshops, products and more. -->
        <?php 
	}

} // class BannerWidget

// register BannerWidget widget
add_action('widgets_init', create_function('', 'return register_widget("BannerWidget");'));

?>