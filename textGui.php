<?php

//��ʼ��
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://cscshaha.imwork.net/textGui.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$response = curl_exec($ch);
if(curl_errno($ch))
{
    print curl_error($ch);
}
curl_close($ch);

//��ӡ��õ����
//print_r($response);
$output_array = json_decode($response,true);
//var_dump($output_array);

$res = ["msg"=>$output_array["msg"],"code"=>"succ"];
//echo $_GET['data'];
echo urldecode(json_encode($res));
?>