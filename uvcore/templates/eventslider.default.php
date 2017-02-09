<?php
	$uveventlisthtml = uv_get_eventlisthtml("eventslideritem");
?>

<div class="uv-integration">
	<div class="uv-evslidercont">
		<a class="uv-evsliderleft uvjs-evsliderprev" href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
		<a class="uv-evsliderright uvjs-evslidernext" href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
		<div class="uv-evslider"><?=$uveventlisthtml;?></div>
	</div>
	<script>
		jQuery('.uv-evslider').owlCarousel({
	      	navigation : false,
	      	pagination : false,
	      	slideSpeed : 300,
	      	paginationSpeed : 400,
	      	singleItem: true,
	      	autoHeight : true,
	      	autoPlay: 7000,
	      	stopOnHover: true
		});
		
		jQuery(document).on('click', '.uvjs-evsliderprev', function(){
			jQuery('.uv-evslider').trigger('owl.prev');
		});
		jQuery(document).on('click', '.uvjs-evslidernext', function(){
			jQuery('.uv-evslider').trigger('owl.next');
		});
	</script>
</div>