<?php

// load php_client_demo, this can be downloaded from our website(http://us.faceplusplus.com/dev/others/sdks/)
require_once(__DIR__ . "/facePPClass.php");

// your api_key and api_secret
$api_key = "tW42h6YN-90aTObg4spBBZ7JdgY94sPH";
$api_secret = "3sRh1CwbvdqVfnFZrVTzc2_Y4WA2NZsA";
// initialize client object
$api = new FacePP($api_key, $api_secret);

$urls1 = "https://ss0.bdstatic.com/94oJfD_bAAcT8t7mm9GUKT-xh_/timg?image&quality=100&size=b4000_4000&sec=1490684318&di=e982904d8367792b7e23d08ef560951a&src=http://pic1.nipic.com/2009-02-02/20092217132895_2.jpg";
//$names2 = "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1490698097082&di=a7c54b3540bd4236f9d0331b2c19870f&imgtype=0&src=http%3A%2F%2Fimg.pconline.com.cn%2Fimages%2Fupload%2Fupc%2Ftx%2Fphotoblog%2F1206%2F05%2Fc10%2F11887717_11887717_1338898983876_mthumb.jpg";
//$names1 = "6ee053b69ad44fb55cb3f4756af30545";
//$names2 = "46d3f0dfa4965ff3948513a4ac0f17e5";06ec0d2f97488c2395706dd1ab51412c
//$names = __DIR__."/img/ss_1.jpg";
$names1 = __DIR__."/img/ss_6.jpg";
$names2 = __DIR__."/img/ss_2.jpg";
// detect faces in this photo
//$result = $api->face_detect("files",$names2,null,$return_attributes = "age,gender,smiling,facequality");
//var_dump($result);

$token = '87609fe2dd40332b191b025cc6a02995';
//$flags = array('face1' => 'files', 'face2' => 'files');
$flags = array('face1' => 'token', 'face2' => 'files');
$result = $api->face_compare($flags, $token, $names1);
var_dump($result);

//$api->faceset_create('ss','ss');
//$api->faceset_addface('id','ss',$result['faces'][0]['face_token']);
//var_dump($result);


//$flags = array('face1' => 'urls', 'faceset2' => 'id');
//$result = $api->face_search($flags, $urls1, 'ss');
//var_dump($result);

//$result = $api->faceset_removeface('id','ss','5cfdbe7661610feeb3ebab4a09ad4481');
//var_dump($result);

//$result = $api->faceset_update('id','ss','shaungEr');
//var_dump($result);

//$result = $api->faceset_getdetail('id','shaungEr');
//var_dump($result);

//$result = $api->faceset_getfacesets();
//var_dump($result);

//$result = $api->faceset_delete('id','shaungEr');
//var_dump($result);

//$result = $api->face_analyze('6ee053b69ad44fb55cb3f4756af30545',null,'gender,age,smiling');
//var_dump($result);

//$result = $api->face_getdetail('6ee053b69ad44fb55cb3f4756af30545');
//var_dump($result);

//$result = $api->face_setuserid('6ee053b69ad44fb55cb3f4756af30545','bushishuangshuang');
//var_dump($result);
/*
 * 	return the train data(image_url) of $person_name
 *//*
    $flags = array('face_token1' => '6ee053b69ad44fb55cb3f4756af30545', 'face_token2' => '46d3f0dfa4965ff3948513a4ac0f17e5');
        $params = array_merge(array('api_key' => 'tW42h6YN-90aTObg4spBBZ7JdgY94sPH', 'api_secret' => '3sRh1CwbvdqVfnFZrVTzc2_Y4WA2NZsA'), $flags);
        var_dump($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api-cn.faceplusplus.com/facepp/v3/compare");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_INFILESIZE,$size); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);

        $result = null;
        if (!empty($data)) {
            if (DEBUG_MODE) {
                echo "postRETURN: " . $data . "\r\n";
            }
            $result = json_decode($data);
        }*/
?>
