$(function(){
  $(".show").hover(
    function(){
      var a = $(this).children(".ico").attr("class").split(" ");
      $(this).children(".ico").addClass(a[1]+"Hover");
      $(this).children(".none").show();
    },
    function(){
      var a = $(this).children(".ico").attr("class").split(" ");
      $(this).children(".ico").removeClass(a[2]);
      $(this).children(".none").hide();
    }
  );
  /*$(".tools").hover(
    function(){
      $(this).css("background","url(/images/gou.gif) 0 top no-repeat");
    },
    function(){
      $(this).css("background","url(/images/gou.png) 0 top no-repeat");
    }
  );*/
  $(".tNav div").hover(
    function(){
      $(this).children(".box").show();
    },
    function(){
      $(this).children(".box").hide();
    }
  );
  $(".backtop a").click(function(){
      $("html,body").animate({scrollTop:0});
  });
  	$(window).scroll(function(){
  	if($(window).scrollTop()>150)
  			{$(".backtop").fadeIn(500)}
  		else
  			{$(".backtop").fadeOut(500)}
  	});
});
$(function(){
if(!placeholderSupport()){   // 鍒ゆ柇娴忚鍣ㄦ槸鍚︽敮鎸� placeholder
    $('[placeholder]').live("keyup focus",function() {
			
				$(this).parent().children(".form_text").remove();

    }).blur(function() {
        var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.parent().append('<span class="form_text">' + input.attr('placeholder') + '</span>');
        }
    }).blur();
};
$(".form_text").live("focus",function() {
	$(this).parent().children('input').focus();
	$(this).remove();
});
})
function placeholderSupport() {
    return 'placeholder' in document.createElement('input');
}
var WC={};
WC.Core={
  //寮规渚濊禆浜巎query.artDialog
  Dialog:function(opt){
    //榛樿灞炴€�
        var def = {
            title:"淇℃伅",
            icon:'ok',
            okFn:null,
            btnValue:'纭畾',
            content:'鎿嶄綔鎴愬姛'
        };
        //鍙傛暟瑕嗙洊榛樿灞炴€�
        $.extend(def, opt);
        var dialog = art.dialog({
            title: def.title,
            content: def.content,
            icon: 'succeed',
            ok: function(){
                if(typeof def.okFn=="function"){
                    def.okFn();
                    return false;
                }
                myDialog.close();
                return false;
            }
        });
  },
  //鍏抽棴寮圭獥
  DialogClose:function(){

  }
}