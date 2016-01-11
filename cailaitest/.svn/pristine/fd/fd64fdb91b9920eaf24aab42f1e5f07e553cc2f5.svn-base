$(function(){
	$('tr',$('#sf_table_grey')).hover(function(){
		$(this).css({'background':'white'});
	},function(){
		$(this).css({'background':'#f7f8f8'});
	});
	$('tr',$('#sf_table_white')).hover(function(){
		$(this).css({'background':'#f7f8f8'});
	},function(){
		$(this).css({'background':'white'});
	});
	
	$('#sf_tab a').click(function(){
		var index = $(this).index();
		$('#sf_tab a').removeClass('active');
		$(this).addClass('active');
		$('#sf_tab_content ul').hide();
		$('#sf_tab_content ul').eq(index).show();
	});
	$('#sf_tab a').hover(function(){
		$(this).trigger('click');
	});
	$('#sf_tab a').eq(0).trigger('click');
	
	
	var unslider = $('#sf_scroll').unslider({
    	speed: 500,               //  The speed to animate each slide (in milliseconds)
    	delay: 5000,              //  The delay between slide animations (in milliseconds)
    	complete: function() {},  //  A function that gets called after every slide animation
    	keys: true,               //  Enable keyboard (left, right) arrow shortcuts
    	dots: true,               //  Display dot navigation
    	fluid: false              //  Support responsive design. May break non-responsive designs
    });
	
	function windowResize(){
		var window_w = $('body').width();
		if(window_w<1000){
			window_w = 1000;
		}
		$('#sf_scroll').width(window_w);
		$('#sf_scroll>ul li').width(window_w);
	}
	
	$(window).resize(function(){
		windowResize();
	});
	
	windowResize();
	
	
	$('.circle').each(function(index, el) {
		var num = $(this).find('span').text() * 3.6;
		if (num<=180) {
			$(this).find('.right').css('transform', "rotate(" + num + "deg)");
		} else {
			$(this).find('.right').css('transform', "rotate(180deg)");
			$(this).find('.left').css('transform', "rotate(" + (num - 180) + "deg)");
		};
	});
})