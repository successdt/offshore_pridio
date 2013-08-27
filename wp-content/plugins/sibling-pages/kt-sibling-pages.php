<?php
/*
Plugin Name:  Sibling Pages
Plugin URI: http://8thfold.com/plugins/sibling_pages
Description: Generates and registers a widget a list of links to sibling pages (pages that have the same parent page) 
Version: .2
Author: Kenneth Tyler
Author URI: http://8thfold.com
License: GPL2

Copyright 2011  Kenneth Tyler  (email : ken@8thfold.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'widgets_init', 'kt_register_sibling_pages');
add_action( 'wp_print_styles', 'kt_add_stylesheet' );

function kt_register_sibling_pages() {
	register_widget ('kt_sibling_pages');
}

function kt_add_stylesheet() {
    $ktStyleURL = plugins_url('kt-sibling-pages/css/style.css', dirname(__FILE__)); // Respects SSL, Style.css is relative to the current file
    $ktStyleFile = WP_PLUGIN_DIR . '/kt-sibling-pages/css/style.css';
     if ( file_exists($ktStyleFile) ) {
         wp_register_style('kt-sibling-pages-css', $ktStyleURL);
         wp_enqueue_style( 'kt-sibling-pages-css');
     } 
 }
	
class kt_sibling_pages extends WP_Widget{
	
	function kt_sibling_pages(){
			$widget_ops = array(
				'classname' => 'kt_sibling_pages_widget',
				'description' => ' Generate a sidebar list of sibling pages (pages that have the same parent page) in a drop-down menu');
				$this->WP_Widget ('kt_sibling_pages', 'Sibling Pages', $widget_ops);
	}
	
	function form($instance){
		?><h3>This widget has no settings</h3><?php
	}
	
	function update($new_instance, $old_instance){
		# this widget has no settings to update
	}
	
	function widget($args, $instance){
		
		global $post ;
		global $wpdb;		

		if ( is_page() ){
			$children = get_children( array('post_parent' => $post->ID , 'order' => 'ASC') );
		
			if ( count($children)==0 ){
				#  there are no children, check and see if the post is itself a child
					$parent_post_id = $post->post_parent;
				
					if ( $parent_post_id ){
						$parent_post = get_post($parent_post_id);
				
						$querystr = "
						    SELECT $wpdb->posts.* 
						    FROM $wpdb->posts
						    WHERE ($wpdb->posts.post_parent = " . $parent_post_id . " AND $wpdb->posts.post_status = 'publish' 
						    AND $wpdb->posts.post_type = 'page') 
						    ORDER BY $wpdb->posts.post_title";
						 $children = $wpdb->get_results($querystr, OBJECT);
						#add a link to the parent page to the top of the list of child pages
					 	//array_unshift($children, $parent_post);
					}
			} else {
				# there are child pages, add a link to the parent page to the top of the list of child pages
				array_unshift($children, $post);
			}	

			if ( count($children) > 0 ){
				
				?>
				<aside class="widget widget_nav_menu">
					<h5 class="widget-title"><?php echo $parent_post->post_title ?></h5>
					<div class="menu-side-menu-contairner">
						<ul class="menu">
							<?php foreach ($children as $child){ ?>
							<li class="menu-item menu-item-type-taxonomy menu-item-object-category <?php echo ($post->ID == $child->ID) ? 'current_page_item' : '' ?>">
								<a href="<?php echo $child->guid ?>"><?php echo $child->post_title  ?></a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</aside>
				<?php	
			} # else 
		} # count($children)==0
	} # $post->ID
}?>



