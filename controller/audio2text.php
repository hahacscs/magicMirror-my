<?php

function audio2text(){
	define('AUDIO_FILE', "/var/www/html/workspace/test/media/test.wav");
	$url = "http://vop.baidu.com/server_api";
	
	//put your params here
	$cuid = "myBaidu_workSpace";
	$apiKey = "BXkhWGO8xblA3CSq12gZF5QE";
	$secretKey = "36cb2c14a8bf02f2c03475e72ff33b4a";
	
	$auth_url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=".$apiKey."&client_secret=".$secretKey;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $auth_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	if(curl_errno($ch))
	{
	    print curl_error($ch);
	}
	curl_close($ch);
	$response = json_decode($response, true);
	$token = $response['access_token'];
	
	$audio = file_get_contents(AUDIO_FILE);
	$base_data = base64_encode($audio);
	$array = array(
	        "format" => "wav",
	        "rate" => 16000,
	        "channel" => 1,
	        "lan" => "zh",
	        "token" => $token,
	        "cuid"=> $cuid,
	        //"url" => "http://www.xxx.com/sample.pcm",
	        //"callback" => "http://www.xxx.com/audio/callback",
	        "len" => filesize(AUDIO_FILE),
	        "speech" => $base_data,
	        );
	$json_array = json_encode($array);
	$content_len = "Content-Length: ".strlen($json_array);
	$header = array ($content_len, 'Content-Type: application/json; charset=utf-8');
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_array);
	$response = curl_exec($ch);
	if(curl_errno($ch))
	{
	    print curl_error($ch);
	}
	curl_close($ch);
	echo $response;
	$response = json_decode($response, true);
	return $response;
}
?>
