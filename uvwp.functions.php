<?php

function uvwp_add_pluginlist_links($actions, $plugin_file){
	if($plugin_file and (strpos($plugin_file, "uvwp") !== false)){
		$settings = array('settings' => '<a href="options-general.php?page=urvenue_settings">Configure UrVenue Plugin</a>');		
    	$actions = array_merge($settings, $actions);
	}
	
	return $actions;
}
function uvwp_register_settings(){
	register_setting('urwpoptions-group', 'uvwp_veaid');
	register_setting('urwpoptions-group', 'uvwp_eventurl');
	register_setting('urwpoptions-group', 'uvwp_eventurlcustompage');
	register_setting('urwpoptions-group', 'uvwp_mapreqid');
}
function uvwp_add_settings(){
	$uvwp_hook_addop = add_options_page('UrVenue Settings', 'UrVenue Settings', 'manage_options', 'urvenue_settings', 'uvwp_plugin_options');
}
function uvwp_plugin_options(){
	if(!current_user_can('manage_options')){
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	
	$uvwp_veaid = get_option('uvwp_veaid');
	$uvwp_regveaid = get_option('uvwp_regveaid');
	$uvwp_siteurl = get_option('home');
	$uvwp_eventurlcustompage = get_option('uvwp_eventurlcustompage');
	$uvwp_mapreqid = get_option('uvwp_mapreqid');
	
	if(($uvwp_veaid) and ($uvwp_veaid != $uvwp_regveaid)){
		$uvwp_venueinfofeed = wp_remote_get("http://uvtix.com/api/v3/ve$uvwp_veaid/venues.pc8");
		
		if($uvwp_venueinfofeed["body"]){
			eval($uvwp_venueinfofeed["body"]);
			$uvwp_venueinfofeed = $xc8["venues"][0];
			
			if(is_array($uvwp_venueinfofeed)){
				$uvwp_venuename = $uvwp_venueinfofeed["name"];
				$uvwp_uvvenueid = $uvwp_venueinfofeed["urvenueid"];
				$uvwp_venuemarketarea = $uvwp_venueinfofeed["marketarea"];
				$uvwp_venuelogos = $uvwp_venueinfofeed["logos"];
				$uvwp_wbcode = $uvwp_venueinfofeed["wbcode"];
				$uvwp_uvserver = $uvwp_venueinfofeed["urvenueurl"];
				$uvwp_venuelogo = uvwp_get_venuelogo($uvwp_venuelogos);
				
				update_option('uvwp_regveaid', $uvwp_veaid);
				update_option('uvwp_venuename', $uvwp_venuename);
				update_option('uvwp_uvvenueid', $uvwp_uvvenueid);
				update_option('uvwp_venuemarketarea', $uvwp_venuemarketarea);
				update_option('uvwp_venuelogo', $uvwp_venuelogo);
				update_option('uvwp_wbcode', $uvwp_wbcode);
				update_option('uvwp_uvserver', $uvwp_uvserver);
				update_option('uvwp_mapreqid', $uvwp_mapreqid);
				
				
				$uvwpvenueinfocard = "<div class='card'><h3>$uvwp_venuename</h3><p>$uvwp_venuemarketarea</p><img src='$uvwp_venuelogo' style='max-width: 400px;'></div>";
			}
			else{
				$uvwpresetoptions = true;
				$uvwpvenueinfocard = "<div class='card'><h3>Venue with ID: $uvwp_veaid not found</h3><p>Contact <a href='mailto:support@urvneue.com'>support@urvneue.com</a> to get your correct Venue ID</p></div>";
			}
		}
		else{
			$uvwpresetoptions = true;
			$uvwpvenueinfocard = "<div class='card'><h3>Venue with ID: $uvwp_veaid not found</h3><p>Contact <a href='mailto:support@urvneue.com'>support@urvneue.com</a> to get your correct Venue ID</p></div>";
		}
	}
	else if($uvwp_veaid){
		$uvwp_venuename = get_option('uvwp_venuename');
		$uvwp_uvvenueid = get_option('uvwp_uvvenueid');
		$uvwp_venuemarketarea = get_option('uvwp_venuemarketarea');
		$uvwp_venuelogo = get_option('uvwp_venuelogo');
		$uvwp_wbcode = get_option('uvwp_wbcode');
		$uvwp_uvserver = get_option('uvwp_uvserver');
		$uvwp_mapreqid = get_option('uvwp_mapreqid');
		
		$uvwpvenueinfocard = "<div class='card'><h3>$uvwp_venuename</h3><p>$uvwp_venuemarketarea</p><img src='$uvwp_venuelogo' style='max-width: 400px;'></div>";
	}
	else
		$uvwpresetoptions = true;
	
	if($uvwpresetoptions){
		update_option('uvwp_regveaid', '');
		update_option('uvwp_venuename', '');
		update_option('uvwp_uvvenueid', '');
		update_option('uvwp_venuemarketarea', '');
		update_option('uvwp_venuelogo', '');
		update_option('uvwp_wbcode', '');
		update_option('uvwp_uvserver', '');
		update_option('uvwp_mapreqid', '');
	}
	
	$uvwp_eventurl = get_option('uvwp_eventurl');
	$uvwpevlcustck = ($uvwp_eventurl == "custom") ? "checked" : "";
	$uvwpevldefack = !$uvwpevlcustck ? "checked" : "";
	
	$uvwp_availablerestypes = uvwp_get_available_restypes($uvwp_uvvenueid, $uvwp_uvserver);
	
	echo("<div class='wrap'>
			<h2>UrVenue Settings</h2>
			$uvwpvenueinfocard
			<form method='post' action='options.php'>"); 
	
	settings_fields('urwpoptions-group');
	do_settings_sections('urwpoptions-group');
			
	echo("	
				<table class='form-table'>
					<tbody>
						<tr>
							<th scope='row'>VEA Venue ID</th>
							<td>
								<input type='text' name='uvwp_veaid' value='$uvwp_veaid' />
								<p class='description'>If you don't know your Venue ID of you venue send a mail to: <a href='mailto:support@urvneue.com'>support@urvneue.com</a></p>
							</td>
						</tr>
					</tbody>
				</table>
				<h2 class='title'>Event URL</h2>
				<p>To set event page create a page and add the urvenue shortcode: [urvenue_event]</p>
				<table class='form-table'>
					<tbody>
						<tr>
							<th><label><input name='uvwp_eventurl' type='radio' value='$uvwp_siteurl/event/?id={eventid}&dt={seventdate}' $uvwpevldefack> Default</label></th>
							<td><code>$uvwp_siteurl/event/?id=123&dt=170525</code></td>
						</tr>
						<tr>
							<th><label><input name='uvwp_eventurl' type='radio' value='custom' $uvwpevlcustck> Custom Page</label></th>
							<td><code>$uvwp_siteurl/</code><input name='uvwp_eventurlcustompage' type='text' value='$uvwp_eventurlcustompage' class='regular-text code' style='max-width: 150px;'><code>/?id=123&dt=170525</code></td>
						</tr>
					</tbody>
				</table>
				
				<h2 class='title'>Available Reservation Forms</h2>
				<p>These are reservations Forms available for your venue</p>
				<table class='form-table'>
					<tbody>
						$uvwp_availablerestypes
					</tbody>
				</table>	
				
				<h2 class='title'>3D Map</h2>
				<table class='form-table'>
					<tdody>
						<tr>
							<th scope='row'>Map Request ID</th>
							<td>
								<input type='text' name='uvwp_mapreqid' value='$uvwp_mapreqid' />
								<p class='description'>If you don't know your request id send a mail to: <a href='mailto:support@urvneue.com'>support@urvneue.com</a></p>
							</td>
						</tr>
					</tbody>
				</table>
	");
	submit_button();
	echo("	</form>
		</div>
	");
}
function uvwp_get_venuelogo($uvwpvenuelogos){
	global $uvwp_logotypes_lib;
	
	$uvwpvenuelogo = "";
	foreach($uvwp_logotypes_lib as $uvwplogotype){
		if($uvwpvenuelogos[$uvwplogotype] and !$uvwpvenuelogo)
			$uvwpvenuelogo = $uvwpvenuelogos[$uvwplogotype]["raw_url"];
	}
	
	return $uvwpvenuelogo;
}
function uvwp_enqueue_urvenue_files(){
	global $uv_coreurl;

	wp_enqueue_style("uvwp_styles", $uv_coreurl . "/uvcore.css");
	wp_enqueue_style("fontawesome", $uv_coreurl . "/assets/fonts/fontawesome.css");
	wp_enqueue_style("uvwp_custom", plugin_dir_url(__FILE__) . "uvcustom.css");
	wp_register_script("uvwp_scripts", $uv_coreurl . "/uvcore.js", array('jquery'));
	wp_enqueue_script("uvwp_scripts");
	
	wp_register_script("jquery_validate", $uv_coreurl . "/plugins/jquery.validate.min.js", array('jquery'));
	wp_enqueue_script("jquery_validate");
	
	wp_register_script("jqueryui_datepicker", $uv_coreurl . "/plugins/datepicker.js", array('jquery'));
	wp_enqueue_script("jqueryui_datepicker");
	
	wp_register_script("jquery_owlcarousel", $uv_coreurl . "/plugins/owl.carousel.min.js", array('jquery'));
	wp_enqueue_script("jquery_owlcarousel");
}
function uvwp_loadcal(){
	global $uv_corepath;

	include_once($uv_corepath . "/loads/uvcmonth.load.php");
	
	die();
}
function uvwp_sendresform(){
	global $uv_corepath, $uvlib_global;
	
	include_once($uv_corepath . "/loads/uvreservation.pro.php");

	die();
}
function uvwp_packagespopurl(){
	global $uv_corepath, $uvlib_global;
	
	include_once($uv_corepath . "/loads/uvpackage.pop.php");

	die();
}
function uvwp_loadalbumpop(){
	global $uv_corepath, $uvlib_global, $uvlib_designtemplates, $uvg_lib;
	
	include_once($uv_corepath . "/loads/photoalbum.pop.php");
	
	die();
}
function uvwp_get_available_restypes($uvvenueid = "", $uvserver = ""){
	global $uvlib_global;
	
	if((!$uvvenueid) or (!$uvserver)){
		$uvserver = $uvlib_global["uvserver"];
		$uvvenueid = $uvvenueid ? $uvvenueid : $uvlib_global["uvvenueid"];
	}
	$uvcaldate = date("Y-m-d");
	
	if($uvvenueid & $uvserver){
		$uvrestypesfeed = wp_remote_get("http://$uvserver/api/v1/venues/$uvvenueid/daystatus.pc8?startdate=$uvcaldate&enddate=$uvcaldate");
		
		if($uvrestypesfeed["body"]){
			eval($uvrestypesfeed["body"]);
			$uvvenuerestypes = $xc8[$uvcaldate]["restypes"];
			
			if(is_array($uvvenuerestypes))
				foreach($uvvenuerestypes as $uvvenuerestype){
					$uvrestypeshtml .= "<tr><th>" . $uvvenuerestype["restypename"] . "</th><td><code>[urvenue_reservation id=\"" . $uvvenuerestype["restypeid"] . "\"]</code></td></tr>";
				}
		}
		
		$uvrestypeshtml = $uvrestypeshtml ? $uvrestypeshtml : "<tr><h4>No reservation forms found</h4></tr>";
	}
	
	return $uvrestypeshtml;
}









