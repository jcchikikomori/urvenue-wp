<?php

$uvlib_cleanchars = array('ě' => 'e', 'Ě' => 'E', 'š' => 's', 'Š' => 'S', 'č' => 'c', 'Č' => 'C', 'ř' => 'r', 'Ř' => 'R', 'ž' => 'z', 'Ž' => 'Z', 'ý' => 'y', 'Ý' => 'Y', 'á' => 'a', 'Á' => 'A', 'í' => 'i', 'Í' => 'I', 'é' => 'e', 'É' => 'E', 'ú' => 'u', 'ů' => 'u', 'Ů' => 'U', 'ď' => 'd', 'Ď' => 'D', 'ť' => 't', 'Ť' => 'T', 'ň' => 'n', 'Ň' => 'N', 'ü' => 'u');


$uvlib_flyers_priority = array(
	"default" => array(
		"flyertype" => array("Flyer", "Secondary Flyer", "Head Shot", "Action Shot", "Promotional"),
		"flyerratio" => array("Vertical", "Square", "Horizontal", "Banner")
	),
	"calendar" => array(
		"flyertype" => array("Flyer", "Secondary Flyer", "Head Shot"),
		"flyerratio" => array("Square", "Vertical", "Horizontal")
	),
	"slider" => array(
		"flyertype" => array("Flyer", "Secondary Flyer"),
		"flyerratio" => array("Horizontal", "Banner", "Square", "Vertical")
	),
	"carousel" => array(
		"flyertype" => array("Flyer", "Secondary Flyer"),
		"flyerratio" => array("Square", "Vertical")
	)
);