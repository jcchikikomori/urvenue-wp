<?php 

	$uvacode = isset($ac) ? $ac : $_REQUEST["ac"];
	$uvphotoalbum = uv_get_feed("photoalbum", array("albumcode" => $uvacode));
	$uvpathumbsize = uv_get_imsize($uvg_lib["pwidth"], $uvg_lib["pheight"], "250", "SC");
	$uvpabigpicsize = "800SC0";
	$uvpathumbprop = ($uvg_lib["pheight"] / $uvg_lib["pwidth"]) * 100;
	$uvpalistitemtemplate = $uvlib_designtemplates["albumlistitem"]["default"]["template"];
	
	if(is_array($uvphotoalbum["xc8"][0]["album"][0])){
		$uvphotoalbum = $uvphotoalbum["xc8"][0]["album"][0];
		$uvpaname = $uvphotoalbum["albumname"];
		$uvpaddate = date("l, F j, Y", strtotime($uvphotoalbum["albumdate"]));
		
		if(is_array($uvphotoalbum["pics"][0]["pic"]))
			foreach($uvphotoalbum["pics"][0]["pic"] as $uvpic){
				$uvpicfolder = $uvpic["picpath"];
				$uvpicfile = $uvpic["picfile"];
				
				$uvpicthumburl = $uvpicfolder . "/$uvpathumbsize/" . $uvpicfile;
				$uvpicbigurl = $uvpicfolder . "/$uvpabigpicsize/" . $uvpicfile;
				$uvpiclinkclass = ($uvpic === reset($uvphotoalbum["pics"][0]["pic"])) ? "uvjs-setpic active" : "uvjs-setpic";
				$uvpiclinkparams = "data-bigpic='$uvpicbigurl'";
				$uvfirsbigpic = ($uvpic === reset($uvphotoalbum["pics"][0]["pic"])) ? $uvpicbigurl : $uvfirsbigpic;
				
				$uvpicitemhtml = str_replace(array("{linkclass}", "{linkparams}", "{thumbnail}"), array($uvpiclinkclass, $uvpiclinkparams, $uvpicthumburl), $uvpalistitemtemplate);
				
				$uvpicshtml .= $uvpicitemhtml;
			}
	}
?>
<div class="uv-integration uv-photoalbumvisor">
	<div class="uv-popvisorheader">
		<div class="uv-pa-title"><?=$uvpaname;?></div>
		<div class="uv-pa-date"><?=$uvpaddate;?></div>
	</div>

	<style>
		.uv-pa-list-default .uv-pa-item:before{
			padding-top: <?=$uvpathumbprop;?>%;
		}
		.uv-pa-picvisor:before{
			padding-top: <?=$uvpathumbprop;?>%;
		}
	</style>
	
	<a class="uvjs-pa-prevpic uv-outer-aleft" href="javascript:;"></a>
	<a class="uvjs-pa-nextpic uv-outer-aright" href="javascript:;"></a>

	<div class="uv-pa-picvisor">
		<div class="uv-pa-picharge"><img class="uv-loadfade" src="<?=$uvfirsbigpic;?>"></div>
	</div>
	<div class="uv-pa-list uv-pa-list-default uv-clearfix"><?=$uvpicshtml;?></div>
</div>
<script>uvLoadFade();</script>






