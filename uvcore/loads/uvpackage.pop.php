<?php
	$uvpkwb = $uvlib_global["wbcode"];

	$uvpkid = isset($uvpkid) ? $uvpkid : $_REQUEST["uvpkid"];
	$uvpkqty = isset($uvpkqty) ? $uvpkqty : $_REQUEST["uvpkqty"];
	$uvpkuv = isset($uvpkuv) ? $uvpkuv : $_REQUEST["uvpkuv"];
	$uvpkrm = isset($uvpkrm) ? $uvpkrm : $_REQUEST["uvpkrm"];
	
	$uvpkrm = $uvpkrm ? $uvpkrm : "0";
	
	if($uvpkid and $uvpkuv){
		$uvpackagesfeed = uv_file_get_contents("https://urtickets.club/api/XRO/uv{$uvpkuv}it{$uvpkid}kyuvtix-vdwuuboja0/gitemscal.pc8");
		
		$uvpkdates = Array();
		
		if($uvpackagesfeed){
			eval($uvpackagesfeed);
			$uvpkenddate = $xc8["globals"][0]["enddate"];
			$uvpkdays = $xc8["tixx"][0];
			
			if(is_array($uvpkdays))
			foreach($uvpkdays as $uvpkdaydate => $uvpkdate){ 
				$uvpkdate = $uvpkdate[0]["tix"][0];
				$uvpkdateavailable = $uvpkdate["statename"][0];
			
				if($uvpkdateavailable == "Available"){
					$uvpkdate["shortdate"][0] = date("ymd", strtotime($uvpkdaydate));
					$uvpkdates["$uvpkdaydate"] = $uvpkdate;
				}
			}
		}
		
		$uvpkdates = json_encode($uvpkdates);
		$uvpkdates = $uvpkdates ? $uvpkdates : "\"\"";
	}
	
?>


<?php if($uvpkid and $uvpkqty and $uvpkuv){ ?>
<div class="uv-integration">
	<div class="uv-popheader"><h3>Package Name</h3></div>
	<div class="uv-pkpopcont">
		<div class='uv-center'>
			<ul class="uv-ministeps uv-clearfix">
				<li>Select Package</li>
				<li class="active">Details</li>
				<li>Checkout</li>
			</ul>
		</div>
		
		<div class="uv-pk-inputcont">
			<label>Date</label>
			<form class="uv-pkform" action="https://uvtix.com/checkout" method="post">
				<input class="uv-pkckeckshort pk-it" type="hidden" name="it" value="">
				<input class="uv-pkckeckshort" type="hidden" name="gu" value="<?=$uvpkqty;?>">
				<input class="uv-pkckeckshort" type="hidden" name="uv" value="<?=$uvpkuv;?>">
				<input class="uv-pkckeckshort pk-dt" type="hidden" name="dt" value="">
				<input class="uv-pkckeckshort" type="hidden" name="rm" value="<?=$uvpkrm;?>">
				<input class="uv-pkckeckshort" type="hidden" name="wb" value="<?=$uvpkwb;?>0">
				<input class="uv-pkckeckshort" type="hidden" name="md" value="webtix0">
			</form>
			
			<input class="uv-show-pkcalendar uv-pkddate" type="text" name="pkdate" value="" placeholder="Select a Date" readonly>
			
			<div class="uv-pkcalendar uv-resdatepicker visible"></div>
		</div>
		
		<button class="uv-btn uv-btn-p uv-btn-100 uv-pk-gocheck">Continue to Checkout</button>
	</div>
</div>
	
	<script>	
		uv_pkdates = Array();
		uv_pkdates = <?=$uvpkdates;?>;
		
		var pkenddate = "<?=$uvpkenddate;?>";
		pkenddate = pkenddate.replace(/-/g, '/');
		pkenddate = new Date(pkenddate);
		
	
		jQuery(".uv-pkcalendar").datepicker({
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
			firstDay: 1,
			minDate: new Date(),
			maxDate: pkenddate,
			appendText: "<label></label>",
			beforeShowDay: function(pkdate){
				var uvpkformatdate = uvFoDate(pkdate);
				var uvpkdateclass = "uv-date-" + uvpkformatdate;
				
				var uvpkavailabledate = (uv_pkdates[uvpkformatdate] != undefined) ? true : false;
				var uvpkappendprice = (uv_pkdates[uvpkformatdate] != undefined) ? uv_pkdates[uvpkformatdate].dbaseprice[0].replace(".00", "") : "&nbsp;";
			
				setTimeout(function(){
					jQuery("." + uvpkdateclass).append("<label>" + uvpkappendprice + "</label>");
				}, 10);
				
				return [uvpkavailabledate, uvpkdateclass, ""];
			},
			onSelect: function(pkdate){
				if(uv_pkdates[pkdate] != undefined){
					jQuery(".uv-pkcalendar").removeClass("visible");
				
					var uvpkshortdate = uv_pkdates[pkdate].shortdate[0];
					var uvpkid = uv_pkdates[pkdate].id[0];
					
					jQuery(".pk-it").val(uvpkid);
					jQuery(".pk-dt").val(uvpkshortdate);
				
					pkdate = pkdate.replace(/-/g, '/');
		            pkdate = new Date(pkdate);
		            pkddate = uv_weekdaysres[pkdate.getDay()] + ', ' + uv_yearmonths[pkdate.getMonth()] + ' ' + (pkdate.getDate()) + ', ' + pkdate.getFullYear();
		
		            jQuery(".uv-pkddate").val(pkddate);	
				}else
					uvDisplayMsg("Something went wrong, contact support@urvenue.com <br> Error: package info not found in object", "Oops");
			}
		});
	</script>
	
<?php } else{ ?>
	<h2>Something is missing, contact: support@urvenue.com</h2>
<?php } ?>