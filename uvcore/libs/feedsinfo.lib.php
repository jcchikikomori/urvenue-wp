<?php

$uv_testfeeds = (isset($uv_testfeeds)) ? $uv_testfeeds : false;
$uvlib_feedscleartime = 172800;
$uvlib_feeds = array(
	"MEDIA" => array(
		"url" => "http://{uvserver}/apis/media.json?{params}",
		"expiration" => 3600,
		"varpass" => "get"
	),
	"events" => array(
		"url" => "https://uvtix.com/api/v3/{params}/events.json",
		"expiration" => 3600,
		"varpass" => "url"
	),
	"event" => array(
		"url" => "https://uvtix.com/api/v3/{params}/events.json",
		"expirations" => 3600,
		"varpass" => "url"
	),
	"venueinfo" => array(
		"url" => "http://uvtix.com/api/v3/{params}/venues.json",
		"expiration" => 43200,
		"varpass" => "url"
	),
	"calendar" => array(
		"url" => "http://uvtix.com/api/v3/{params}/calevents.json",
		"expiration" => 3600,
		"varpass" => "url"
	),
	"packages" => array(
		"url" => "https://uvtix.com/api/XRO/{params}kyuvtix-vdwuuboja0/gitemsvenue.json",
		"expiration" => 0,
		"varpass" => "url"
	),
	"photogallery" => array(
		"url" => "http://{uvserver}/apis/galbums.json?{params},123",
		"expiration" => 3600,
		"varpass" => "get"
	),
	"photoalbum" => array(
		"url" => "http://{uvserver}/apis/album.json?{params}",
		"expiration" => 21600,
		"varpass" => "get"
	)
);

$uvlib_mediafeeds = array(
	"m26011" => array(
		"type" => "title",
		"feedreturn" => "title"
	),
	"m2608" => array(
		"type" => "hyperLink",
		"feedreturn" => "hyperlink"
	),
	"m26010" => array(
		"type" => "singleimage",
		"feedreturn" => "imageurl",
		"feedreturnpath" => "pic:0"
	),
	"m2602" => array(
		"type" => "singlevideo",
		"feedreturn" => "videoframeurl",
		"feedreturnpath" => "singlevideo:0:video:0"
	),
	"m26013" => array(
		"type" => "singlepdf",
		"feedreturn" => "pdfurl",
		"feedreturnpath" => "pdf:0"
	),
	"m2605" => array(
		"type" => "article",
		"feedreturn" => "article",
		"feedreturnpath" => "article:0"
	),
	"m2603" => array(
		"type" => "albumgallery",
		"feedreturn" => "feed",
		"feedreturnpath" => "gallery:0:albums:0:album"
	)
);






