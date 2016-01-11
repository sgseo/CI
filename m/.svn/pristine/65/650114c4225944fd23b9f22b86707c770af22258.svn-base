//这其实是提交自定义表单的
function transUrl(heaf){
   var temp=document.getElementById(heaf);
    temp.submit();   
}
//这其实是模仿A 标签的 
//@selected 是选择器
//@args 是控制 和参数  比如 C/a?id=2B青年&appraise=就是牛啊
//**** 也可以提交控件的arg 获取
function transA(seleced,controll){  
     $(seleced).click(
        function (){
            $url=location.protocol+'//'+location.host+controll;
            var args=this.getAttribute('arg');
           if(args){
             if(controll.indexOf('?')>0){
                $url=$url+'&'+args;
             }else{
               $url=$url+'?'+args; 
             }
           }
           location.href=$url;
        }
    );
}
//清楚默认的文字 class= clrtext 
//小数点精确到两位
$(document).ready(function(){
$('.clrtext').css('color','#000');
  $(".clrtext").focus(function (){
            this.value='';
  });
  //放回
  $('.goBack').click( function (){
    window.history.back(-1);
  });
  $('.goBack').mousemove( function (){
    $('#back').attr('fill','#FF7200');
  });
  //格式小数
  $(".fixed").each(
    function(i){
        this.innerHTML=(parseFloat(this.innerHTML).toFixed(2));
    }
  );
	geturl();
});

/*验证数字*


*/
function volidateNum(n,tag,min,max) {
   min=((min==null||min<=0)?100:min);
   max=((max==null||max==0)?100000000:max);
   if(isNaN(n.value) ){
    // n.value='亲,要是哦！';
     $(tag).html('亲,可能是你未填写金额 ^_^');
     return false;
   }
   if(n.value%100!=0){
  $(tag).html('亲,投资100倍数哦！');
     return false;
   }
   if(n.value<min){
      $(tag).html('亲,最少是'+min+'哦！');
      return false;
   }
   if(n.value>max){
   $(tag).html('亲,客官数字太大了,超出改标的设置范围！');
      return false;
   }
   window.money=n.value;
   return true;
}
//格式化数字的 3 位1空格
/*// location.money=this;
格式化之前会保存为全局静态变量的
 */
String.prototype.asCurrency = function() {
   
    var len=this.length;
    var B=0;
    B=this[0];
    for(i=1;i<len;i++){
        if(i%3==0){
           B=B+','+this[i].toString();  
        }else{
            B=B+this[i].toString();
        }
    }
   return B;
}

//获取url 参数
function geturl(){
		function getQueryString(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
		var r = document.location.search.substr(1).match(reg);
		if (r != null) return unescape(r[2]);  return null;
		}

		$('.autoUrl').each(function (){
						var arg=$(this).attr("autoUrl");
						
						if(getQueryString(arg) != null) {
							this.value=getQueryString(arg);
                            this.setAttribute("readOnly",false); 
						}
					}
		)
 }

 //反回
