<?php

$uv_today = date("Y-m-d", current_time('timestamp'));
$uv_coreurl = plugin_dir_url(__FILE__) . "uvcore";
$uv_corepath = plugin_dir_path(__FILE__) . "uvcore";

if(get_option('uvwp_eventurl') == "custom")
	$uveventlink = get_option('home') . "/" . get_option('uvwp_eventurlcustompage') . "/?id={eventid}&dt={seventdate}";

$uv_opts = array();
$uv_opts["uvvenueid"] = get_option('uvwp_uvvenueid');
$uv_opts["veaid"] = get_option('uvwp_veaid');
$uv_opts["wbcode"] = get_option('uvwp_wbcode');
$uv_opts["uvserver"] = get_option('uvwp_uvserver');
$uv_opts["eventurl"] = isset($uveventlink) ? $uveventlink : get_option('uvwp_eventurl');
$uv_opts["sendformurl"] = admin_url('admin-ajax.php') . "?action=uvwp_sendresform";
$uv_opts["packagespopurl"] = admin_url('admin-ajax.php') . "?action=uvwp_packagespopurl";
$uv_opts["map-reqid"] = get_option('uvwp_mapreqid');

$uv_opts["uvc-loadcalurl"] = admin_url('admin-ajax.php') . "?action=uvwp_loadcal";

$uv_opts["uvg-loadalbumurl"] = admin_url('admin-ajax.php') . "?action=uvwp_loadalbumpop";