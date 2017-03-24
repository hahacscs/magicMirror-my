jQuery.fn.updateWithText = function(text, speed)
{
	var dummy = $('<div/>').html(text);

	if ($(this).html() != dummy.html())
	{
		$(this).fadeOut(speed/2, function() {
			$(this).html(text);
			$(this).fadeIn(speed/2, function() {
				//done
			});
		});
	}
}

jQuery.fn.outerHTML = function(s) {
    return s
        ? this.before(s).remove()
        : jQuery("<p>").append(this.eq(0).clone()).html();
};

function roundVal(temp)
{
	return Math.round(temp * 10) / 10;
}

$(document).ready(function(){
  $("div.time").click(function(){
  	var tou = "http://tsn.baidu.com/text2audio?tex=";
  	var end = "&lan=zh&per=4&cuid=myBaidu_workSpace&ctp=1&tok=24.f1cb1b2c918de7213660e6c7c8a12350.2592000.1491922264.282335-8490138";
	  	$.get("./controller/getText.php",function(data,status){
	    	$("audio").attr("src",tou +data+end);
		  });
    });
    

    setInterval( showText , 3000 );
		function showText(){
			var tou = "http://tsn.baidu.com/text2audio?tex=";
	  	var end = "&lan=zh&per=4&cuid=myBaidu_workSpace&ctp=1&tok=24.f1cb1b2c918de7213660e6c7c8a12350.2592000.1491922264.282335-8490138";
	  	$.get("./controller/getText.php",function(data,status){
	  		if (data[0] == 0 ) return 1;
	    	$("audio").attr("src",tou +data+end);
		  });
		} 
		
		

	var eventList = [];

	var lastCompliment;
	var compliment;
	
	
	time.init();

	weather.init();

	//calendar.init();

	//compliments.init();

	news.init();

	tem_hum.init();
});
