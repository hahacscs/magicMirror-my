<?php

//echo $_POST["name"]; 
//echo $_POST["email"];

require_once("/var/www/html/workspace/test/controller/audio2text.php");
require_once(__DIR__ . "/faceClass/facePPClass.php");
/*
  $myfile = fopen("text.txt", "r") or die("Unable to open file!");
  $text = fgets($myfile);
  fclose($myfile);



  $array=array(
  "status"=>"200",
  "reason"=>"Return Tips",
  "result"=>array(
  "data1"=>"我是正常返回数据1",
  "data2"=>"我是正常返回数据2",
  //"get"=>"GET提交数据为[".$_GET["data"]."]",
  ),
  "error"=>"我是报错信息"
  );
  //echo json_encode($text);

  echo $text;
 */
system('sudo arecord -D "plughw:1" -f S16_LE -r 16000 -t wav -d 5 /var/www/html/workspace/test/media/test.wav >> /var/www/html/workspace/test/controller/generlog.txt 2>&1');
//exec ('ls'); 
//passthru ('ls -a'); 
//echo `ls`; 

echo "audio2text begin \r\n";
$rst = audio2text();
//var_dump($rst);
$text;
//$tok;
if ($rst["err_msg"] == "success.") {
    $text = $rst["result"][0];
    //$tok = $rst[1];
    echo $text;
    //echo $tok;
} else {
    echo "audio2text error";
    return "err";
}

//$pos = strpos($text, "最帅");
if (strstr($text, "我是不是最漂亮") != FALSE) {
    // your api_key and api_secret
    $api_key = "tW42h6YN-90aTObg4spBBZ7JdgY94sPH";
    $api_secret = "3sRh1CwbvdqVfnFZrVTzc2_Y4WA2NZsA";
    // initialize client object
    $api = new FacePP($api_key, $api_secret);

    $names1 = __DIR__ . "/currentImg.jpg";
    //$names2 = __DIR__ . "/faceClass/img/wy_1.jpg";
		$token = '87609fe2dd40332b191b025cc6a02995';
    $flags = array('face1' => 'token', 'face2' => 'files');
    $res = $api->face_compare($flags, $token, $names1);
    if (empty($res) || isset($res['error_message'])) {
        $result = ' 看不清你的人脸，能让我看清楚么？';
    }elseif ($res['confidence']>$res['thresholds']['1e-5']){
        $result = ' 是的，您就是世界上最漂亮的人，我主人的女人！';
    }else{
        $result = ' 你不是我家主人，我不认识你，你是谁呀？';
    }
} elseif (strstr($text, "我是不是最帅") != FALSE) {
    // your api_key and api_secret
    $api_key = "tW42h6YN-90aTObg4spBBZ7JdgY94sPH";
    $api_secret = "3sRh1CwbvdqVfnFZrVTzc2_Y4WA2NZsA";
    // initialize client object
    $api = new FacePP($api_key, $api_secret);

    $names1 = __DIR__ . "/currentImg.jpg";
    $names2 = __DIR__ . "/faceClass/img/wy_1.jpg";
    $flags = array('face1' => 'files', 'face2' => 'files');
    $res = $api->face_compare($flags, $names1, $names2);
    if (empty($res) || isset($res['error_message'])) {
        $result = ' 看不清你的人脸，能让我看清楚么？';
    }elseif ($res['confidence']>$res['thresholds']['1e-5']){
        $result = ' 是的，您就是世界上最帅的人，我的主人！';
    }else{
        $result = ' 你不是我家主人，我不认识你，你是谁呀？';
    }
} elseif (strstr($text, "最帅") != FALSE) {
    $result = " my lord. 我家主人，汪大少爷最帅";
} elseif (strstr($text, "漂亮") != FALSE) {
    $result = "  我家主人的女人，汪大少爷的老婆双儿姑娘最漂亮";
} else {
    $result = " 你说什么？没有听懂，能不能再说一次呐。";
}

$result = '1 '.$result;

$myfile = fopen("/var/www/html/workspace/test/media/anser.txt", "w") or die("Unable to open file!");
fwrite($myfile, $result);
fclose($myfile);

echo $result;
?>
