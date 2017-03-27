<?php
// load php_client_demo, this can be downloaded from our website(http://us.faceplusplus.com/dev/others/sdks/)
require_once(__DIR__ . "/facePPClass.php");

// your api_key and api_secret
$api_key = "tW42h6YN-90aTObg4spBBZ7JdgY94sPH";
$api_secret = "3sRh1CwbvdqVfnFZrVTzc2_Y4WA2NZsA";
// initialize client object
$api = new FacePP($api_key, $api_secret);
    
    // detect faces in this photo
    $result = $api->face_detect_file(__DIR__."/img/ss_1.jpg");

/*
 *	return the train data(image_url) of $person_name
 */
function getTrainingUrl($person_name)
{
    // TODO: here is just the fake url
	return __DIR__.'/'.$person_name.".jpg";
}

?>
