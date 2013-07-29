<?php
/**
 * The template for displaying the footer.
 *
 * @package Doover
 * @author Muffin group
 * @link http://muffingroup.com
 */
?>
	
<!-- Footer -->
<footer id="Footer">
	<div class="Wrapper">
	
		<?php get_sidebar( 'footer' ); ?>
		
		<div class="row clearfix">
			
			<div class="two_third col">
				
				<div class="copyrights">
					<p class="author">&copy; <?php echo date( 'Y' ); ?> <span><?php bloginfo( 'name' ); ?></span>. <?php _e('All Rights Reserved. Powered by','doover'); ?> <a href="http://wordpress.org">WordPress</a>.</p>
					<p><?php _e('Created by','doover'); ?> <a href="http://muffingroup.com">Muffin group</a>.</p>
				</div>
				
			</div>
			
			<div class="one_third col last">
				<a class="back_to_top" href="#" title="<?php _e('Back to top','doover'); ?>"><?php _e('Back to top','doover'); ?></a>
			</div>
								
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
	
</body>
</html>