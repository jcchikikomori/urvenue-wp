<?php

$uvstartdate = isset($fd) ? $fd : $_REQUEST["fd"];
$feedtoken = isset($feedtoken) ? $feedtoken : $_REQUEST["feedtoken"];
$feedtoken .= "fd" . $uvstartdate;
$uvstartdate = "20" . substr($uvstartdate, 0, 2) . "-" . substr($uvstartdate, 2, 2) . "-" . substr($uvstartdate, 4, 2);

echo uv_calendar_get_month($feedtoken, $uvstartdate);