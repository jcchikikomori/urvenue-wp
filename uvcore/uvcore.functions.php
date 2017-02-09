<?php
include_once($uv_corepath . "/libs/feedsinfo.lib.php");
include_once($uv_corepath . "/libs/forms.lib.php");
include_once($uv_corepath . "/libs/designtemplates.lib.php");


/*UVCALENDAR*/
function uv_draw_calendar($uvfeedtoken, $uvstartdate = ""){
	global $uv_coreurl, $uvc_lib, $uv_corepath, $uv_today;

	if(!$uvstartdate)
		$uvstartdate = $uv_today;
	
	$uvmenumonths = uv_calendar_get_menumonths($uvstartdate);
	$uvcalendarmonth = uv_calendar_get_month($uvfeedtoken, $uvstartdate);
	$uvddate = date("F Y", strtotime($uvstartdate));
	
	$uvloadmonthurl = $uvc_lib["loadcalurl"] . "?action=uvwp_loadcal&feedtoken={$uvfeedtoken}&fd={uvsdate}";
	
	$uvccalli = ($uvc_lib["defaultview"] == "calendar") ? "active" : "";
	$uvclisli = ($uvc_lib["defaultview"] == "list") ? "active" : "";
	
	$uvcalviewclass = ($uvc_lib["defaultview"] == "calendar") ? "uv-calvisible-calendar" : $uvcalviewclass;
	$uvcalviewclass = ($uvc_lib["defaultview"] == "list") ? "uv-calvisible-list" : $uvcalviewclass;

	echo("<div class='uv-calendar-controls uv-clearfix' data-loadmonthurl='$uvloadmonthurl'>
			<div class='uv-dropdown'>
				<a class='uv-calendar-month uvjs-showdropdown' href='#'>$uvddate</a>
				<ul class='uv-dropdown-menu uv-panel'>
					$uvmenumonths
				</ul>
			</div>
			<ul class='uv-menu uv-calendar-menu'>
				<li class='$uvccalli'><a href='#' data-calvisibleclass='uv-calvisible-calendar'><button class='uv-btn'>Calendar</button></a></li>
				<li class='$uvclisli'><a href='#' data-calvisibleclass='uv-calvisible-list'><button class='uv-btn'>List</button></a></li>
			</ul>
		</div>
		<div class='uv-calendar-charge $uvcalviewclass'>
			$uvcalendarmonth
		</div>
	");
}
function uv_calendar_get_menumonths($uvdate){
	$uvdate = date("Y-m-01", strtotime($uvdate));
	$uvdate = strtotime($uvdate);
	$uvfirstmonth = "current";
	
	for($i=0; $i<7; $i++){
		$uvdatadate = date("Y-m-01", $uvdate);
		$uvdatesdate = date("ymd", $uvdate);
		$uvdmonth = date("F", $uvdate);
		$uvdmonthyear = date("Y", $uvdate);
	
		$uvmenumonths .= "<li class='$uvfirstmonth'><a class='uvjs-calendar-loadmonth' href='#' data-date='$uvdatadate' data-sdate='$uvdatesdate' data-ddate='$uvdmonth&nbsp;$uvdmonthyear'>$uvdmonth&nbsp;$uvdmonthyear</a></li>";
		
		$uvdate = strtotime("+1 month", $uvdate);
		$uvfirstmonth = "";
	}

	return $uvmenumonths;
}
function uv_calendar_get_month($uvfeedtoken, $uvstartdate){
	global $uv_today;

	$uvcalfeed = uv_get_feed("calendar", $uvfeedtoken);

	$uvtoday = $uv_today;
	$uvweeks = $uvcalfeed["weeks"];
	$uvnextmonth = ($uvcalfeed["info"]) ? $uvcalfeed["info"]["nextmonth"] : "";
	$uvprevmonth = ($uvcalfeed["info"]) ? date("Y-m-31", strtotime($uvcalfeed["info"]["prevmonth"])) : "";
	
	if(is_array($uvweeks)){
		$uvcalendarmonth = "<table class='uv-calendar-table'><thead><tr><th>Mon<span>day</span></th><th>Tue<span>sday</span></th><th>Wed<span>nesday</span></th><th>Thu<span>rsday</span></th><th>Fri<span>day</span></th><th>Sat<span>urday</span></th><th>Sun<span>day</span></th></tr></thead><tbody>";
	
		foreach($uvweeks as $uvweek){
			$uvcalendarmonth .= "<tr>";
			for($i=0; $i<7; $i++){
				$uvtdclass = "";
				$uvcdate = $uvweek[$i];
				$uvdateevents = $uvcdate["events"];
				$uvdate = $uvcdate["date"];
				$uvlabeldate = date("M d", strtotime($uvdate));
				$uvtdclass = ($uvtoday > $uvdate) ? $uvtdclass . "past" : $uvtdclass;
				$uvtdclass = ($uvdate >= $uvnextmonth) ? $uvtdclass . " next" : $uvtdclass;
				$uvtdclass = ($uvprevmonth > $uvdate) ? $uvtdclass . " prev" : $uvtdclass;
				
				$uvdatecellcont = $uvdateevents ? uv_calendar_get_date($uvdateevents) : "";
				
				if($uvdateevents)
					$uvmontheventlist .= uv_calendar_list_get_date($uvdateevents);
				
				$uvcalendarmonth .= "<td class='$uvtdclass'><div class='datelabel'>$uvlabeldate</div><div class='cellcont'>$uvdatecellcont</div></td>";
			}
			$uvcalendarmonth .= "</tr>";
		}
		
		if(!$uvmontheventlist) $uvmontheventlist = "<div class='uv-nocontent'>No events for this month.</div>";
		$uvcalendarmonth .= "</tbody></table><div class='uv-calendar-list uv-eventslist'>$uvmontheventlist</div>";
	}
	else
		return "UV Error: There was a problem getting the calendar feed";
		
	
	return $uvcalendarmonth;
}
function uv_calendar_get_date($uvdateevents){
	$uvdateflyer = uv_get_flyer($uvdateevents[0]["flyers"], "calendar");
	
	$uvdateflyerfolder = $uvdateflyer["flyer_folder"];
	$uvdateflyerfile   = $uvdateflyer["flyer_file"];
	$uvdateflyerratio  = $uvdateflyer["flyer_ratio"];
	$uvdateevents[0]["marketareaid"] = $ven_mkareaid;
	$uveventlink = uv_get_event_link($uvdateevents[0]);
	
	$uvdateflyerimsize = (($uvdateflyerratio == "Vertical") or ($uvdateflyerratio == "Horizontal")) ? "300SC0" : "300KT300";
	
	$uvdatecell = "<a href='$uveventlink' class='flyer'><div class='uv-flyerbg uv-rat-$uvdateflyerratio' style='background-image: url($uvdateflyerfolder/$uvdateflyerimsize/$uvdateflyerfile);'><img class='uv-loadfade' src='$uvdateflyerfolder/$uvdateflyerimsize/$uvdateflyerfile' data-target='parent'></div>";

	return $uvdatecell;
}
function uv_calendar_list_get_date($uvdateevents){
	if(is_array($uvdateevents))
		foreach($uvdateevents as $event_info){
			$evt_id			= $event_info["id"];
			$evt_caldate 	= $event_info["date"];
			$evt_name		= $event_info["name"];
			$evt_venueid	= $event_info["venueid"];						
			$evt_vname		= $event_info["venuename"];						
			$evt_city		= $ven_marketarea;
			$evt_mkareaid	= $ven_mkareaid;
			$evt_calmonnth	= date("M", strtotime($evt_caldate));
			$evt_calday		= date("j", strtotime($evt_caldate));
		
			$evt_flyers		= $event_info["flyers"];
			$evt_flyer 		= uv_get_flyer($evt_flyers, "calendar");
			$evt_fly_folder = $evt_flyer["flyer_folder"];
			$evt_fly_file	= $evt_flyer["flyer_file"];
			
			$evt_fly_url = "";
			if($evt_fly_folder && $evt_fly_file)					
				$evt_fly_url = "$evt_fly_folder/90KT90/$evt_fly_file";
				
			$evt_url = uv_get_event_link($event_info);
		
			if($evt_fly_url)
				$uveventlistitem .= "<div class='uv-eventslist-item'><a href='$evt_url'><img src='$evt_fly_url'></a><div class='name'><h3>$evt_name</h3><div class='date'><div class='month'>$evt_calmonnth</div><div class='day'>$evt_calday</div></div></div><div class='actions'><a href='$evt_url' class='uv-btn uv-btn-s uv-btn-100'>View</a></div></div>";	
		}
	
	return $uveventlistitem;
}
/**********/
/*UVFEEDS*/
function uv_get_feed($uvfeedkey, $uvterms = ""){
	global $uvlib_feeds;

	if(preg_match("/^\d+$/", $uvfeedkey))
		return uv_get_media_feed($uvfeedkey, $uvterms);
	else if(preg_match("/^https?:\/\/.+$/", $uvfeedkey)){
		$uvfeedexpiration = $uvterms ? $uvterms : 3600;
		return uv_call_feed($uvfeedkey, $uvfeedexpiration);
	}
	else{
		if(array_key_exists($uvfeedkey, $uvlib_feeds)){
			if($uvterms)
				return uv_get_lib_feed($uvfeedkey, $uvterms);
			else
				return "UV Error: Parameters are required";
		}
		else
			return "UV Error: Given feed key({$uvfeedkey}) does not exist";
	}
}
function uv_get_media_feed($uvmediaid, $uvmediaelement){
	global $uvlib_mediafeeds;
	
	$uvfeedmediapath = $uvlib_mediafeeds["m$uvmediatypeid"] ? $uvlib_mediafeeds["feedmediapath"] : "";

	$uvterms = array(
		"mediaid" => $uvmediaid
	);

	$uvfeedcotent = uv_get_lib_feed("MEDIA", $uvterms);
	$uvmediatypeid = $uvfeedcotent["mediatypeid"];
	
	if(!$uvmediatypeid and $uvfeedcotent["pic"])
		$uvmediatypeid = $uvfeedcotent["pic"][0]["mediatypeid"];
	else if(!$uvmediatypeid and $uvfeedcotent["singlevideo"])
		$uvmediatypeid = $uvfeedcotent["singlevideo"][0]["video"][0]["mediatypeid"];
	else if(!$uvmediatypeid and $uvfeedcotent["pdf"])
		$uvmediatypeid = $uvfeedcotent["pdf"][0]["mediatypeid"];
	else if(!$uvmediatypeid and $uvfeedcotent["article"])
		$uvmediatypeid = $uvfeedcotent["article"][0]["mediatypeid"];
	else if(!$uvmediatypeid and $uvfeedcotent["gallery"])
		$uvmediatypeid = $uvfeedcotent["gallery"][0]["mediatypeid"];
	
	if($uvmediatypeid and $uvlib_mediafeeds["m$uvmediatypeid"]){
		$uvfeedreturnpath = $uvlib_mediafeeds["m$uvmediatypeid"]["feedreturnpath"];
		$uvlibfeedreturn = $uvlib_mediafeeds["m$uvmediatypeid"]["feedreturn"];
		$uvfeedreturn = !$uvmediaelement ? $uvlibfeedreturn : $uvmediaelement;
		
		if($uvfeedreturnpath){
			$uvfeedrpaths = explode(":", $uvfeedreturnpath);
			foreach($uvfeedrpaths as $uvpathindex){
				$uvfeedcotent = $uvfeedcotent[$uvpathindex];
				
				if(!$uvfeedcotent)
					return "UV Error: Wrong feed return path, contact aa";
			}
		}
		
		if($uvlibfeedreturn == "imageurl" and !$uvmediaelement == "feed"){
			$uvfeedimgsize = $uvmediaelement ? $uvmediaelement : "raw";
			$uvfeedcotentreturn = $uvfeedcotent["folder"] . "/$uvfeedimgsize/" . $uvfeedcotent["file"];
		}
		else if($uvlibfeedreturn == "videoframeurl" and !$uvmediaelement == "feed"){
			$uvfeedcotentreturn = $uvfeedcotent["videoexternalid"];
			$uvfeedvidurl = $uvfeedcotent["videourl"];
			
			$uvfeedcotentreturn = (preg_match("/vimeo/", $uvfeedvidurl)) ? "https://player.vimeo.com/video/" . $uvfeedcotentreturn : "https://www.youtube.com/embed/" . $uvfeedcotentreturn;
		}
		else if($uvlibfeedreturn == "pdfurl" and !$uvmediaelement == "feed"){
			$uvfeedcotentreturn = $uvfeedcotent["folder"] . "/raw/" . $uvfeedcotent["file"];
		}
		else if($uvlibfeedreturn == "article" and !$uvmediaelement == "feed"){
			$uvfeedcotentreturn = $uvfeedcotent["plaintext"];
		}
		else if($uvlibfeedreturn == "feed" or $uvmediaelement == "feed")
			$uvfeedcotentreturn = $uvfeedcotent;
		else if(!$uvmediaelement)
			$uvfeedcotentreturn = $uvfeedcotent["$uvfeedreturn"];		
		else
			$uvfeedcotentreturn = $uvfeedcotent["$uvmediaelement"] ? $uvfeedcotent["$uvmediaelement"] : "Feed element not found";
	}
	else
		return "UV Error: mediatype not supported, contact aa";
	
	return $uvfeedcotentreturn;
}
function uv_get_lib_feed($uvfeedkey, $uvterms){
	global $uvlib_feeds, $uvlib_global, $uv_feedspath;
	
	$uv_server = $uvlib_global["uvserver"];
	$uvlibfeedurl = $uvlib_feeds[$uvfeedkey]["url"];
	$uvlibfeedexpiration = $uvlib_feeds[$uvfeedkey]["expiration"];
	$uvlibfeedvarpass = $uvlib_feeds[$uvfeedkey]["varpass"];
	
	if($uvlibfeedvarpass == "url"){
		if(is_array($uvterms)){
			foreach($uvterms as $uvkey => $uvvalue)
				$uvparams .= $uvkey . $uvvalue;
		}
		else
			$uvparams = $uvterms;
	}
	else if($uvlibfeedvarpass == "get"){
		foreach($uvterms as $uvkey => $uvvalue){
			$uvparams .= $uvgetandchar . $uvkey . "=" . $uvvalue;
			$uvgetandchar = "&";
		}
		
		if($uv_feedspath and is_writable($uv_feedspath)){
			$uvparams .= "&cmscache=" . uv_get_cmscacheword();
		}
	}
		
	$uvlibfeedurl = str_replace("{uvserver}", $uv_server, $uvlibfeedurl);
	$uvlibfeedurl = str_replace("{params}", $uvparams, $uvlibfeedurl);
		
	return uv_call_feed($uvlibfeedurl, $uvlibfeedexpiration, $uvfeedkey);
}
function uv_call_feed($uvfeedurl, $uvfeedexpiration, $uvfeedkey = "direct"){
	global $uv_feedspath;
	
	if(($uv_feedspath) and (is_writable($uv_feedspath)) and ($uvfeedexpiration > 0)){
		return uv_get_cached_feed($uvfeedurl, $uvfeedexpiration, $uvfeedkey);	
	}
	else{
		if($uv_feedspath)
			return "UV Error: Cache path does not exist or is not writable";
		else
			return uv_get_feed_nocache($uvfeedurl, $uvfeedkey);
	}
}
function uv_get_feed_nocache($uvfeedurl, $uvfeedkey = ""){
	global $uv_testfeeds;

	if((preg_match("/^.+\.(\w{3,4})$/", $uvfeedurl, $uvfeedurlparts) or preg_match("/^.+\.(\w{3,4})[\?].+$/", $uvfeedurl, $uvfeedurlparts))){
		$uvfeedfiletype = $uvfeedurlparts[1];
		
		$uvfilecontent = uv_file_get_contents($uvfeedurl);
		$uvfilecontent = uv_get_feed_array($uvfilecontent, $uvfeedfiletype, $uvfeedkey);
		
		if($uv_testfeeds) echo("UV Debug: No cache feed called: $uvfeedurl");
		
		return $uvfilecontent;
	}
	else
		return "UV Error: Filetype not supported, contact: aa";
}
function uv_get_cached_feed($uvfeedurl, $uvfeedexpiration, $uvfeedkey){
	global $uv_feedspath, $uv_testfeeds;

	if($uv_feedspath and (preg_match("/^.+\.(\w{3,4})$/", $uvfeedurl, $uvfeedurlparts) or preg_match("/^.+\.(\w{3,4})[\?].+$/", $uvfeedurl, $uvfeedurlparts))){
	
		$uvfeedhash = hash('md5', $uvfeedurl);
		$uvfeedfiletype = $uvfeedurlparts[1];
		$uvfeedfullpath = $uv_feedspath . "/" . $uvfeedhash . "." . $uvfeedfiletype; 
		
		if(file_exists("$uvfeedfullpath")){
			$uvfileexpiresat = filemtime($uvfeedfullpath) + $uvfeedexpiration;
			$uvnowtime = time();
			
			if($uvnowtime > $uvfileexpiresat){
				$uvfilecontent = uv_create_feed_file($uvfeedurl, $uvfeedfullpath, $uvfeedexpiration);
				uv_update_feeds_infofile($uvfeedurl, $uvfeedfullpath, $uvfeedexpiration, $uvfeedhash, $uvfeedkey);
				
				if($uv_testfeeds) echo("UV Debug: Cached feed refreshed: $uvfeedurl");
			}
			else{
				$uvfilecontent = uv_file_get_contents($uvfeedfullpath);
				
				if($uv_testfeeds) echo("UV Debug: Feed called from cache: $uvfeedurl");
			}
		}
		else{
			$uvfilecontent = uv_create_feed_file($uvfeedurl, $uvfeedfullpath, $uvfeedexpiration);
			uv_update_feeds_infofile($uvfeedurl, $uvfeedfullpath, $uvfeedexpiration, $uvfeedhash, $uvfeedkey);
			
			if($uv_testfeeds) echo("UV Debug: Cache feed created: $uvfeedurl");
		}
		
		$uvfilecontent = uv_get_feed_array($uvfilecontent, $uvfeedfiletype, $uvfeedkey);
		
		return $uvfilecontent;
	}
	else
		return "UV Error: Filetype not supported, contact: aa";
}
function uv_create_feed_file($uvfeedurl, $uvfeedfullpath, $uvfeedexpiration){
	if($uvfeedfullpath and $uvfeedurl){
		$uvfilecotent = uv_file_get_contents($uvfeedurl);
	
		if(file_exists("$uvfeedfullpath"))
			unlink("$uvfeedfullpath");
				
		$fp = fopen("$uvfeedfullpath", "w+");
		fwrite($fp, $uvfilecotent);
		fclose($fp);
		
		return $uvfilecotent;
	}
}
function uv_get_feed_array($uvfilecontent, $uvfeedfiletype, $uvfeedkey = ""){
	if($uvfeedfiletype == "json"){
		$uvfilecontent = json_decode($uvfilecontent, true);
		
		if($uvfeedkey == "MEDIA")
			$uvfilecontent = $uvfilecontent["xc8"][0];
	}
	else if($uvfeedfiletype == "pc8"){
		eval($uvfilecontent);
		$uvfilecontent = $xc8;
	}
	
	return $uvfilecontent;
}
function uv_update_feeds_infofile($uvfeedurl, $uvfeedfullpath, $uvfeedexpiration, $uvfeedhash, $uvfeedkey){
	global $uv_feedspath, $uvlib_feedscleartime, $uvtmp_cmscacheword;
	
	if($uv_feedspath){
		$uvfeedsinfofilepath = $uv_feedspath . "/cachedfeedsinfo.php";
		$uvtimenow = time();
	
		if(!file_exists($uvfeedsinfofilepath)){
			$uvclearfeedstime = $uvtimenow + $uvlib_feedscleartime;
			$uvcmscacheword = $uvtmp_cmscacheword ? $uvtmp_cmscacheword : uv_generate_random_word();
		
			$uvfeedsinfofilearray = array(
				"clearfeedstime" => $uvclearfeedstime,
				"cmscacheword" => $uvcmscacheword,
				"feeds" => array()
			);
		}
		else
			$uvfeedsinfofilearray = include("$uvfeedsinfofilepath");
			
		$uvclearfeedstime = $uvfeedsinfofilearray["clearfeedstime"];
		
		$uvfeedsinfofilearray["feeds"]["$uvfeedhash"]["feedurl"] = $uvfeedurl;
		$uvfeedsinfofilearray["feeds"]["$uvfeedhash"]["feedpath"] = $uvfeedfullpath;
		$uvfeedsinfofilearray["feeds"]["$uvfeedhash"]["expiration"] = $uvfeedexpiration;
		$uvfeedsinfofilearray["feeds"]["$uvfeedhash"]["lastupdate"] = $uvtimenow;
		$uvfeedsinfofilearray["feeds"]["$uvfeedhash"]["feedkey"] = $uvfeedkey;
		
		$fp = fopen("$uvfeedsinfofilepath", "w+");
		fwrite($fp, "<?php return " . var_export($uvfeedsinfofilearray, true) . ";");
		fclose($fp);
		
		if(time() > $uvclearfeedstime)
			uv_clean_cached_feeds();
	}
}
function uv_clean_cached_feeds(){
	global $uv_feedspath;
	
	if($uv_feedspath){
		if(file_exists($uv_feedspath)){
			$uvfiles = glob("$uv_feedspath/*");
			foreach($uvfiles as $uvfile){
				if(is_file($uvfile))
					unlink($uvfile);
			}
		}
		return true;
	}
	return false;
}
function uv_get_cmscacheword(){
	global $uvtmp_cmscacheword, $uv_feedspath;

	$uvfeedsinfofilepath = $uv_feedspath . "/cachedfeedsinfo.php";
	
	if(!$uvtmp_cmscacheword){
		if(!file_exists($uvfeedsinfofilepath))
			$uvtmp_cmscacheword = uv_generate_random_word();
		else{
			$uvfeedsinfofilearray = include("$uvfeedsinfofilepath");
			$uvtmp_cmscacheword = $uvfeedsinfofilearray["cmscacheword"];
		}
	}
	
	return $uvtmp_cmscacheword;
}
function uv_generate_random_word($uvlenght = 8){
    $uvrword = array_merge(range('a', 'z'), range('A', 'Z'));
    shuffle($uvrword);
    
    return substr(implode($uvrword), 0, $uvlenght);
}
/****************/

function uv_file_get_contents($uvfileurl){
 	$ch = curl_init();
 	curl_setopt($ch, CURLOPT_URL, $uvfileurl);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5);
 	curl_setopt($ch, CURLOPT_TIMEOUT, 60);

 	$output = curl_exec($ch);
	
 	return($output);
}

/*UVPERFORMANCE*/
function uv_set_performance(){
	 return microtime(true);
}
function uv_get_performance($uvperftimestart){
	$uvperftimeend = microtime(true);
	$uvperftime = ($uvperftimeend - $uvperftimestart);
	
	return $uvperftime;
}
/****************/

/*TEXT AND INFO PROCESSING*/
function uv_get_event_link($uveventinfo = ""){
	global $uvlib_global;

	$evt_id	= $uveventinfo["id"];
	$evt_caldate 	= $uveventinfo["date"];
	$evt_name		= $uveventinfo["name"];
	$evt_venueid	= $uveventinfo["venueid"];	
	$evt_veroomid   = $uveventinfo["venueroomid"];									
	$evt_mkareaid	= $uveventinfo["marketareaid"];
	$evt_fname 		= uv_get_linkstring($evt_name);
	$evt_tokendate 	= date("ymd", strtotime($evt_caldate));
	
	$evt_url = $uvlib_global["eventurl"];
	$evt_addroomid = $evt_veroomid ? "rm$evt_veroomid" : "";
	$evt_tokenvars = "ve{$evt_venueid}dt{$evt_tokendate}{$evt_addroomid}";
	
	$evt_url = str_replace("{tokenvars}", $evt_tokenvars, $evt_url);
	$evt_url = str_replace("{eventurlname}", $evt_fname, $evt_url);
	$evt_url = str_replace("{eventid}", $evt_id, $evt_url);
	$evt_url = str_replace("{eventdate}", $evt_caldate, $evt_url);
	$evt_url = str_replace("{seventdate}", $evt_tokendate, $evt_url);

	return $evt_url;
}
function uv_get_linkstring($string){
	 $string = uv_get_string2u($string, "-");
	 $string = preg_replace("|[^a-zA-Z0-9_]|", "-", $string);
	 $string = preg_replace("|-+|", "-", $string);
	 
	 if(substr($string, -1) == "-") 
	 	$string = substr($string, 0, -1);
	 	
	 if(substr($string, 0, 1) == "-") 
	 	$string=substr($string, 1);
	 	
	 $string = strtolower($string);
	 
	 return($string);
}
function uv_get_string2u($string, $uchar){
	global $uvlib_cleanchars;

 	if(!$uchar)
 		$uchar="-";
 	$string = strtr($string, $uvlib_cleanchars);
 
 	$string = ucwords($string);
 	
 	$string=preg_replace("|[&][#0-9a-zA-Z]+[;]|", "", $string);
	$string=preg_replace("|[^0-9a-zA-Z]|", $uchar, $string);
	$string=preg_replace("|[$uchar][$uchar]+|", "$uchar", $string);
	
	return $string;
}
function uv_get_flyer($uvflyers, $uvflyeruse = "default", $uvflyerforce = false){
	global $uvlib_flyers_priority;
	
	$uvflyerreturn = false;
	$uvflyerreturn_cur = false;
	$uvflyertypehc_cur = $uvflyerratiohc_cur = 0;
	if(is_array($uvflyers)){
		foreach($uvflyers as $uvflyer){
			$uvflyertypehc = (array_search($uvflyer["flyer_type"], $uvlib_flyers_priority[$uvflyeruse]["flyertype"]) !== FALSE) ? array_search($uvflyer["flyer_type"], $uvlib_flyers_priority[$uvflyeruse]["flyertype"]) + 1 : -1;
			$uvflyerratiohc = (array_search($uvflyer["flyer_ratio"], $uvlib_flyers_priority[$uvflyeruse]["flyerratio"]) !== FALSE) ? array_search($uvflyer["flyer_ratio"], $uvlib_flyers_priority[$uvflyeruse]["flyerratio"]) + 1 : -1;
			
			if(($uvflyertypehc < $uvflyertypehc_cur) or ($uvflyertypehc_cur == 0)){
				$uvflyertypehc_cur = $uvflyertypehc;
				$uvflyerratiohc_cur = $uvflyerratiohc;
				$uvflyerreturn_cur = $uvflyer;
			}
			else if($uvflyertypehc == $uvflyertypehc_cur){
				if($uvflyerratiohc < $uvflyerratiohc_cur){
					$uvflyertypehc_cur = $uvflyertypehc;
					$uvflyerratiohc_cur = $uvflyerratiohc;
					$uvflyerreturn_cur = $uvflyer;
				}
			}
			
			if(($uvflyertypehc == 1) and ($uvflyerratiohc == 1)){
				$uvflyertypehc_cur = $uvflyertypehc;
				$uvflyerratiohc_cur = $uvflyerratiohc;
				$uvflyerreturn_cur = $uvflyer;
				break;
			}
		}
	}
	
	$uvflyerreturn = is_array($uvflyerreturn_cur) ? $uvflyerreturn_cur : $uvflyerreturn;
	
	return $uvflyerreturn;
}
function uv_get_date_restypes($uvcaldate, $uvvenueid = false){
	global $uvlib_global;
	
	$uvserver = $uvlib_global["uvserver"];
	$uvvenueid = $uvvenueid ? $uvvenueid : $uvlib_global["uvvenueid"];
	
	$uvdaystatusfeed = @uv_file_get_contents("http://$uvserver/api/v1/venues/$uvvenueid/daystatus.json?startdate=$uvcaldate&enddate=$uvcaldate");
	
	$uvdaystatusfeed = json_decode($uvdaystatusfeed, true);
	$uvdaystatusfeed = $uvdaystatusfeed["xc8"][0];
		
	if($uvdaystatusfeed){
		$uvdaystatus = $uvdaystatusfeed["$uvcaldate"][1]["daystatus"];
		$uvdaytimezone = $uvdaystatusfeed["$uvcaldate"][2]["timezone"];	
		$uvdaytimeidet = $uvdaystatusfeed["$uvcaldate"][3]["timezoneidentifier"];
			
		if($daytimeidet)
			date_default_timezone_set($daytimeidet);
			
		$uvdayrestypes = array();
		
		if(($uvdaystatus == "Open") and (is_array($uvdaystatusfeed["$uvcaldate"][0]["restypes"]))){
		
			foreach($uvdaystatusfeed["$uvcaldate"][0]["restypes"] as $dayrestype){
				$showrestyp = 1;
					
				$timecutoff = $dayrestype["cutofftime"];									
				if(($timecutoff != "-1") && ($timecutoff)){
					$timenow = strtotime(date("Y-m-d H:i:s"));
					$timecheck = strtotime("$uvcaldate $timecutoff");
					
					if($timenow>$timecheck){
						$showrestyp = 0;
					}
					
				}
				
				
				if(($dayrestype["status"] == "Open") and ($dayrestype["blockwebsubmission"] != 1) and $showrestyp){
					$dayrestypes[] = $dayrestype;
				}
			}
		}
	}
	
	if(count($dayrestypes) == 0)
		$dayrestypes = "";
	
	return $dayrestypes;
}
function uv_get_restypes_checkboxes($uvdayrestypes){
	$uvvrc = 0;
	if(is_array($uvdayrestypes))
		foreach($uvdayrestypes as $venuerestype){
			$resischecked = $uvvrc == 0 ? "checked" : "";
			$uvvrc++;
			$showrestypename = $venuerestype["restypename"];
			
			$uvrescheckslist .= "<div class='uv-checkbox'><label><input type='radio' name='restypeid' value='" . $venuerestype["restypeid"] . "' $resischecked>" . $showrestypename . "</label></div>";
		}
	
	return $uvrescheckslist;
}
function uv_get_formhtml($uvresdate, $uvrescheckboxes = ""){
	global $uvlib_formtemplates, $uvlib_formfields_structure;
	
	$uvfomethod = $uvlib_formtemplates["formsheaders"]["method"];
	$uvfoaction = $uvlib_formtemplates["formsheaders"]["action"];
	$uvfosuccessmsg = $uvlib_formtemplates["formsheaders"]["successmsg"];
	
	$uvformhtml = "<form class='uv-form uvjs-validate' method='$uvfomethod' action='$uvfoaction' data-successmsg='$uvfosuccessmsg' data-sendmethod='ajax'>";
	
	if(is_array($uvlib_formtemplates["formsheaders"]["hiddenfields"]))
		foreach($uvlib_formtemplates["formsheaders"]["hiddenfields"] as $uvhfieldname => $uvhfieldvalue){
			$uvformhiddenfields .= "<input type='hidden' name='$uvhfieldname' value='$uvhfieldvalue'>"; 
		}
	$uvformhiddenfields = str_replace("{resdate}", $uvresdate, $uvformhiddenfields);
	$uvformhtml .= $uvformhiddenfields;
	
	if(is_array($uvlib_formtemplates["default"]))
		foreach($uvlib_formtemplates["default"] as $uvformfield){
			$uvformfieldhandle = $uvformfield["handle"];
			
			if($uvformfieldhandle != "restypecheckboxes"){
				$uvfieldvalidateattrs = "";
				$uvfieldstructure = $uvlib_formfields_structure["simplelabel"][$uvformfieldhandle];
				$uvfieldextraattrs = $uvformfield["extraattr"] ? $uvformfield["extraattr"] : "";
				$uvfieldmaxwidth = $uvformfield["maxwidth"] ? "style='max-width: " . $uvformfield["maxwidth"] . "px'" : "";
				
				if($uvformfield["required"]){
					$uvfieldvalidateattrs = $uvformfield["error"] ? "data-msg-required='" . $uvformfield["error"] . "' " : "";
					$uvfieldvalidateattrs = $uvformfield["valtype"] ? $uvfieldvalidateattrs . $uvformfield["valtype"] . "='true' data-msg-" . $uvformfield["valtype"] . "='" . $uvformfield["valtypeerror"] . "'" : $uvfieldvalidateattrs;
					$uvfieldvalidateattrs .= "required";
				}
				
				$uvformfieldhtml = str_replace(array("{label}", "{name}", "{type}", "{validateattrs}", "{extraattrs}", "{fieldparentstyle}", "{placeholder}"), array($uvformfield["label"], $uvformfield["name"], $uvformfield["type"], $uvfieldvalidateattrs, $uvfieldextraattrs, $uvfieldmaxwidth, $uvformfield["placeholder"]), $uvfieldstructure);
				
				if(($uvformfieldhandle == "resdate") && ($uvresdate)) $uvformfieldhtml = "";
				
				$uvformhtml .= $uvformfieldhtml;
			}
			else if($uvformfieldhandle == "restypecheckboxes"){
				if(preg_match("/^\d+$/", $uvrescheckboxes))
					$uvformhtml .= "<input type='hidden' name='restypeid' value='$uvrescheckboxes'>";
				else
					$uvformhtml .= $uvrescheckboxes;
			}
		}
	
	$uvformhtml .= "<div class='uv-form-footer uv-clearfix'><button class='uv-btn uv-btn-p' type='submit'>Submit</button></div>";
	$uvformhtml .= "</form>";
	
	return $uvformhtml;
}
function uv_get_restypeopendays_script($uvrestypeid){
	global $uvlib_global, $uv_today;
	
	$uvserver = $uvlib_global["uvserver"];
	$uvvenueid = $uvvenueid ? $uvvenueid : $uvlib_global["uvvenueid"];
	
	$uvstartdate = $uv_today;
	$uvenddate = date("Y-m-d", strtotime("+90 days"));
	
	$uvrestypeopendaysfeed = @uv_file_get_contents("http://$uvserver/api/v1/venue/$uvvenueid/daystatus.json?restypeid=$uvrestypeid&startdate=$uvstartdate&enddate=$uvenddate");
	
	$uvrestypeopendaysfeed = json_decode($uvrestypeopendaysfeed, true);
	$uvrestypeopendaysfeed = $uvrestypeopendaysfeed["xc8"][0];
	
	if(is_array($uvrestypeopendaysfeed))
		foreach($uvrestypeopendaysfeed as $uvdayresdate => $uvrestypeday){
			$uvdaystatus = $uvrestypeday[1]["daystatus"];
			$uvdaytimezone = $uvrestypeday[2]["timezone"];	
			$uvdaytimeidet = $uvrestypeday[3]["timezoneidentifier"];
			$uvdayrestype = $uvrestypeday[0]["restypes"][0];
				
			if(($uvdaystatus == "Open") and ($uvdayrestype["status"] == "Open") and ($uvdayrestype["blockwebsubmission"] != 1)){
				$uvretypeopendays["$uvdayresdate"] = $uvdayresdate;
			}
		}
		
	$uvretypeopendays = json_encode($uvretypeopendays);
	$uvretypeopendays = $uvretypeopendays ? $uvretypeopendays : "\"\"";
		
	return $uvretypeopendays;
}
function uv_cut_string($uvtextstring, $uvnchars = "60", $uvaddto = "...", $uvnlines = ""){
	$uvtextstring = str_replace("<br />", "wwbrww", $uvtextstring);
	$uvtextstringnew = explode(";,;", wordwrap($uvtextstring, $uvnchars, ";,;"));
	$uvtextstring = count($uvtextstringnew) > 1 ? $uvtextstringnew[0] . $uvaddto : $uvtextstring;
	$uvtextstring = str_replace("wwbrww", "<br>", $uvtextstring);
	
	if($uvnlines){
		$uvbrlines = explode("<br>", $uvtextstring);
		if(count($uvbrlines) >= $uvnlines){
			$uvtextstring = "";
			for($i=0; $i<$uvnlines; $i++){
				$uvtextstring .= $uvbrlines[$i];
				$uvtextstring .= ($i < ($uvnlines - 1)) ? "<br>" : "";
			}
			$uvtextstring .= $uvaddto;
		} 
	}
	
	return $uvtextstring;
}
function uv_get_imsize($uvimwidth, $uvimheight, $uvlimit, $uvimlet = "KT"){
	$uvimlimprop = ($uvimwidth >= $uvimheight) ? $uvlimit / $uvimwidth : $uvlimit / $uvimheight;
	$uvimsize = ceil($uvimwidth * $uvimlimprop) . $uvimlet . ceil($uvimheight * $uvimlimprop);
	
	return $uvimsize;
}
function uv_get_eventlisthtml($uveventlisttemplate, $uvineventtemplate = "default"){
	global $uvlib_global, $uvlib_designtemplates;
	
	$uveventitemtemplate = $uvlib_designtemplates[$uveventlisttemplate][$uvineventtemplate]["template"];
	$uveventflyerpcode = $uvlib_designtemplates[$uveventlisttemplate][$uvineventtemplate]["flyerprioritycode"];
	
	$uvvenueevents = uv_get_feed("events", "uv" . $uvlib_global["uvvenueid"]);
	$uvvenueeventshtml = "";
	
	if($uvvenueevents){
		$uvvenueevents = $uvvenueevents["events"];
		
		if(is_array($uvvenueevents))
			foreach($uvvenueevents as $uvvenueevent){
				$eventflyer = "";
				$eventid = $uvvenueevent["id"];
				$eventname = $uvvenueevent["name"];
				$eventdate = $uvvenueevent["date"];
				$eventflyers = $uvvenueevent["flyers"];
				$eventfrecurring = $uvvenueevent["flyers_recurrent"];
				$eventlink = uv_get_event_link($uvvenueevent);
				
				$eventflyer = uv_get_flyer($eventflyers, $uveventflyerpcode);
				$eventflyer = is_array($eventflyer) ? $eventflyer : uv_get_flyer($eventfrecurring, $uveventflyerpcode);
				$eventflyerfolder = $eventflyer["flyer_folder"];
				$eventflyerfile   = $eventflyer["flyer_file"];
				$eventflyer = "$eventflyerfolder/800KT400/$eventflyerfile";
				
				$uveventitemhtml = str_replace(array("{eventlink}", "{eventflyer}"), array($eventlink, $eventflyer), $uveventitemtemplate);
				
				if($eventflyer)
					$uvvenueeventshtml .= $uveventitemhtml;
			}
	}
	
	return $uvvenueeventshtml;
}



/*OLD UVTIX FUNCTIONS (Need to be replaced)*/
function uvGetUvTixItems($uvfeedtoken){
	global $uv_testfeeds;

	$uvtixfeedurl = "https://urtickets.club/api/XRO/kyuvtix-vdwuuboja0{$uvfeedtoken}/itemsvenue.pc8";
	$uvtixfeed = uv_file_get_contents($uvtixfeedurl);
	
	if($uv_testfeeds) echo("UV Debug: Items feed called: $uvtixfeedurl");
	
	return $uvtixfeed;
}
$urcart_class = "";
$map_exists = false;
function uvGetUvTixByType($uvtixitems, $uvtixtype){
	global $urcart_class, $map_exists, $hidetiers, $test, $dyna_include_urlpath, $dyna_token, $dyna_tokenaffid, $dyna_clientid;

	if($uvtixitems["tabs"][0]){
		$aux = 0;
		foreach($uvtixitems["tabs"][0]["tab"] as $tabs){
			$validtabs[] = $tabs["catid"][0];
		}
		//print_r($validtabs);
		
		$btn_viewtabshow=0;
		if(in_array("Cmaptable", $validtabs))
			$btn_viewtabshow=1;
		
		foreach ($uvtixitems["tixx"][0] as $arritmkey => $arritm){
			if($arritm and $arritm[0]["displayname"][0] == $uvtixtype){
				$itemcatname = $arritmkey;
				
				
				if(!in_array($itemcatname, $validtabs))
					continue;								

				$itemdisplayname = $arritm[0]["displayname"][0];
				$numitems = $arritm[0]["numitems"][0];
				$itmlayout = $arritm[0]["layouts"][0]["layout"];
				$itmtable = urcart_tablecreate($itmlayout);
				$aux++;
						
				if($aux==1)
					$addclass="active in";
				else
					$addclass="";	
				
				$addclass2="";
				$tabicon = "fa-ticket";
				$tabtoogle = "data-toggle='tab' href='#tab-$aux'";
				if($itemdisplayname == "Packages")
					$tabicon = "fa-cubes";
				if($itemdisplayname == "Tables"){
					$tabicon = "fa-glass";
					$addclass2 ="uvtabbable";
					if($map_exists===true)
						$tabtoogle = "";
				}
				if($itemdisplayname == "Frees")
					$tabicon = "fa-tags";
				
				$itemsinfo = $arritm[0]["tix"][0];
				$cont = 0;
				foreach ($itemsinfo as $iteminfo)
				{				
					$rowdata = "";
					$iteminfo = $iteminfo[0];
					$itmid=$iteminfo["id"][0];
					$itmname=$iteminfo["name"][0];
					
					$itmdescr=$iteminfo["descr"][0];	
					$itmcatid = $iteminfo["catid"][0];
					$itmcatname = $iteminfo["catname"][0];
					$itmallowlead = $iteminfo["allowlead"][0];
					
					//echo("<br> hola: $itmallowlead");
					
					$itmglobalname = $iteminfo["globaltype"][0];
					
					$itmmapid = $iteminfo["mapid"][0];
					$itminfo = $iteminfo["terms"][0];
					$itmtermstring = $iteminfo["termstring"][0];
	
					$itmstate = $iteminfo["state"][0];
					$itmlineorder = $iteminfo["lineorder"][0];
					$itmcapacity = $iteminfo["capacity"][0];
					$itmmaxguests = $iteminfo["maxguests"][0];
					$itmovercharge = $iteminfo["overcharge"][0];
					$itmbaseprice = money($iteminfo["baseprice"][0],2);
					$itmdepositperc = $iteminfo["depositperc"][0];
					$itmglobaltype = $iteminfo["globaltype"][0];
					$itmdarrivebytime = $iteminfo["darrivebytime"];
					$itmstock = $iteminfo["stock"];
					$itmgender = $iteminfo["gender"]; 
					
					//! TO DISPLAY SOLD OUT
					$itmstate = $iteminfo['state'][0];
					$itmstatename = $iteminfo['statename'][0];
					$itmnotavailable = 0;
											
					
					if($itmstate != 7 and $itmstate != 4)
					{
						$itmnotavailable = 1;
					}
					///////////////////////////
					
					$itmspecialoffer=$iteminfo["specialoffer"][0];
					$itmtixtriggers=$iteminfo["tixtriggers"][0];
					$addlab="";
					if($itmtixtriggers && !$hidetiers)
					{
						for ($t=0;$t<count($itmtixtriggers)-1;$t++)
						{
							$dtier=money($itmtixtriggers[$t],2);
							
							$rowdata.="<li>
											<div class='uv_wrap uv-clearfix uv_wrap_tier'> 
												<div class='uv_col uv_col_tier'>$itmname - Tier ". ($t+1) ." (Sold out)</div>
												<div class='uv_col uv_col_tier'></div>
												<div class='uv_col uv_col_tier uv_col_tier_price'> $dtier </div>
												<div class='uv_col uv_col_tier'></div>
												<div class='uv_col uv_col_tier'></div>
											</div>
										</li>";					
						}
						$addlab="- Tier ". ($t+1);
					}
					
					
					$itmadddescr="";
					if($itmspecialoffer)
						$itmadddescr=$itmspecialoffer;
					elseif($itmdescr)
						$itmadddescr=$itmdescr;
						
					/*OLD CODE
					if($itmadddescr and (strlen($itmadddescr) > 250))
						$itmadddescr = "<a class='urcart_terms' href='javascript:;' data-terms='$itmadddescr'>more info</a>";
					else
						$itmadddescr = "<p>$itmadddescr</p>";
					*/
					
					if($itmadddescr and (strlen($itmadddescr) >115)){
						$shortdescr  = substr($itmadddescr, 0, 115)."..."; 
						$itmadddescr = "<p>$shortdescr <a class='urcart_terms' href='javascript:;' data-terms='$itmadddescr'>more info</a></p>";
					}else
						$itmadddescr = "<p>$itmadddescr</p>";
					
					$urcart_class = "urcart_item urcart_$itmid' data-urcart-type='$itemcatname' data-urcart-item='$itmid' ";
					$srtselect="";
					
					$urcat_classp="urcart_price urcart_p$itmid";
					$urcat_classm="urcart_price urcart_m$itmid";
					$urcat_classd="urcart_price urcart_d$itmid";
					
					//! TO DISPLAY SOLD OUT
					$qtyselect = null;
					if(!$itmnotavailable)
					{
					
						switch($itmglobaltype)
						{
							case "tickets":
								$qtyselect = urcart_ticketselect($itmmaxguests);
								if(!$addb)
									$addb="";
								break;
							case "table":
								$qtyselect = urcart_tableselect($itmmaxguests,$itmcapacity);
								$addeventid="";
								if($dyna_eventid)
									$addeventid="ev{$dyna_eventid}";
								$addb="<a href='{$uvsiteurl}/map/{$addeventid}dt{$tokendate}{$token_globalstring}/' class='btn btn-danger left pull-right uv_schemebutton' id='urcart_map'>
										<i class='ace-icon fa fa-glass align-top bigger-125'></i>
											View Map
								</a>";
								break;
							case "package":
								$qtyselect = urcart_tableselect($itmmaxguests,$itmcapacity);
								if(!$addb)
									$addb="";
								break;
							
							case "freeguestlist":
								$qtyselect = 1;
								if(!$addb)
									$addb="";
								break;
								
							default:
								$qtyselect = urcart_ticketselect($itmmaxguests);
								if(!$addb)
									$addb="";					
			
						}
					}
					else
					{
						$itmbaseprice = $itmstatename;
					}
					
									
					if($cont%2==0)
						$trclass = "tr1";
					else
						$trclass = "tr2";
						
					$rowdata .= "<li class='uv_item uv_item_$itmid t_Tickets uvtixcartitem'><div class='uv_wrap uv-clearfix'>";
					foreach($itmlayout as $itmlayoutfield)
					{
						$tdclass = "";	
						$tdvalue = "";
						switch ($itmlayoutfield["layoutvar"][0])
						{
							
							case "itemname":
								$tdvalue = "<div class='uv_col'>$itmname {$addlab} $itmadddescr</div>";
							break;
							
							/*
case "descr":
								$tdvalue = "<div class='uv_col clearfix'>$itmdescr</div>";
							break;
*/
							
							case "dates":
								$tdvalue = $itmddate;
							break;
		
							case "guests":
								$tdvalue = "<div class='uv_col'>$qtyselect</div>";
								$tdclass = "center";
							break;
		
							case "total":
								if($itmglobaltype == "freeguestlist")
								{
									$tdvalue = "<div class='uv_col'><label class='$urcat_classp'>$itmdarrivebytime</label></div>";
									$tdclass = "center";
									
								}
								else
								{
									$tdvalue = "<div class='uv_col'><label class='$urcat_classp'>$itmbaseprice</label></div>";
									$tdclass = "cartright urcart_deactive";
									
								}
								
							break;
		
							case "terms":
								//$tdvalue = "<div class='uv_col'><a href='javascript:;' class='urcart_terms' data-terms='$itminfo<br>'>Prepay <i class='fa fa-info'></i></a></div>";
								$tdvalue = "<div class='uv_col'><a href='javascript:;' class='urcart_terms' data-terms='$itminfo<br>'>$itmtermstring</a></div>";

								$tdclass = "center hidden-480";
								if($itmglobaltype == "freeguestlist")
								{
									$tdvalue = "<div class='uv_col'></div>";
									$tdclass = "";
									
								}

							break;
							case "button":
								//$tdvalue = "$itmtermstring";
								$tdclass = "hidden-480";
							break;
	
		
							case "tablefee":
								$tdvalue = $itmtablefee;
								$tdclass = "cartright hidden-480";
							break;
		
							case "minspend":
								$tdvalue = "<label class='$urcat_classm'>$itmminimum</label>";
								$tdclass = "cartright urcart_deactive";
							break;
		
							case "deposit":
								$tdvalue = "<label class='$urcat_classd'>$itmdepositamount</label>";
								$tdclass = "cartright urcart_deactive";
							break;
		
							case "baseamount":
								$tdvalue = $itmbaseamount;
								$tdclass = "cartright";
							break;
		
							default;
								echo  "";
						}
						$rowdata .= "$tdvalue";	
					}
					//! TO DISPLAY SOLD OUT INQUIRY
					if(!$itmnotavailable){
						$itminqurl = $dyna_include_urlpath . "/uvcore/{$dyna_token}{$dyna_tokenaffid}it{$itmid}ci{$dyna_clientid}/uvinquiry/";
					
						$addrowclass = ($itmallowlead == 1) ? "uv-leadallowed" : "";
						$addleadbtn = ($itmallowlead == 1) ? "<button class='uv-btn-s uv-inq-req uvjs-showpop' data-popload='$itminqurl' data-popexpand='600'>Request</button>" : "";
						
						
						if($itmglobaltype == "freeguestlist")
						{	
							if($itmstock>0)
							{	
								$rowdata .= "<div class='uv_col $addrowclass' id='fgldiv-$itmid'>$addleadbtn<button class='uv-btn-s uv-btn-100 uv-claimgl' data-itmid='$itmid' data-itmname='$itmname' data-itmstock='$itmstock' data-itmdabtime='$itmdarrivebytime' data-gendervalue='$itmgender' id='fglbtn-$itmid'>Sign Up<span> </span></button></div></div></li>";
							}
							else
							{
								$rowdata .= "<div class='uv_col $addrowclass' id='fgldiv-$itmid'>$addleadbtn<label class='showsold'>Out of Stock</label></div></div></li>";	
							}	
						}
						else
						{
							$rowdata .= "<div class='uv_col $addrowclass'>$addleadbtn<button class='uv-btn uv-btn-s uv-btn-100 uv-additems'>Add <span> to Cart</span></button></div></div></li>";
						}
						
											
					}
					else
					{
						$rowdata .= "<div class='uv_col'></div></div></li>";
					}
					
					$sviewsubtab .= $rowdata;						
					$cont++;
				}		
			}	
		}
	}
	if($uvtixtype=="Guest List")
		$sviewsubtab=$itemsinfo;
	return $sviewsubtab;
}
function urcart_tablecreate($itmlayout){
	$itmtable .= "
	<table class='table uv_tablecart table-striped table-hover'>
		<tr class='uv_tr_headers'>
	";
	$rowf=count($itmlayout);
	$auxx=0;
	foreach($itmlayout as $itmlayoutfield)
	{
		
		$thclass = "";
		if($itmlayoutfield['layoutvar'][0] == "info" || $itmlayoutfield['layoutvar'][0] == "tablefee")
			$thclass = "hidden-480";
		if($itmlayoutfield['layoutvar'][0] == "guests")
			$thclass = "center";
		if($itmlayoutfield['layoutvar'][0] == "total" || $itmlayoutfield['layoutvar'][0] == "baseamount")
			$thclass = "cartright";
		
		if($itmlayoutfield['layoutvar'][0] == "info" || $itmlayoutfield['layoutvar'][0] == "terms")
			$thclass.= " center ";
		
		if($itmlayoutfield['layoutvar'][0] == "minspend" || $itmlayoutfield['layoutvar'][0] == "deposit")
			$thclass.= " cartright ";
		if($auxx!=$rowf-1)
		{
		$itmtable .= "
			<th class='$thclass'>{$itmlayoutfield['layoutname'][0]}</th>
		";
		}
		else
			$itmtable .= "<th class='$thclass'></th>";
			
		$auxx++;
	}
	$itmtable .= "
		</tr>";
	return $itmtable;
}


function urcart_ticketselect($itmmaxguests){
	global $urcart_class;
	if($itmmaxguests>0){
		$srtselect.="<select class='form-control $urcart_class' data-urcart-tag='1'>";
		for($pq=0;$pq<=$itmmaxguests;$pq++)
		{
			$srtselect.="<option value='$pq'>$pq</option>";
		}
		$srtselect.="</select>";
	}
	else{
		$srtselect="<label class='$urcart_class' data-urcart-tag='2'>1</label>";
	}	
	return $srtselect;
}

function urcart_tableselect($itmmaxguests,$itmcapacity){
	global $urcart_class;
	global $map_exists;
	if(!$itmmaxguests)
		$itmmaxguests = $itmcapacity;
	$srtselect.="<select class='form-control $urcart_class' data-urcart-tag='1'>";
	if($itmcapacity == $itmmaxguests)
	{
		$srtselect.="
		<option value='0' selected>0</option>
		<option value='$itmcapacity'>$itmcapacity</option>";
	}
	else
	{	
		$srtselect.="<option value='0' selected>0</option>";

// 		for($pq=$itmcapacity;$pq<=$itmmaxguests;$pq++)
 		for($pq=1;$pq<=$itmmaxguests;$pq++)

		{
			if($pq == $itmcapacity)	
				$srtselect.="<option value='$pq'>$pq</option>";
			else
				$srtselect.="<option value='$pq'>$pq</option>";
		}
	}	
	$srtselect.="</select>";
	return $srtselect;
}
if(!$f_money)
{
 $f_money=1;

 function percentage($number)
 {
  $number*=100;
  $number=number_format($number, 2);
  $number.="%";
  return($number);
 }

 function money($money, $decimals=0)
 {
  global $zc8_curprefix;
  
  if(!$zc8_curprefix)
   $zc8_curprefix="$";
  if(!$money)
  {
   return("");
  } 
//  if($money==0.1)
//  {
//   return("FREE");
//  }
  else
  {
  
   if($decimals)
   {
    $money/=100;
    $money=number_format($money, $decimals);
    $money=$zc8_curprefix.$money;   
   
   }
   elseif($money%100)
   {
    $money/=100;
    $money=number_format($money, 2);
    $money=$zc8_curprefix.$money;
   }
   else
   {
    $money/=100;
    $money=number_format($money, 0);
    $money=$zc8_curprefix.$money;  
   }
   return($money);
  }
 }

 function nmoney($money)
 {
  $money/=100;
  $money=number_format($money, 2);
  $money=str_replace(",", "", $money);
  return($money);
 }

 function zmoney($money)
 {
  return($money);
 }
}


