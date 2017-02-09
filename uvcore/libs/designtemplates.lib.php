<?php

$uvlib_designtemplates = array(
	"photoitem" => array(
		"default" => array(
			"template" => "<a class='{linkclass}' {linkparams} href='javascript:;'><div class='uv-mos-item'><img class='uv-loadfade' src='{thumbnail}'><div class='uv-mos-info'><div class='uv-mos-name'>{name}</div><div class='uv-mos-date'>{ddate}</div></div></div></a>",
		)
	),
	"albumlistitem" => array(
		"default" => array(
			"template" => "<a class='{linkclass}' {linkparams} href='javascript:;'><div class='uv-pa-item'><img class='uv-loadfade' src='{thumbnail}'><div class='uv-pa-itembor'></div></div></a>"
		)
	),
	"eventslideritem" => array(
		"default" => array(
			"flyerprioritycode" => "slider",
			"template" => "<a href='{eventlink}'><div><img src='{eventflyer}'></div></a>"
		)
	)
);