<?php

$uv_coreurl = isset($uv_coreurl) ? $uv_coreurl : "";
$uv_corepath = isset($uv_corepath) ? $uv_corepath : "";
$uv_today = isset($uv_today) ? $uv_today : date("Y-m-d");

$uvlib_global = array();
$uvlib_global["uvvenueid"] = isset($uv_opts["uvvenueid"]) ? $uv_opts["uvvenueid"] : "";
$uvlib_global["veaid"] = isset($uv_opts["veaid"]) ? $uv_opts["veaid"] : "";
$uvlib_global["wbcode"] = isset($uv_opts["wbcode"]) ? $uv_opts["wbcode"] : "";
$uvlib_global["uvserver"] = isset($uv_opts["uvserver"]) ? $uv_opts["uvserver"] : "";
$uvlib_global["eventurl"] = isset($uv_opts["eventurl"]) ? $uv_opts["eventurl"] : "/event/?id={eventid}&dt={seventdate}";
$uvlib_global["sendformurl"] = isset($uv_opts["sendformurl"]) ? $uv_opts["sendformurl"] : "";
$uvlib_global["packagespopurl"] = isset($uv_opts["packagespopurl"]) ? $uv_opts["packagespopurl"] : "";
$uvlib_global["uvproresurl"] = "http://" . $uvlib_global["uvserver"] . "/apis/prores.pc8";
$uvlib_global["uniqueintid"] = 0;
$uvlib_global["map-reqid"] = isset($uv_opts["map-reqid"]) ? $uv_opts["map-reqid"] : "";

$uvc_lib = array();
$uvc_lib["defaultview"] = isset($uv_opts["uvc-defaultview"]) ? $uv_opts["uvc-defaultview"] : "calendar"; //available views: "calendar", "list"
$uvc_lib["loadcalurl"] = isset($uv_opts["uvc-loadcalurl"]) ? $uv_opts["uvc-loadcalurl"] : "";

$uvg_lib = array();
$uvg_lib["pwidth"] = isset($uv_opts["uvg-pwidth"]) ? $uv_opts["uvg-pwidth"] : 800;
$uvg_lib["pheight"] = isset($uv_opts["uvg-pheight"]) ? $uv_opts["uvg-pheight"] : 600;
$uvg_lib["ninitalbums"] = isset($uv_opts["uvg-ninitalbums"]) ? $uv_opts["uvg-ninitalbums"] : 12;
$uvg_lib["nalbumsgroups"] = isset($uv_opts["uvg-nalbumsgroups"]) ? $uv_opts["uvg-nalbumsgroups"] : 8;
$uvg_lib["albumdatephpformat"] = isset($uv_opts["uvg-albumdatephpformat"]) ? $uv_opts["uvg-albumdatephpformat"] : "n/j/Y";
$uvg_lib["albumdesigntemplate"] = isset($uv_opts["uvg-albumdesigntemplate"]) ? $uv_opts["uvg-albumdesigntemplate"] : "default";
$uvg_lib["loadalbumurl"] = isset($uv_opts["uvg-loadalbumurl"]) ? $uv_opts["uvg-loadalbumurl"] : "";









