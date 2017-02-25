<?php

	$uvgallery = uv_get_feed("photogallery", array("galleryids" => "$id"));
	
	if(is_array($uvgallery["xc8"][0]["gallery"][0]["albums"][0]["album"])){
		$uvgallery = $uvgallery["xc8"][0]["gallery"][0]["albums"][0]["album"];
		$uvalbumthumimsize = uv_get_imsize($uvg_lib["pwidth"], $uvg_lib["pheight"], "400", "SC");
		$uvalbumthumprop = ($uvg_lib["pheight"] / $uvg_lib["pwidth"]) * 100;
		$uvalbumdesigntemplate = $uvg_lib["albumdesigntemplate"];
		$uvalbumitemtemplate = $uvlib_designtemplates["photoitem"][$uvalbumdesigntemplate]["template"];
		$uvninitalbums = $uvg_lib["ninitalbums"];
		$uvloadmoreitems = Array();
		$uvlib_global["uniqueintid"]++;
		$uvalbumintunicode = "photogallery" . $uvlib_global["uniqueintid"];
		$uvalbumloadpopurl = $uvg_lib["loadalbumurl"];
	
		foreach($uvgallery as $uvalbum){
			$uvalbumname = $uvalbum["albumname"];
			$uvalbumdate = $uvalbum["date"];
			$uvalbumcode = $uvalbum["albumcode"];
			$uvalbumddate = date($uvg_lib["albumdatephpformat"], strtotime($uvalbumdate));
			$uvalbumfolder = $uvalbum["albumpicpath"];
			$uvalbumfile = trim(preg_replace("/\s\s+/", "", $uvalbum["thumbnail"]));
			$uvalbumthumbnail = $uvalbumfolder . "/$uvalbumthumimsize/" . $uvalbumfile;
			
			$uvalbumitemhtml = str_replace(array("{thumbnail}", "{name}", "{ddate}", "{linkclass}", "{linkparams}"), array($uvalbumthumbnail, $uvalbumname, $uvalbumddate, "uvjs-loadalbumpop", "data-albumcode='$uvalbumcode' data-loadpopurl='$uvalbumloadpopurl'"), $uvalbumitemtemplate);
			
			if($uvninitalbums){
				$uvgalleryhtml .= $uvalbumitemhtml;
				$uvninitalbums--;
			}
			else
				$uvloadmoreitems[] = $uvalbumitemhtml;
		}
	}
	
	$uvloadmoreitemsscript = (count($uvloadmoreitems) > 0) ? json_encode($uvloadmoreitems) : "\"\"";
	$uverrornogals = "<h3 class='uv-nocontmsg'>There are no albums at this time</h3>";
?>
	
<?php if($uvgalleryhtml){ ?>
	<div class='uv-integration uv-photogallery'>
		<style>
			.uv-mosaic-<?=$uvalbumdesigntemplate;?> .uv-mos-item:before{
				padding-top: <?=$uvalbumthumprop;?>%;
			}
		</style>
		<div class='uv-clearfix uv-mosaic uv-mosaic-<?=$uvalbumdesigntemplate;?>'>
			<?=$uvgalleryhtml;?>
		</div>
		<script>
			uv_loadmoreitems["<?=$uvalbumintunicode;?>"] = <?=$uvloadmoreitemsscript;?>;
		</script>
		
		<a class="uv-pwby-cb" href="http://urvenue.com" target="_blank"></a>
	</div>
<?php }else echo($uverrornogals);
		
		
		
		
		
		
		
		
		
		