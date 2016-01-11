<!doctype html>
<html lang="en">
<head>
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<meta charset="UTF-8">
	<title>js对象</title>
	<script>
	var map = new Map([['xiaoming','54'],['xiaowang','65'],['xiaohong','45']]);
	console.log(map.get('xiaoming'));
	map.set('lijie','99');
	
// define('MODE_NAME','cli');
// if (PHP_SAPI === 'cli'){
// 	$mysqllink=mysql_connect('115.29.245.207','test','cailai1234567890');
//       mysql_select_db('cailainew',$mysqllink);
//       $sql="insert into lzh_ls set name=1";
//      $data=mysql_query($sql,$mysqllink);
// }


	console.log(typeof(map));
	map.delete('xiaoming');
	console.log(map);
	// map.delete('xiaoming');
	// console.log(map);

	var set = new Set();
	var s2 =new Set([1,'2','3',3,]);
	//console.log(typeof(s2));
	//console.log(s2);
	//s2.delete(2);
	//console.log(s2);
	// for(var i in map)
	// {
	// console.log(i);
	// }
	var a = ['A','b',3];
	// a.forEach(function(e,i)
	// {
	// 	console.log(e);
	// })

	for(var i in a)
	{
		console.log(i);
	}
	// s2.forEach(function(e,s2){
	// 	console.log(e);
	// })
	// map.forEach(function(v,k,map){
	// 	console.log(v+k);
	// })

	var xiaoming={name:'xiaoming',birth:25,
		age:function()
		{
			//var that = this;//xiaoming
	 		//var dd=5;
	 		no=function(){
	 	 	console.log(this.birth);
	 	 	}
	 	 	return no;
		}
	}
	xiaoming.age();

	// var oldParse = parseInt;


	// var count =0;

	// window.parseInt = function(arguments){
	// 	//count+=1;
	// 	var a=arguments+1;
	// 	return oldParse.call(null,a);
	// }

	// parseInt(10);
	// parseInt(20);
	// console.log(parseInt(20));

	// var m=new Map([['gg',22],['hh',44]]);

	// 	m.set('jj',22);
	// var pow = function (x)
	// 	{
	// 		return x*=x;
	// 	}
	// 	//m.map(pow);
	// 	//console.log(m.map(pow));

	// var i=['isdf','jlkK','sddTf'];
	// //var b=i.slice(1);
	// var f=function(x)
	// {
	// 	return x[0].toUpperCase()+x.slice(1).toLowerCase();
	// }
	// //i.map(f);
	// console.log(i.map(f));
	//f();
	//filter
	// var bibao=function(arr)
	// {
	// 	var sum=function()
	// 	{
	// 		return arr.reduce(function(x,y){

	// 			return x+y;
	// 		})
	// 	}
	// 	return sum;
	// }
	// var arr=[1,2,3,4,5];

	// var f=bibao(arr);

	// console.log(f());
	// function count() {
 //    var arr = [];
 //    for (var i=1; i<=3; i++) 
 //    {
 //        arr.push(function () {
 //            return i * i;
 //        });
 //    }
 //    return arr;
	// }

	// var f=count();
	// var f1=f[0];
	// console.log(f1);
// var now = new Date();

// console.log(now.getFullYear());
// console.log(now.getMonth());//注意月份范围是0~11，5表示六月
// console.log(now.getDay());//星期几
// console.log(now.getDate());//j几号
// console.log(now.getTime());
// console.log(now.getHours());
// console.log(now.getSeconds());
// console.log(now.getMinutes());
// console.log(now.getMilliseconds());

// var d= new Date(2015,07,03,10,22,50);
// console.log(d);
// var e = new Date(1438568572815);
// console.log(e.toLocaleString());

// console.log(Date.now());

// //手机号码 正则匹配

// var rep=/^\d{11}/;

// var a =rep.test('x1862176545');

// var b=rep.test('18621765451');

// var c=rep.test('1865678545n');

// console.log(a,b,c);

// var reg = new RegExp(/^\d{3}\-\d{8}$/);//正则表达式

// var g=reg.test('010-88325860');

// console.log(g);


// var h='a b, c d'.split(/[\s+\,]+/);

// var i=/^(\d{3})-(\d{3,8})/;
// var j=i.exec('010-88325164');

// var k=/^(0[0-9]|1[0-9]|2[0-3]|[0-9])\:(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|[0-9])\:(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|[0-9])$/;
// //19:05:06
// var m = k.test('19:05:06');

// console.log(h,j,m);

var duixiang={name:'xiaoming',age:'25',waim:'handsome',toJSON:function(){return {'age':this.age}}};

// var convert = function(key,value){

// 	if(typeof value==='string')
// 	{
// 		return value.toUpperCase();
// 	}
// 	return value;
// }
// var c=JSON.stringify(duixiang,null,' ');
// console.log(c);
// var b='{ "age": "25"}';
// var a=typeof(b);
// console.log(a);

var student={name:'robot',height:'1.6',run:function(){return this.name+'is runing';}};
var xiaoming={name:'xiaoming'};

xiaoming.__proto__=student;
console.log(xiaoming.run());

var c=window.innerWidth;
var h=window.innerHeight;
var ow=window.outerWidth;
var oh=window.outerHeight;
var sw=screen.width;
var sh=screen.height;
var l=location.href;
console.log(c,h,ow,oh,sw,sh,l);
//location.assign('http://www.baidu.com');//重新加载一个新的页面
var d=document;
var dt=d.title;
var ce=d.cookie;
var re=d.referrer;
var dl=d.location.href;
//d.location.href='http://www.baidu.com';
//console.log(dt,ce,re);
//console.log(re,dl);
// var fn=x=>x*x;
</script>
</head>
<body>
<div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=5e7d8806-aed2-4505-b85a-4c89d424ad3d&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
<code>alert(sdfsdf)</code>

<!-- <dl id="drink-menu" style="border:solid 1px #ccc;padding:6px;">
    <dt>摩卡</dt>
    <dd>热摩卡咖啡</dd>
    <dt>酸奶</dt>
    <dd>北京老酸奶</dd>
    <dt>果汁</dt>
    <dd>鲜榨苹果汁</dd>
</dl> -->
<div id="test-div">
  <p id="test-js">javascript</p>
  <p>Java</p>
</div>

<div id="test-highlight">
    <p>如何编写<span>jQuery</span> <span>Plugin</span></p>
    <p>编写<span>jQuery</span> <span>Plugin</span>，要设置<span>默认值</span>，并允许用户修改<span>默认值</span>，或者运行时传入<span>其他值</span>。</p>
</div>

<input type="color"/>
<input type="date"/>

<!-- canvas -->

<canvas id='canvas'>your browser does't support canvas ,please up to date it</canvas>


<?php 
$time=strtotime(date('2015-08-13'));
//$addtime=strtotime(date('2015-08-27'));
echo $time;
//echo strftime('Y-m-d',$time);
// for($i=283;$i<=323;$i++)
// {
// echo "insert into lzh_active_redpacket(id,rednum,facevalue,addtime,shelftime,overtime,is_used,owner,note,borrow_id,usetime,is_success,orderno) values($i,$i,10,".$addtime.",30,".$time.",'0',123486,0,0,0,0,0);"."<br/>";
// }

$reqext="%7B%22Vocher%22%3A%7B%22AcctId%22%3A%22MDT000001%22%2C%22VocherAmt%22%3A%2210.00%22%7D%7D";
		$reqext=urldecode($reqext);
		$reqext=json_decode($reqext,1);
		var_dump($reqext);
		$reqext=$reqext['Vocher']['VocherAmt'];
//echo phpinfo();
?>
<script type="text/javascript">
// $.fn.highlight=function(options){
// 			var opts=$.extend({},$.fn.highlight.defaults,options);
// 			this.css("background","#ff0000").css("fontSize",'20');
// 			return this;
// 		}
// $.fn.highlight.defaults={
// 	background:'#00ff00',
// 	color:'#0000ff'
// };
// $.fn.highlight.defaults={
// 	display:'inline-block',
// 	color:"#ff0000"
// }
// $("#test-highlight").highlight();

// var d=document;
// var mycanvas=d.getElementById('canvas');
// var mc=mycanvas.getContext('2d');
// 	mc.clearRect(0,0,200,200);
// 	mc.fillStyle="#dddddd";
// 	mc.fillRect(10,10,130,130);
// var path=new Path2D();
// 	path.arc(75,75,50,0,Math.PI/2,true);
// 	path.moveTo(110,70);
// 	path.arc(75,75,35,0,Math.PI,false);
// 	path.moveTo(65,65);
// 	path.arc(60,65,5,0,Math.PI*2,false);
// 	path.moveTo(95,65);
// 	path.arc(90,65,5,0,Math.PI*2,false);
// 	mc.strokeStyle='#0000ff';
// 	mc.stroke(path);

function count()
{
    var arr = [];
    for (var i=1; i<=3; i++) 
    {
        arr.push(function () 
        {
            return i * i;
        }
        );
    }
    return arr;
}

var results = count();
var f1 = results[0];
console.log(f1());
</script>
<?php 
$act="invest.money&usrid=6000060000888124&transamt=100&borrowerid=6000060001741290&borrowid=1342&ReqExt%5BVocher%5D%5BAcctId%5D=MDT000001&ReqExt%5BVocher%5D%5BVocherAmt%5D=30";
echo urldecode($act);
?>
</body>
</html>
