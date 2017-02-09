<?php
	$uvvenueid = $uvvenueid ? $uvvenueid : $uvlib_global["uvvenueid"];
	$uvpackages = uv_get_feed("packages", "uv$uvvenueid");
	$uvpackagespopurl = $uvlib_global["packagespopurl"];
	
	if($uvpackages){
		$uvpackages = $uvpackages["tixs"];
		$startprices = array();
		
		foreach($uvpackages as $uvpackage){
			$startprices[] = $uvpackage["tix"]["startprice"];
		}
			
		array_multisort($startprices, SORT_ASC, $uvpackages);
			
		foreach($uvpackages as $uvpackage){
			$uvpk = $uvpackage["tix"];
			
			$uvpkid = $uvpk["id"];
			$uvpkname = $uvpk["name"];
			$uvpkimgurl = $uvpk["imageurl"];
			$uvpkdescr = $uvpk["descr"];
			$uvpkstartprice = $uvpk["startprice"];
			$uvpkdstartprice = money($uvpkstartprice, 2);
			$uvpkminguest = $uvpk["minguest"];
			$uvpkmaxguest = $uvpk["maxguest"];
			$uvpkimgurl = str_replace("raw", "300KT300", $uvpkimgurl);
			$uvpkddescr = uv_cut_string($uvpkdescr, 200, " ...<a class='uvjs-hideandshow' href='javascript:;' data-targetshow='.uv-pkdescr-full-$uvpkid' data-targethide='.uv-pkdescr-short-$uvpkid'>read more</a>", 2);
			
			if($uvpkminguest < $uvpkmaxguest){
				$uvpkselect = "<select name='nguests-$uvpkid'>";
				for($i=$uvpkminguest; $i<=$uvpkmaxguest; $i++)
					$uvpkselect .= "<option value='$i'>$i</option>";
				$uvpkselect .= "</select>";
				
				$uvpkguests = "<label>Party Size</label>$uvpkselect";
			}
			else{
				$uvpkselect = "<select name='nguests-$uvpkid'><option value='$uvpkmaxguest'>$uvpkmaxguest</option></select>";
				$uvpkguests = "<div class='uv-pk-hiddenguest'>$uvpkselect</div><div class='uv-pk-guestlabel'><i class='fa fa-users'></i> $uvpkmaxguest Guests</div>";
			}
				
			$uvpkshtml .= "<div class='uv-panel uv-clearfix'><div class='uv-pk-image'><img class='uv-loadfade' src='$uvpkimgurl'></div><h2>$uvpkname</h2><p class='uv-pkdescr-short-$uvpkid'>$uvpkddescr</p><p class='uv-pkdescr-full uv-pkdescr-full-$uvpkid'>$uvpkdescr <a class='uvjs-hideandshow' href='javascript:;' data-targetshow='.uv-pkdescr-short-$uvpkid' data-targethide='.uv-pkdescr-full-$uvpkid'>show less</a></p><div class='uv-pk-options'>$uvpkguests<div class='uv-pk-stprice'>$uvpkdstartprice</div><button class='uv-btn uv-btn-p uvjs-pk-book' data-pkid='$uvpkid' data-pkuv='$uvvenueid' data-pkrm='$uvpkrm' data-pkpopurl='$uvpackagespopurl'>Purchase</button></div></div>";
		}
	}
		
	$uvpkserror = $uvpkserror ? $uvpkserror : "No Packages to show";
?>

<div class="uv-integration uv-packages uv-clearfix">
	<?php if($uvpkshtml){ ?>
		<?=$uvpkshtml;?>
	<?php } else{ ?>
		<h3 class="uv-nocontmsg"><?=$uvpkserror;?></h3>
	<?php } ?>
</div>