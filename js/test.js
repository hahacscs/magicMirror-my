$(document).ready(function(){
  $("div.time").click(function(){
  	var tou = "http://tsn.baidu.com/text2audio?tex=";
  	var end = "&lan=zh&per=4&cuid=myBaidu_workSpace&ctp=1&tok=24.f1cb1b2c918de7213660e6c7c8a12350.2592000.1491922264.282335-8490138";
	  	$.get("./controller/getText.php",function(data,status){
	    	$("audio").attr("src",tou +data+end);
		  });
    });
});
