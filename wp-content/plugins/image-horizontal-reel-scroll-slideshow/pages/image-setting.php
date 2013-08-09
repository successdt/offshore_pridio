<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo WP_Ihrss_TITLE; ?></h2>
	<h3>Widget setting</h3>
    <?php
	$Ihrss_title = get_option('Ihrss_title');
	$Ihrss_sliderwidth = get_option('Ihrss_sliderwidth');
	$Ihrss_sliderheight = get_option('Ihrss_sliderheight');
	$Ihrss_slidespeed = get_option('Ihrss_slidespeed');
	$Ihrss_slidebgcolor = get_option('Ihrss_slidebgcolor');
	$Ihrss_slideshowgap = get_option('Ihrss_slideshowgap');
	$Ihrss_random = get_option('Ihrss_random');
	$Ihrss_type = get_option('Ihrss_type');
	
	if (@$_POST['Ihrss_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('Ihrss_form_setting');
			
		$Ihrss_title = stripslashes($_POST['Ihrss_title']);
		$Ihrss_sliderwidth = stripslashes($_POST['Ihrss_sliderwidth']);
		$Ihrss_sliderheight = stripslashes($_POST['Ihrss_sliderheight']);
		$Ihrss_slidespeed = stripslashes($_POST['Ihrss_slidespeed']);
		$Ihrss_slidebgcolor = stripslashes($_POST['Ihrss_slidebgcolor']);
		$Ihrss_slideshowgap = stripslashes($_POST['Ihrss_slideshowgap']);
		$Ihrss_random = stripslashes($_POST['Ihrss_random']);
		$Ihrss_type = stripslashes($_POST['Ihrss_type']);

		update_option('Ihrss_title', $Ihrss_title );
		update_option('Ihrss_sliderwidth', $Ihrss_sliderwidth );
		update_option('Ihrss_sliderheight', $Ihrss_sliderheight );
		update_option('Ihrss_slidespeed', $Ihrss_slidespeed );
		update_option('Ihrss_slidebgcolor', $Ihrss_slidebgcolor );
		update_option('Ihrss_slideshowgap', $Ihrss_slideshowgap );
		update_option('Ihrss_random', $Ihrss_random );
		update_option('Ihrss_type', $Ihrss_type );
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/image-horizontal-reel-scroll-slideshow/pages/setting.js"></script>
    <form name="Ihrss_form" method="post" action="">
      <label for="tag-title">Enter widget title</label>
      <input name="Ihrss_title" id="Ihrss_title" type="text" value="<?php echo $Ihrss_title; ?>" size="80" />
      <p>Enter widget title, Only for widget.</p>
      
	  <label for="tag-width">Enter width</label>
      <input name="Ihrss_sliderwidth" id="Ihrss_sliderwidth" type="text" value="<?php echo $Ihrss_sliderwidth; ?>" />
      <p>Enter widget width, only number. (Example: 600)</p>
      
	  <label for="tag-height">Enter height</label>
      <input name="Ihrss_sliderheight" id="Ihrss_sliderheight" type="text" value="<?php echo $Ihrss_sliderheight; ?>" />
      <p>Enter widget height, only number. (Example: 170)</p>
      
	  <label for="tag-title">Enter slide speed</label>
      <input name="Ihrss_slidespeed" id="Ihrss_slidespeed" type="text" value="<?php echo $Ihrss_slidespeed; ?>" />
      <p>This box is to manage scroller speed. (Example: 1)</p>
      
	  <label for="tag-height">Enter slide bgcolor</label>
      <input name="Ihrss_slidebgcolor" id="Ihrss_slidebgcolor" type="text" value="<?php echo $Ihrss_slidebgcolor; ?>" />
      <p>Background color of the slideshow. (Example: #ffffff)</p>
      
	  <label for="tag-height">Enter slideshow gap</label>
      <input name="Ihrss_slideshowgap" id="Ihrss_slideshowgap" type="text" value="<?php echo $Ihrss_slideshowgap; ?>" />
      <p>This is pixels gap between each image in slideshow. (Example: 5)</p>
	  
	  <label for="tag-height">Enter random display</label>
      <input name="Ihrss_random" id="Ihrss_random" type="text" value="<?php echo $Ihrss_random; ?>" />
      <p>This option is to retrieve the images in random order. (Enter: Yes/No Only)</p>
	  
	  <label for="tag-height">Select gallery group (Type)</label>
      <!--<input name="Ihrss_type" id="Ihrss_type" type="text" value="<?php //echo $Ihrss_type; ?>" />-->
	  <select name="Ihrss_type" id="Ihrss_type">
	  <?php
		$sSql = "SELECT distinct(Ihrss_type) as Ihrss_type FROM `".WP_Ihrss_TABLE."` order by Ihrss_type";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$thisselected = "";
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		foreach ($myDistinctData as $DistinctData)
		{
			if(strtoupper($DistinctData['Ihrss_type']) == strtoupper($Ihrss_type)) 
			{ 
				$thisselected = "selected='selected'" ; 
			}
			?><option value='<?php echo strtoupper($DistinctData['Ihrss_type']); ?>' <?php echo $thisselected; ?>><?php echo strtoupper($DistinctData['Ihrss_type']); ?></option><?php
			$thisselected = "";
		}
		?>
		</select>
      <p>This field is to group the images. Select your group name to fetch the images for widget. (Example: GROUP1)</p>
	  <p class="submit">
		<input name="Ihrss_submit" id="Ihrss_submit" class="button" value="Submit" type="submit" />&nbsp; 
		<input name="publish" lang="publish" class="button" onclick="Ihrss_redirect()" value="Cancel" type="button" />&nbsp;
		<input name="Help" lang="publish" class="button" onclick="Ihrss_help()" value="Help" type="button" />
	 </p>
	  <?php wp_nonce_field('Ihrss_form_setting'); ?>
    </form>
  </div>
  <p class="description"><?php echo WP_Ihrss_LINK; ?></p>
</div>
