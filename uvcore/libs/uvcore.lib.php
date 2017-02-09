<?php

$uvlib_cleanchars = array('ě' => 'e', 'Ě' => 'E', 'š' => 's', 'Š' => 'S', 'č' => 'c', 'Č' => 'C', 'ř' => 'r', 'Ř' => 'R', 'ž' => 'z', 'Ž' => 'Z', 'ý' => 'y', 'Ý' => 'Y', 'á' => 'a', 'Á' => 'A', 'í' => 'i', 'Í' => 'I', 'é' => 'e', 'É' => 'E', 'ú' => 'u', 'ů' => 'u', 'Ů' => 'U', 'ď' => 'd', 'Ď' => 'D', 'ť' => 't', 'Ť' => 'T', 'ň' => 'n', 'Ň' => 'N', 'ü' => 'u');

$uv_coreurl = isset($uv_coreurl) ? $uv_coreurl : "";
$uv_corepath = isset($uv_corepath) ? $uv_corepath : "";
$uv_today = date("Y-m-d", current_time('timestamp'));

if(get_option('uvwp_eventurl') == "custom")
	$uveventlink = get_option('home') . "/" . get_option('uvwp_eventurlcustompage') . "/?id={eventid}&dt={seventdate}";

$uvlib_global = array();
$uvlib_global["uvvenueid"] = get_option('uvwp_uvvenueid');
$uvlib_global["veaid"] = get_option('uvwp_veaid');
$uvlib_global["wbcode"] = get_option('uvwp_wbcode');
$uvlib_global["uvserver"] = get_option('uvwp_uvserver');
$uvlib_global["eventurl"] = isset($uveventlink) ? $uveventlink : get_option('uvwp_eventurl');
$uvlib_global["sendformurl"] = admin_url('admin-ajax.php') . "?action=uvwp_sendresform";
$uvlib_global["packagespopurl"] = admin_url('admin-ajax.php') . "?action=uvwp_packagespopurl";
$uvlib_global["uvproresurl"] = "http://" . $uvlib_global["uvserver"] . "/apis/prores.pc8";
$uvlib_global["uniqueintid"] = 0;

$uvc_lib = array();
$uvc_lib["defaultview"] = "calendar"; //available views: "calendar", "list"
$uvc_lib["loadcalurl"] = admin_url('admin-ajax.php');

$uvg_lib = array();
$uvg_lib["pwidth"] = 800;
$uvg_lib["pheight"] = 600;
$uvg_lib["ninitalbums"] = 12;
$uvg_lib["nalbumsgroups"] = 8;
$uvg_lib["albumdatephpformat"] = "n/j/Y";
$uvg_lib["albumdesigntemplate"] = "default";
$uvg_lib["loadalbumurl"] = admin_url('admin-ajax.php') . "?action=uvwp_loadalbumpop";




$uvlib_flyers_priority = array(
	"default" => array(
		"flyertype" => array("Flyer", "Secondary Flyer", "Head Shot", "Action Shot", "Promotional"),
		"flyerratio" => array("Vertical", "Square", "Horizontal", "Banner")
	),
	"calendar" => array(
		"flyertype" => array("Flyer", "Secondary Flyer", "Head Shot"),
		"flyerratio" => array("Square", "Vertical", "Horizontal")
	),
	"slider" => array(
		"flyertype" => array("Flyer", "Secondary Flyer"),
		"flyerratio" => array("Horizontal", "Banner", "Square", "Vertical")
	)
);









