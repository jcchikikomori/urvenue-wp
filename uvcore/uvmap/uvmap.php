<?php 
	if(!$uvmap_redirect3dmap)
	{
		@include_once("{$uvmap_php_path_include}map.commingsoon.php");
		exit();
	}
	
	//For mobile version
	include_once("{$uvmap_php_path_include}mobile.detect.php");
	$mobile_detect_obj = new Mobile_Detect();
	if(($mobile_detect_obj->isMobile()) && $force_map == false){
		$mapismobile = true;
		$istablet = false;
	}
	if($mobile_detect_obj->isTablet()  && $force_map == false){
		$mapismobile = false;
		$istablet = true;
	}
	$maptypeofview = $mapismobile ? "uvmap-mapmobile" : "uvmap-mapdesktop";
		
	//Detect dyna date
	$dyna_date = isset($_REQUEST["date"]) ? $_REQUEST["date"] : "";
	if(!$dyna_date)
	{
		$strdate = date("Y-m-d");
		$enddate = date("Y-m-d", strtotime("+1 month $strdate"));
		$days_data = @file_get_contents("http://$uvmap_uvserver/api/v1/venues/$uvmap_venueid/daystatus.pc8?startdate=$strdate&enddate=$enddate");
		
		$result = check_day($days_data, $uvmap_request3dtable_restypeid);						
	}
	else
	{
		$days_data = @file_get_contents("http://$uvmap_uvserver/api/v1/venues/$uvmap_venueid/daystatus.pc8?startdate=$dyna_date&enddate=$dyna_date");
		
		$result = check_day($days_data);					
	}
	
	$days_found 		= $result["days_found"];
	$date2load 			= $result["date2load"];
	$days_caldate_fmt 	= $result["days_caldate_fmt"];
	$tablereq_url 		= $result["tablereq_url"];
		
	if($days_found == true)
	{
		$mapdate = $date2load;
		$mapddate = date("D, M j, Y", strtotime($mapdate));
		$mapday = date("d", strtotime($mapdate));
		$mapmon = date("M", strtotime($mapdate));
		$shortdate = str_replace("-","",$mapdate);
		$shortdate = substr($shortdate, 2);		
	}
	else
	{
		$mapddate = $mapdate = $mapday = $mapmon = $shortdate = "";	
	}
	
	$eventid = !isset($eventid) ? $dyna_tokenshorts["ev"][0] : $_REQUEST["event"]; 
	$roomid = !isset($roomid) ? $dyna_tokenshorts["rm"][0] : $_REQUEST["roomid"]; 
	
	$uvmap_maptitle = isset($uvmap_maptitle) ? $uvmap_maptitle : "Bottle Service";
	
	function check_day($days_data, $uvmap_reqid){
		//global $uvmap_request3dtable_restypeid;
		
		$response = Array();
		
		$days_found = false;
		if($days_data){
			@eval($days_data);
			
			$days_blockeddays = Array();		
			foreach($xc8 as $days_caldate=>$days_date){
				$days_daystatus = $days_date["daystatus"][0];
				
				foreach($days_date["restypes"] as $days_restype){
					if($days_restype["restypeid"] == $uvmap_reqid){
						if(($days_daystatus != "Closed") and ($days_restype["status"] != "Closed")){
							$date2load = $days_caldate;
							$days_caldate_fmt = date("ymd", strtotime($days_caldate));
							$tablereq_url .= "/dt$days_caldate_fmt";
							$days_found = true;
														
							break;
						}
					}
				}
				if($days_found === true)
				{
					$response["days_found"] = $days_found;
					$response["date2load"] 	= $date2load;
					$response["days_caldate_fmt"] = $days_caldate_fmt;
					$response["tablereq_url"] = $tablereq_url;
					break;
				}
			}
		}
		
		return $response;
	}
	
	$show_tablet = ($istablet) ? "" : "uvmap-hide";
?>

<link rel="stylesheet" type="text/css" href="//uvtix.com/websites/ln_core/uvmapv2/uvmap.wp.css" />
<link rel="stylesheet" type="text/css" href="//uvtix.com/websites/<?=$uvmap_dyna_webcode;?>/css/custom.map.<?=$uvmap_venueid;?>.css" />
<div class="uvmap-section <?=$maptypeofview;?>">
	<div id="map-shadow" class="uvmap-hidden uv-pop-cont">
		<div class="uvmap-mapdatecont">
			<a class="uvmap-mapshowmap" href="javascript:;"><i class="fa fa-times"></i></a>
			<h4>Select a Date</h4>
			<div id="uvmap-mapdate"></div>
			<input type="hidden" name="mapdate" value="<?=$mapdate;?>">
		</div>
	</div>

	<div class="uvmap-section-inner uvmap-section-wide graybg p30 minh400 uvmap-clearfix">		
		<?php
		if($uvmap_allowcartsingletables)
		{
		?>
		<div class="uvmap-map-cart" style="display:none;">
			<div class="uvmap-map-cart-info">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				<div class="uvmap-map-cart-count">0</div>			
			</div>
			<div class="uvmap-map-cart-list uvmap-hide">
				<div class="uvmap-map-cart-list-header">
					<h4>My Cart</h4>
					<a class="uvmap-map-cart-list-close" href="javascript:;"><i class="fa fa-times"></i></a>
				</div>
				<div class="uvmap-map-cart-list-inc">
					<ul class="list-items-cart"></ul>
				</div>
			</div>
		</div>
		<?php
		}
		?>
		
		<div class="uvmap-integration uv-integration uvmap-mapcont uvmap-room-<?=$maproomclass;?>">
			<div class="uvmap-mapinfo uvmap-clearfix">
				<h1><?=$uvmap_maptitle;?></h1>
				<div class="uvmap-mapoptions">
					<button class="uv-btn uvmap-btn-dark uvmap-mapchangedate"><i class="fa fa-calendar"></i><span class="uvmap-putmapddate"><?=$mapddate;?></span></button>					
					<div class="uvmap-roomdropdown uvmap-hide">
						<button class="uv-btn uvmap-btn-light" type="button" uvmap-dropdown="#uvmap-maproomselection">
							<i class="fa fa-navicon"></i> <span class="uvmap-putmaproomname"></span> <i class="fa fa-caret-down"></i>
						</button>
					
						<ul id="uvmap-maproomselection" class="uvmap-hide"></ul>
  					</div>
					<?php if($show_floorplan_image_url) { ?>
  						<button class="uv-btn uvmap-mapfloorplan" data-image="<?=$show_floorplan_image_url;?>"> <i class="fa fa-picture-o"></i><span>Floor Plan</span></button>
  					<?php } ?> 					
  					<button class="uv-btn uvmap-btn-light uvmap-showlistitems uvmap-hide scrolltoitems"><i class="fa fa-usd"></i><span>Compare Tables</span></button>
					<div class="uvmap-evendropcont">
						<button class="uv-btn uvmap-btn-light uvmap-showeventinfo" type="button" data-toggle="dropdown"><i class="fa fa-info"></i><span>Event Info</span></button>
						
						<div class="dropdown-menu uvmap-dropdownmenu uvmap-dropeventinfo text-center uvmap-hide">
							<h2 class="uvmap-puteventname"></h2>
							<div class="uvmap-mapflyer uvmap-mapflyer"></div>
						</div>
					</div>
					
					<div class="uv-clearfix"></div>				
				</div>
				
				<div class="uvmap-eventinfonodrop uvmap-dropeventinfo text-center">
					<h2 class="uvmap-puteventname"></h2>
					<div class="uvmap-mapflyer"></div>						
					<?php if($uvmap_mapcolorcoding) { ?>	
					<div class="uvmap-colorcoding uvmap-hide"><ul></ul></div>
					<?php } ?>
				</div>				
				<div class="uvmap-maplistcontainer uvmap-hide">
					<div class="uvmap-maplistheader">
						<h4>Compare Tables</h4>
						<a class="uvmap-mapcompareclose" href="javascript:;"><i class="fa fa-times"></i></a>
					</div>
					<div class="uvmap-maplist">
						<ul class="list-items"></ul>
					</div>
					<div class='uvmap-res3dform'></div>
				</div>
				<div class="uv-clearfix"></div>				
			</div>

			<?php if(!$mapismobile){ ?>
				<script src='//uvtix.com/websites/ln_core/uvmapv2/uvmap.wp.desktop.js'></script>
				<div class='uvmap-map'></div>
			<?php } ?>
			<?php if($uvmap_mapcolorcoding) { ?>
			<div class="uvmap-colorcoding uvmap-colorcoding-720less uvmap-hide"><ul></ul></div>
			<?php } ?>
		</div>
		<div class="uv-clearfix"></div>
	</div>
	
	<div class="uvmap-maptablet <?=$show_tablet;?>">
		<div class="uvmap-section-inner uvmap-section-wide graybg pb30 uvmap-comparebtn text-center">
			<button class="uvmap-btnoptlight uvmap-showlistitems uvmap-hide" scrolltoitems>[icon-list] <span>Compare Tables</span></button>
		</div>
		<div class="uvmap-section-inner uvmap-section-wide whitebg pt20 pb30 uvmap-clearfix uvmap-tabletevent">
			<div class="uvmap-maptabletevflyer">
				<div class="uvmap-mapflyer"></div>
			</div>
			<div class="uvmap-maptabletevinfo">
				<h1 class="uvmap-puteventname"></h1>
				<h2 class="uvmap-putmapddate"><?=$mapddate;?></h2>
				<p class="uvmap-puteventdescr"></p>
			</div>
			<div class="uv-clearfix"></div>
		</div>
	</div>
	<div class="uv-clearfix"></div>
</div>
<div class="uv-clearfix"></div>

<script src="//uvtix.com/websites/ln_core/js/uvtix.js"></script>
<script src="//uvtix.com/websites/ln_core/js/jquery.validate.min.js"></script>
<script src="//uvtix.com/websites/ln_core/js/jquery.form.min.js"></script>
<script src="//uvtix.com/websites/ln_core/js/jquery.tooltip.js"></script>
<?php   
	if($mapismobile)
		echo "<script src='//uvtix.com/websites/ln_core/uvmapv2/uvmap.wp.mobile.js'></script>";

	echo "<script> var uvmapShortDate	='{$shortdate}'; </script>";
	echo "<script> var uvmapFloor 		= '$map_default_floor'</script>";
	echo "<script> var uvmapBackendUrl 	= '$uvmap_uvserver'; </script>";
	echo "<script> var uvmapVenueid 	= '$uvmap_venueid'; </script>";
	echo "<script> var uvmapResTypeId 	= '$uvmap_request3dtable_restypeid'; </script>";	
	echo "<script> var uvmapCalendarEvts= '$calendarevents'; </script>";
	echo "<script> var uvmapRoomid		= '{$roomid}'; </script>";
	echo "<script> var uvmapApiurl 		= '$uvmap_apiurl'; </script>";
	echo "<script> var uvmapUrl 		= '$uvmap_mapurl'; </script>";
	echo "<script> var uvmapReq3dTable	= '$uvmap_request3dtable'; </script>";
	echo "<script> var uvmapIsMobile 	= '$mapismobile'; </script>";	
	echo "<script> var uvmapFloorJson 	= '".json_encode($uvmap_mapdef_floors)."'</script>";
	echo "<script> var uvmapMicrosite 	= '$uvmap_dyna_webcode'; </script>";	
	echo "<script> var uvmapExtSiteUrl 	= '$uvmap_extsiteurl'; </script>";
	echo "<script> var uvmapEventId		= '{$eventid}'; </script>";	
	echo "<script> var uvmapIsTablet 	= '$istablet'; </script>";	
	echo "<script> var uvmapResFormMaxReq 	= '$resform_maxguest'; </script>";	
	echo "<script> var uvmapHideSoldTables 	= '$uvmap_hide_soldtables'; </script>";		
	echo "<script> var uvmapMapColorCoding 	= '$uvmap_mapcolorcoding'; </script>";	
	echo "<script> var uvmapHidePricesList 	= '$uvmap_hideprices'; </script>";
	echo "<script> var uvmapTokenGlobalString 	='{$token_globalstring}'; </script>";
	echo "<script> var uvmapShowPurchaseInquiry = '$uvmap_show_purchase_inquiry'; </script>";	
	echo "<script> var uvmapMobileMapButtonTitle 	= '$uvmap_mobilemapbuttontitle'; </script>";	
	echo "<script> var uvmapAllowCartSingleTables 	= '$uvmap_allowcartsingletables'; </script>";		
	echo "<script> var uvmapMobileMapPulldownTitle 	= '$uvmap_mobilemappulldowntitle'; </script>";	

	echo "<script src='//uvtix.com/websites/ln_core/uvmapv2/uvmap.wp.js'></script>";

?>	
