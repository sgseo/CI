<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>js操作dom和css权值优先级</title>
	<style type='text/css'>
	/*	div{
			color:red;
		}*/
	.red{
		color:red;
	}
	.green{
		color: green;
	}
	</style>
	<link rel="stylesheet" href="ceshi.css" media='screen'/>

		<style>
h1{font:bold 20px/1.5 georgia,simsun,sans-serif;}
.box{display:-webkit-box;display:-moz-box;display:-ms-box;width:600px;height:180px;margin:0;padding:0;list-style:none;}
#box{-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-ms-box-orient:horizontal;box-pack:justify;}
#box2{-webkit-box-orient:vertical;-moz-box-orient:vertical;-ms-box-orient:vertical;box-pack:justify}
.box li:nth-child(1){-webkit-box-flex:1;-moz-box-flex:1;-ms-box-flex:1;background:#666;}
.box li:nth-child(2){-webkit-box-flex:2;-moz-box-flex:2;-ms-box-flex:2;background:#999;}
.box li:nth-child(3){-webkit-box-flex:3;-moz-box-flex:3;-ms-box-flex:3;background:#ccc;}
</style>

</head>
<body>

	<div class="parent">
		<p>我应该是黄色</p>
		<div class="child">
			<p>
				猜猜我是谁
			</p>
		</div>
	</div>



<h1>子元素横向排列 box-orient:horizontal;</h1>
<ul id="box" class="box">
	<li>1</li>
	<li>2</li>
	<li>3</li>
</ul>
<h1>子元素纵向排列 box-orient:vertical;</h1>
<ul id="box2" class="box">
	<li>1</li>
	<li>2</li>
	<li>3</li>
</ul>
<input type="radio" id="rad1" name="rad" /><label for="rad1">选项一</label>
<input type="radio" id="rad2" name="rad" /><label for="rad2">选项二</label>

</body>
</html>