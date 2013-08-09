<div class="wrap">
<?php
$Ihrss_errors = array();
$Ihrss_success = '';
$Ihrss_error_found = FALSE;

// Preset the form fields
$form = array(
	'Ihrss_path' => '',
	'Ihrss_link' => '',
	'Ihrss_target' => '',
	'Ihrss_title' => '',
	'Ihrss_order' => '',
	'Ihrss_status' => '',
	'Ihrss_type' => ''
);

// Form submitted, check the data
if (isset($_POST['Ihrss_form_submit']) && $_POST['Ihrss_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('Ihrss_form_add');
	
	$form['Ihrss_path'] = isset($_POST['Ihrss_path']) ? $_POST['Ihrss_path'] : '';
	if ($form['Ihrss_path'] == '')
	{
		$Ihrss_errors[] = __('Please enter the image path.', WP_Ihrss_UNIQUE_NAME);
		$Ihrss_error_found = TRUE;
	}

	$form['Ihrss_link'] = isset($_POST['Ihrss_link']) ? $_POST['Ihrss_link'] : '';
	if ($form['Ihrss_link'] == '')
	{
		$Ihrss_errors[] = __('Please enter the target link.', WP_Ihrss_UNIQUE_NAME);
		$Ihrss_error_found = TRUE;
	}
	
	$form['Ihrss_target'] = isset($_POST['Ihrss_target']) ? $_POST['Ihrss_target'] : '';
	$form['Ihrss_title'] = isset($_POST['Ihrss_title']) ? $_POST['Ihrss_title'] : '';
	$form['Ihrss_order'] = isset($_POST['Ihrss_order']) ? $_POST['Ihrss_order'] : '';
	$form['Ihrss_status'] = isset($_POST['Ihrss_status']) ? $_POST['Ihrss_status'] : '';
	$form['Ihrss_type'] = isset($_POST['Ihrss_type']) ? $_POST['Ihrss_type'] : '';

	//	No errors found, we can add this Group to the table
	if ($Ihrss_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_Ihrss_TABLE."`
			(`Ihrss_path`, `Ihrss_link`, `Ihrss_target`, `Ihrss_title`, `Ihrss_order`, `Ihrss_status`, `Ihrss_type`)
			VALUES(%s, %s, %s, %s, %d, %s, %s)",
			array($form['Ihrss_path'], $form['Ihrss_link'], $form['Ihrss_target'], $form['Ihrss_title'], $form['Ihrss_order'], $form['Ihrss_status'], $form['Ihrss_type'])
		);
		$wpdb->query($sql);
		
		$Ihrss_success = __('New image details was successfully added.', WP_Ihrss_UNIQUE_NAME);
		
		// Reset the form fields
		$form = array(
			'Ihrss_path' => '',
			'Ihrss_link' => '',
			'Ihrss_target' => '',
			'Ihrss_title' => '',
			'Ihrss_order' => '',
			'Ihrss_status' => '',
			'Ihrss_type' => ''
		);
	}
}

if ($Ihrss_error_found == TRUE && isset($Ihrss_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $Ihrss_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($Ihrss_error_found == FALSE && strlen($Ihrss_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $Ihrss_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=image-horizontal-reel-scroll-slideshow">Click here</a> to view the details</strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/image-horizontal-reel-scroll-slideshow/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_Ihrss_TITLE; ?></h2>
	<form name="Ihrss_form" method="post" action="#" onsubmit="return Ihrss_submit()"  >
      <h3>Add new image details</h3>
      <label for="tag-image">Enter image path</label>
      <input name="Ihrss_path" type="text" id="Ihrss_path" value="" size="125" />
      <p>Where is the picture located on the internet</p>
      <label for="tag-link">Enter target link</label>
      <input name="Ihrss_link" type="text" id="Ihrss_link" value="" size="125" />
      <p>When someone clicks on the picture, where do you want to send them</p>
      <label for="tag-target">Enter target option</label>
      <select name="Ihrss_target" id="Ihrss_target">
        <option value='_blank'>_blank</option>
        <option value='_parent'>_parent</option>
        <option value='_self'>_self</option>
        <option value='_new'>_new</option>
      </select>
      <p>Do you want to open link in new window?</p>
      <label for="tag-title">Enter image reference</label>
      <input name="Ihrss_title" type="text" id="Ihrss_title" value="" size="125" />
      <p>Enter image reference. This is only for reference.</p>
      <label for="tag-select-gallery-group">Select gallery type</label>
      <select name="Ihrss_type" id="Ihrss_type">
        <option value='GROUP1'>Group1</option>
        <option value='GROUP2'>Group2</option>
        <option value='GROUP3'>Group3</option>
        <option value='GROUP4'>Group4</option>
        <option value='GROUP5'>Group5</option>
        <option value='GROUP6'>Group6</option>
        <option value='GROUP7'>Group7</option>
        <option value='GROUP8'>Group8</option>
        <option value='GROUP9'>Group9</option>
        <option value='GROUP0'>Group0</option>
		<option value='Widget'>Widget</option>
		<option value='Sample'>Sample</option>
		<option value='GROUP10'>GROUP10</option>
		<option value='GROUP11'>GROUP11</option>
		<option value='GROUP12'>GROUP12</option>
		<option value='GROUP13'>GROUP13</option>
		<option value='GROUP14'>GROUP14</option>
		<option value='GROUP15'>GROUP15</option>
		<option value='GROUP16'>GROUP16</option>
		<option value='GROUP17'>GROUP17</option>
		<option value='GROUP18'>GROUP18</option>
		<option value='GROUP19'>GROUP19</option>
		<option value='GROUP20'>GROUP20</option>
      </select>
      <p>This is to group the images. Select your slideshow group. </p>
      <label for="tag-display-status">Display status</label>
      <select name="Ihrss_status" id="Ihrss_status">
        <option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
      <p>Do you want the picture to show in your galler?</p>
      <label for="tag-display-order">Display order</label>
      <input name="Ihrss_order" type="text" id="Ihrss_order" size="10" value="" maxlength="3" />
      <p>What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.</p>
      <input name="Ihrss_id" id="Ihrss_id" type="hidden" value="">
      <input type="hidden" name="Ihrss_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="Save Details" type="submit" />&nbsp;  
        <input name="publish" lang="publish" class="button" onclick="Ihrss_redirect()" value="Cancel" type="button" />&nbsp;   
        <input name="Help" lang="publish" class="button" onclick="Ihrss_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('Ihrss_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_Ihrss_LINK; ?></p>
</div>