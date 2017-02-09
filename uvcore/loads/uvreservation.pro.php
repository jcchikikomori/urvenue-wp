<?php

$uvproresurl = $uvlib_global["uvproresurl"];
$uvnfields = 0;

foreach($_REQUEST as $uvfieldname => $uvfieldvalue){
	if($uvfieldname != "action"){
		$uvfieldsstring .= $uvfieldname . "=" . $uvfieldvalue . '&';
		$uvnfields++;
	}
}

rtrim($uvfieldsstring, '&');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uvproresurl);
curl_setopt($ch, CURLOPT_POST, $uvnfields);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvfieldsstring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$uvproresresult = curl_exec($ch);
curl_close($ch);

if($uvproresresult){
	eval($uvproresresult);
	$uvproressuccess = $xc8["success"][0];
}

if($uvproressuccess == "true")
	echo("uv1");
else
	echo("uv0");