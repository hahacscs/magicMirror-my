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
    <div class="top left">
	   <div class="date small dimmed"></div>
	   <div class="time"></div>
	   <div class="calendar xxsmall"></div>
	   <div class="camera">视频</div>
	  </div> 
	  <div class="top right">
	   <div class="windsun small dimmed"></div>
	   <div class="temp"></div>
	   <div class="temhum medium"></div>
	   <div class="forecast small dimmed"></div>
	   <div class="suggestion small dimmed"></div>
	   <div class="updatetime xsmall dimmed"></div>
	  </div> 
  </div>
  <div id = "second">
	   <div class="textGui">文字交互</div>
   		<audio autoplay src="http://tsn.baidu.com/text2audio?tex=您好呀&lan=zh&per=4&cuid=myBaidu_workSpace&ctp=1&tok=24.d10b4d3a5341e52d7f920779d102f9f0.2592000.1494774638.282335-8490138">
			</audio>
  </div>
  <div id = "bottom">
		<div class = "bottom  center-hor">
		 <div class = "news medium">news medium</div>
		</div>
  </div>
 </body>  
<script src = "js/jquery.js"></script> 
<script src="js/jquery.feedToJSON.js"></script> 
<script src="js/ical_parser.js"></script> 
<script src="js/moment-with-locales.min.js"></script> 
<script src="js/paho/mqttws31.js"></script> 
<script src="js/config.js"></script> 
<script src="js/rrule.js"></script> 
<script src="js/version/version.js" type="text/javascript"></script> 
<script src="js/calendar/calendar.js" type="text/javascript"></script> 
<script src="js/compliments/compliments.js" type="text/javascript"></script> 
<script src="js/skycons.js" type="text/javascript"></script> 
<script src="js/weather/weather.js" type="text/javascript"></script> 
<script src="js/temp_hum/tem_hum.js" type="text/javascript"></script> 
<script src="js/time/time.js" type="text/javascript"></script> 
<script src="js/news/news.js" type="text/javascript"></script> 
<script src = "js/test.js?nocache=<?php echo md5(microtime()) ?>"></script> 
<script src = "js/main.js?nocache=<?php echo md5(microtime()) ?>"></script> 
</html>