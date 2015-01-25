<?php

	$state = $_GET['states'];

	$uri = "api.met.gov.my/v1/weather/towns/$state/";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "$uri"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json'
		)
	);

	$town_list = curl_exec($ch);
	curl_close($ch);

	$towns = json_decode($town_list,true);

	foreach ($towns as $key => $value) {
		
		$cu = curl_init();
		
		curl_setopt($cu, CURLOPT_URL, "$uri"."$key/"); 
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cu, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
			)
		);
		
		$town_detail = curl_exec($cu);
		
		curl_close($cu);
		
		$detail[$key] = json_decode($town_detail,true);
	}
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/javascript');
	$seconds_to_cache = 3600;
	$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
	header("Expires: $ts");
	header("Pragma: cache");
	header("Cache-Control: max-age=$seconds_to_cache");
	echo json_encode($detail);
