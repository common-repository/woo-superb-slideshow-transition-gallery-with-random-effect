<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_woo_display']) && $_POST['frm_woo_display'] == 'yes')
{
	$did = isset($_GET['did']) ? intval($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$woo_success = '';
	$woo_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_woo_TABLE."
		WHERE `woo_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'woo-transition'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('woo_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_woo_TABLE."`
					WHERE `woo_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$woo_success_msg = TRUE;
			$woo_success = __('Selected record was successfully deleted.', 'woo-transition');
		}
	}
	
	if ($woo_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $woo_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Woo superb slideshow', 'woo-transition'); ?>
	<a class="add-new-h2" href="<?php echo WP_woo_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'woo-transition'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_woo_TABLE."` order by woo_type, woo_order";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<form name="frm_woo_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('Type', 'woo-transition'); ?></th>
			<th scope="col"><?php _e('Image title', 'woo-transition'); ?></th>
            <th scope="col"><?php _e('Image', 'woo-transition'); ?></th>
			<th scope="col"><?php _e('Link', 'woo-transition'); ?></th>
			<th scope="col"><?php _e('Target', 'woo-transition'); ?></th>
            <th scope="col"><?php _e('Order', 'woo-transition'); ?></th>
            <th scope="col"><?php _e('Display', 'woo-transition'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('Type', 'woo-transition'); ?></th>
			<th scope="col"><?php _e('Image title', 'woo-transition'); ?></th>
            <th scope="col"><?php _e('Image', 'woo-transition'); ?></th>
			<th scope="col"><?php _e('Link', 'woo-transition'); ?></th>
			<th scope="col"><?php _e('Target', 'woo-transition'); ?></th>
            <th scope="col"><?php _e('Order', 'woo-transition'); ?></th>
            <th scope="col"><?php _e('Display', 'woo-transition'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
				?>
				<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td>
					<strong><?php echo esc_html(stripslashes($data['woo_type'])); ?></strong>
					<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_woo_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['woo_id']; ?>"><?php _e('Edit', 'woo-transition'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:woo_delete('<?php echo $data['woo_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'woo-transition'); ?></a></span> 
					</div>
					</td>
					<td><?php echo esc_html(stripslashes($data['woo_title'])); ?></td>
					<td><a href="<?php echo esc_html($data['woo_path']); ?>" target="_blank"><img src="<?php echo WP_woo_PLUGIN_URL; ?>/inc/image-icon.png"  /></a></td>
					<td><a href="<?php echo esc_html($data['woo_link']); ?>" target="_blank"><img src="<?php echo WP_woo_PLUGIN_URL; ?>/inc/link-icon.gif"  /></a></td>
					<td><?php echo esc_html(stripslashes($data['woo_target'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['woo_order'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['woo_status'])); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
				}
			}
			else
			{
				?><tr><td colspan="7" align="center"><?php _e('No records available.', 'woo-transition'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('woo_form_show'); ?>
		<input type="hidden" name="frm_woo_display" value="yes"/>
      </form>	
	  <div class="tablenav bottom">
	  <a href="<?php echo WP_woo_ADMIN_URL; ?>&amp;ac=add"><input class="button action" type="button" value="<?php _e('Add New', 'woo-transition'); ?>" /></a>
	  <a href="<?php echo WP_woo_ADMIN_URL; ?>&amp;ac=set"><input class="button action" type="button" value="<?php _e('Widget Setting', 'woo-transition'); ?>" /></a>
	  <a target="_blank" href="<?php echo WP_woo_FAV; ?>"><input class="button action" type="button" value="<?php _e('Help', 'woo-transition'); ?>" /></a>
	  <a target="_blank" href="<?php echo WP_woo_FAV; ?>"><input class="button button-primary" type="button" value="<?php _e('Short Code', 'woo-transition'); ?>" /></a>
	  </div>
	</div>
</div>