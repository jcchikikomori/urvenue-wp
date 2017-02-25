<?php

// Caledar
function shortcode_urvenue_calendar($atts, $content = null){
	global $uvlib_global, $uv_corepath;
	ob_start();

	include($uv_corepath . "/templates/calendar.default.php");

	$content = ob_get_contents();
  	ob_end_clean();

	return $content;
}
add_shortcode("urvenue_calendar", "shortcode_urvenue_calendar");

// Event
function shortcode_urvenue_event($atts, $content = null){
	global $uvlib_global, $uv_corepath;
	ob_start();
	
	include($uv_corepath . "/templates/event.default.php");
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode("urvenue_event", "shortcode_urvenue_event");

// Reservations
function shortcode_urvenue_reservation($atts, $content = null){
	global $uvlib_global, $uv_corepath;
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	
	ob_start();
	
	include($uv_corepath . "/templates/reservation.default.php");
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode("urvenue_reservation", "shortcode_urvenue_reservation");

// Packages
function shortcode_urvenue_packages($atts, $content = null){
	global $uvlib_global, $uv_corepath;
	ob_start();
	
	include($uv_corepath . "/templates/packages.default.php");
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode("urvenue_packages", "shortcode_urvenue_packages");

// Photo Gallery
function shortcode_urvenue_photo_gallery($atts, $content = null){
	global $uvlib_global, $uv_corepath, $uvg_lib, $uvlib_designtemplates;
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	
	ob_start();
	
	include($uv_corepath . "/templates/photogallery.default.php");
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode("urvenue_photo_gallery", "shortcode_urvenue_photo_gallery");

// Event Slider
function shortcode_urvenue_event_slider($atts, $content = null){
	global $uvlib_global, $uv_corepath;
	
	ob_start();
	
	include($uv_corepath . "/templates/eventslider.default.php");
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode("urvenue_event_slider", "shortcode_urvenue_event_slider");

// Carousel 
function shortcode_urvenue_carousel($atts, $content = null){
	global $uvlib_global, $uv_corepath;
	
	ob_start();
	
	include($uv_corepath . "/templates/eventcarousel.default.php");
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode("urvenue_carousel", "shortcode_urvenue_carousel");

// 3d Map 
function shortcode_urvenue_3dmap($atts, $content = null){
	global $uvlib_global, $uv_corepath;
	
	ob_start();
	
	include($uv_corepath . "/templates/3dmap.default.php");
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode("urvenue_3dmap", "shortcode_urvenue_3dmap");







