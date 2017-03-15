<?php 
	$uveventcarousellisthtml = uv_get_eventlisthtml("eventcarouselitem");
?>

<div class="uv-integration uv-eventcarousel">
	<div class="uv-evcarouselcont">
		<a class="uv-evcarouselleft uvjs-evcarouselprev" href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
		<a class="uv-evcarouselright uvjs-evcarouselnext" href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
		<div class="uv-evcarousel"><?=$uveventcarousellisthtml;?></div>
	</div>
	<a class="uv-pwby-cb" href="http://urvenue.com" target="_blank"></a>
</div>


<script>
	jQuery('.uv-evcarousel').owlCarousel({
      	navigation : false,
		pagination : false,
		slideSpeed : 500,
		paginationSpeed : 400,
		singleItem: false,
		autoPlay: false,
		items: 6,
		itemsDesktop: [1100, 4],
		itemsDesktopSmall: [850, 3],
		itemsTablet: [600, 2],
		itemsMobile: [400, 1]
	});
	
	jQuery(document).on('click', '.uvjs-evcarouselprev', function(){
		jQuery('.uv-evcarousel').trigger('owl.prev');
	});
	jQuery(document).on('click', '.uvjs-evcarouselnext', function(){
		jQuery('.uv-evcarousel').trigger('owl.next');
	});
</script>