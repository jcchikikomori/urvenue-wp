<?php include_once("event.vars.php"); ?>

<div class="uv-eventtitle">
	<div class="uv-datecalendar">
		<div class="uv-datecalendarlabel uv-vcenter"><?=$evt_dmonth;?><b><?=$evt_dnday;?></b></div>
	</div>
	<h1><?=$evt_name;?></h1>
	<h2><?=$evt_fcaldate;?></h2>
</div>

<div class="uv-eventcont uv-integration uv-clearfix">
	<div class="uv-eventbook uv-panelsslides">
		<?php if($freeitems){ $closetickets = "closed"; ?>
			<div class='uv-panel uv-panel-free'>
				<div class='uv-panelheader'><button data-target='.uv-panel-free'><i class="fa fa-star"></i> Free</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.freelist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if($ticketsitems) { ?>
			<div class='uv-panel uv-panel-tickets <?=$closetickets?>'>
				<div class='uv-panelheader'><button data-target='.uv-panel-tickets'><i class='fa fa-ticket'></i> Tickets</button></div>
				<div class="uv-panelbody uv-clearfix">
					<?php include_once("$uv_corepath/itemstemplates/event.ticketslist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
							
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<?php if(!$ticketsitems and $eventticketsurl) { ?>
			<div class='uv-panel uv-panel-ticketsexternal closed'>
				<div class='uv-panelheader'><a href="<?=$eventticketsurl;?>" target="_blank"><button><i class='fa fa-ticket'></i> Tickets</button></a></div>
			</div>
		<?php } ?>
		
		<?php if($packagesitems) { ?>
			<div class='uv-panel uv-panel-packages closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-packages'><i class='fa fa-gift'></i> Packages</button></div>
				<div class="uv-panelbody uv-clearfix">
					<?php include_once("$uv_corepath/itemstemplates/event.packageslist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
							
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>

		<?php if($tablesitems){ ?>
			<div class='uv-panel uv-panel-tables closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-tables'><i class='fa fa-glass'></i> Tables</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.tableslist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if($dinneritems){ ?>
			<div class='uv-panel uv-panel-dinner closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-dinner'><i class="fa fa-cutlery"></i> Dinner</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.dinnerlist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if($diningitems){ ?>
			<div class='uv-panel uv-panel-dining closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-dining'><i class="fa fa-cutlery"></i> Dinner</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.dininglist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		
		
		<?php if($bottleserviceitems){ ?>
			<div class='uv-panel uv-panel-bottleservice closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-bottleservice'><i class="fa fa-glass"></i> Bottle Service</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.bottleservicelist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
						
		<?php if($birthdayitems){ ?>
			<div class='uv-panel uv-panel-birthday closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-birthday'><i class="fa fa-birthday-cake"></i> Birthday</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.birthdaylist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if($bacheloritems){ ?>
			<div class='uv-panel uv-panel-bachelor closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-bachelor'><i class="fa fa-glass"></i> Bachelor</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.bachelorlist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if($bacheloretteitems){ ?>
			<div class='uv-panel uv-panel-bachelorette closed'>
				<div class='uv-panelheader'><button data-target='.uv-panel-bachelorette'><i class="fa fa-gift"></i> Bachelorette</button></div>
				<div class='uv-panelbody'>
					<?php include_once("$uv_corepath/itemstemplates/event.bachelorettelist.php"); ?>
					
					<?php if(!$uvaddheadercheckoutbutton){ ?>
						<div class="uv-panelfooter uv-clearfix">
							<div class="uv-promocodecont">
								<a href="javascript:;">Have a Promo Code?</a>
								<input class="uv-promocodecopies" type="text" value="" placeholder="Coupon Code">
							</div>
						
							<button id="urcart_purchase" class="uv-btn uv-submititems uv-right"><i class="fa fa-shopping-cart"></i> Checkout <span class="uv-nitemsincart"></span></button>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if($uvvenuedayrestypes){ ?>
			<div class='uv-panel uv-panel-reservation <?=$resquestpanelclass;?>'>
				<div class='uv-panelheader'><button data-target='.uv-panel-reservation'><i class="fa fa-check"></i> Reservation Inquiry</button></div>
				<div class='uv-panelbody uv-clearfix'>
					<?php
						$uveventform = uv_get_formhtml($evt_caldate, $uv_venuedayrescheckboxes); 
						echo($uveventform);
					?>
				</div>
			</div>
		<?php } ?>
		
		
		<?php if($evt_descr){ ?>
			<div class="uv-panel">
				<div class="uv-panelbody">
					<h3>Event Description</h3>
					<div class="uv-evdescr">
						<?=$evt_descr;?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="uv-eventinfo">
		<?=$evt_dflyer;?>
				
		<div class="uv-panel">
			<div class="uv-panelbody uv-panelinfo uv-borbotF5">
				<i class="fa fa-clock-o"></i>
				<h2><?=$evt_ddate;?></h2>
				<a class="uv-addtocalendarlink" href="<?=$googlecalendarlink;?>" target="_blank"><i class="fa fa-calendar-plus-o"></i> Add to your calendar</a>
			</div>
			<div class="uv-panelbody uv-panelinfo">
				<i class="fa fa-map-marker uv-panelinfolocation"></i>
				<h2 class="uv-venuebrandcolor"><?=$evt_vname;?></h2>
				<p><?=$evt_venueadress;?></p>

				<a class="uv-btn uv-btn-grad uv-btn-100" href="<?=$evt_venuegmap;?>" target="_blank">Get Directions</a>
			</div>
		</div>
		
		<div class="uv-panel">
			<div class='uvpd5'>
				<a class="uv-poweredby uv-pby-default" href="http://www.urvenue.com" target="_blank"></a>
			</div>
		</div>
	</div>
</div>


<?php 

if($ticketsitems or $tablesitems or $dinneritems or $bottleserviceitems or $freeitems or $packagesitems or $bacheloretteitems or $bacheloritems or $birthdayitems or $diningitems ) { 
	
	$shortdate = str_replace("-", "", $evt_caldate);
	$shortdate = substr($shortdate, 2);
	
	if($uvnewwindowcheckout)
		$addtocheckoutform = "target='_blank'";
?>
<form action="https://uvtix.com/checkout" id='urcart_checkout' method="post" <?=$addtocheckoutform;?>>
	<input  type="hidden" name='urcart_pinfo' id='urcart_pinfo'>
	<input  type="hidden" name='venueid' value='<?=$evt_urvenueid;?>'>
	<input  type="hidden" name='eventid' value='<?=$evt_id;?>'>		
	<input  type="hidden" name='caldate' value='<?=$evt_caldate;?>'>
	<input type="hidden" name="addtocheckouturl" value="<?=$addtocheckouturl;?>">
	
	<input id="uvcart_promo" type="hidden" value="">
</form>
<?php } ?>


<script>
	var urcart_itms = <?=$urcart_itmsjson;?>;
	var venueid = '<?=$evt_urvenueid?>';
	var resdate = '<?=$evt_caldate?>';
	var token_globalstring = '<?=$token_globalstring?>';
	var eventid = '<?=$evt_id?>';
	var shortdate = '<?=$shortdate;?>';
	var dyna_webcode ='<?=$uvlib_global["wbcode"];?>';
</script>
<script>$ = jQuery;</script>
<script src='//uvtix.com/websites/ln_core/js/uvtix.js'></script>


