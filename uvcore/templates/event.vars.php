<?php

$id = isset($id) ? $id : $_REQUEST["id"];
$dt = isset($dt) ? $dt : $_REQUEST["dt"];
$rm = isset($rm) ? $rm : $_REQUEST["rm"];

$uvfeedtoken = "ev{$id}dt{$dt}ve" . $uvlib_global["veaid"] . "uv" . $uvlib_global["uvvenueid"];
$uvfeedtoken = $rm ? $uvfeedtoken . "rm{$rm}" : $uvfeedtoken;

$uveventfeed = uv_get_feed("event", $uvfeedtoken);

if(is_array($uveventfeed)){
	$event_info = $uveventfeed["events"][0];
	
	$evt_id 		= $event_info["id"];
	$evt_name 		= $event_info["name"];
	$evt_caldate	= $event_info["date"];
	$evt_starttime  = $event_info["starttime"];
	$evt_endtime	= $event_info["endtime"];
	$evt_vname		= $event_info["venuename"];
	$evt_venueadress= $event_info["venueadress"];
	$evt_venuegmap  = $event_info["venuegmapsurl"];
	$evt_mkarea		= $event_info["venuemarketarea"];
	$evt_veaid		= $event_info["venueid"];
	$evt_urvenueid	= $event_info["venueuvid"];
	$evt_clientid	= $event_info["urclientid"];
	$evt_descr      = $event_info["shortdescr"];
	$evt_flyers     = $event_info["flyers"];
	$evt_recflyers  = $event_info["flyers_recurrent"];
	$evt_dmonth = date("M", strtotime($evt_caldate));
	$evt_dnday = date("j", strtotime($evt_caldate));
	
	$evt_fcaldate 	= date("l, M j, Y @ g:ia", strtotime("$evt_caldate"));
	$evt_ddate = date("l, F j, Y", strtotime($evt_caldate));
	$evt_token_date = substr(str_replace("-", "", $evt_caldate), 2);
	$tmp_evt_mkarea	= explode(",", $evt_mkarea);
	$evt_fmkarea 	= $tmp_evt_mkarea[0].", ".$tmp_evt_mkarea[1];
	
	$eventgcalstartdate =  date("Ymd", strtotime($evt_caldate));
	$eventgcalenddate = ($evt_endtime and $evt_endtime < "12:00:00") ? date("Ymd", strtotime($evt_caldate . " + 1 day")) : date("Ymd", strtotime($evt_caldate));
	$googlecalendarlink = "https://www.google.com/calendar/event?action=TEMPLATE&text=" . urlencode($evt_name) . "&details=" . urlencode($evt_name) . "&dates={$eventgcalstartdate}/{$eventgcalenddate}&location=" . urlencode($evt_vname);
	
	$evt_dflyer = uv_get_flyer($evt_flyers);
	if(!$evt_dflyer)
		$evt_dflyer = uv_get_flyer($evt_recflyers);
	
	if($evt_dflyer)
		$evt_dflyer = "<a class='uvjs-popimg' href='" . $evt_dflyer["flyer_folder"] . "/800SC0/" . $evt_dflyer["flyer_file"] . "' data-poptitle='$evt_name'><div class='uv-event-flyer uv-imghover'><img class='uv-loadfade' src='" . $evt_dflyer["flyer_folder"] . "/500SC0/" . $evt_dflyer["flyer_file"] . "'></div></a>";
		
	$token_globalstring = "uv{$evt_urvenueid}";
}



$xtickets = uvGetUvTixItems($uvfeedtoken);

if($xtickets){
	eval($xtickets);
	$xtickets = $xc8;
	
	$urcart_itmsjson = json_encode($xtickets);
	
	$freeitems = uvGetUvTixByType($xtickets, "Free");
	$ticketsitems = uvGetUvTixByType($xtickets, "Tickets");
	$packagesitems = uvGetUvTixByType($xtickets, "Packages");
	$packagesitems .= uvGetUvTixByType($xtickets, "Package");
	$tablesitems = uvGetUvTixByType($xtickets, "Tables");
	$dinneritems = uvGetUvTixByType($xtickets, "Dinner");
	$diningitems = uvGetUvTixByType($xtickets, "Dining");
	$bottleserviceitems = uvGetUvTixByType($xtickets, "Bottle Service");
	$birthdayitems = uvGetUvTixByType($xtickets, "Birthday");
	$bacheloritems = uvGetUvTixByType($xtickets, "Bachelor");
	$bacheloretteitems = uvGetUvTixByType($xtickets, "Bachelorette");
	$guestlistitems = uvGetUvTixByType($xtickets, "Guest List");
	$freeguestlistitems = uvGetUvTixByType($xtickets, "Guestlist");
}

$resquestpanelclass = ($freeitems or $ticketsitems or $packagesitems or $packagesitems or $tablesitems or $dinneritems or $diningitems or $bottleserviceitems or $birthdayitems or $bacheloritems or $bacheloretteitems or $guestlistitems or $freeguestlistitems) ? "closed" : "";

$uvvenuedayrestypes = uv_get_date_restypes($evt_caldate, $evt_urvenueid);
$uv_venuedayrescheckboxes = "<div class='uv-checkboxgroup'>" . uv_get_restypes_checkboxes($uvvenuedayrestypes) . "</div>";















