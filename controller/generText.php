<?php
//echo $_POST["name"]; 
//echo $_POST["email"];

require_once("/var/www/html/workspace/test/controller/audio2text.php");
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
if($rst["err_msg"] == "success.")
{
	$text =$rst["result"][0];
	echo $text;
}
else{
	echo "audio2text error";
	return "err";
}

//$pos = strpos($text, "最帅");
$pos = strstr($text, "最帅");
if ($pos === false) {
    echo "no find 没有找到 ";
    return;
} else {
    $result = "1 my lord 我家主人，汪大少爷最帅";
}

$myfile = fopen("/var/www/html/workspace/test/media/anser.txt", "w") or die("Unable to open file!");
fwrite($myfile,$result);
fclose($myfile);

echo $result;
?>