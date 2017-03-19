<html>
 <head> 
  <title>Magic Mirror</title> 
  <style type="text/css">
		<?php include('css/main.css') ?>
	</style> 
  <script type="text/javascript">
  	
	</script> 
  <!-- <meta name="google" value="notranslate" /> -->
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
 </head> 
 <body id = "container"> 
  <div id = "first">
   <div class = "in time left">时间</div>
   <div class = "in camera mid">视频</div>
   <div class = "in pm2tem right">
   	<div class = "air top">空气质量</div>
   	<div class = "tem bottom">温度</div>
   </div>
  </div>
  <div id = "second">
   <div class = "in txtGui left">文字交互</div>
   <div class = "in air2audio right">
   	<div class ="weather top">天气资源</div>
   	<div class = "audio bottom">音频播放
   		<audio autoplay src="http://tsn.baidu.com/text2audio?tex=大傻逼&lan=zh&per=4&cuid=myBaidu_workSpace&ctp=1&tok=24.f1cb1b2c918de7213660e6c7c8a12350.2592000.1491922264.282335-8490138">
			</audio>
		</div>
   </div>
  </div>
  <div id = "bottom">
   <div class = "news medium">news medium</div>
  </div>
 </body>  
<script src = "js/jquery.js"></script> 
<script src = "js/test.js"></script> 
<script src = "js/main.js?nocache=<?php echo md5(microtime()) ?>"></script> 
</html>