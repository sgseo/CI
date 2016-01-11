<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>蜗牛后台管理系统</title>
    <meta charset="UTF-8">
   <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/style.css" />
    <script type="text/javascript" src="/Public/Js/jquery.js"></script>
    <script type="text/javascript" src="/Public/Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="/Public/Js/bootstrap.js"></script>
    <script type="text/javascript" src="/Public/Js/ckform.js"></script>
    <script type="text/javascript" src="/Public/Js/common.js"></script>
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }
        .container{
            margin-top: 150px;
            margin-left: 200px;
        }
        .form-signin {
            max-width: 300px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
        }
        .form-left{
          max-width: 400px;
          padding: 19px 29px 29px;
          /*margin: 0 auto 20px;*/
          float:right;
          background-color: #fff;
          border: 1px solid #e5e5e5;
          -webkit-border-radius: 5px;
          -moz-border-radius: 5px;
          border-radius: 5px;
          -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
          -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
          box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }
        .logo-left{
          width: 400px;
          padding: 20px 20px;
          height: 295px;
          /*margin: 0 auto 20px;*/
          text-align: center;
          float:right;
          background-color: #fff;
          border: 1px solid #e5e5e5;
          -webkit-border-radius: 5px;
          -moz-border-radius: 5px;
          border-radius: 5px;
          -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
          -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
          box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        }
    </style>  
</head>
<body>
<div class="container">
<div class='form-left'>
    <form class="form-signin" method="post" action="/Home/Admin/snail_login_ing">
        <h2 class="form-signin-heading">蜗牛后台登录系统</h2>
        <input type="text" name="username" class="input-block-level" placeholder="用户名"/>
        <input type="password" name="password" class="input-block-level" placeholder="密码"/>
        <!-- <input type="text" name="verify" class="input-medium" placeholder="验证码"> -->
       
        <p><button class="btn btn-large btn-primary" type="submit">登录</button></p>
    </form>
</div>
    <div class='logo-left'><img src='/Public/home/images/snail.png'</div>
</div>

</body>
</html>