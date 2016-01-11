<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML>
<html>
 <head>
  <title>后台管理系统</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="/Public/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="/Public/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="/Public/assets/css/main-min.css" rel="stylesheet" type="text/css" />
 </head>
 <body>

  <div class="header" style="height:100px;width:1920px;">
    
      <div class="dl-title" >
       <img src="/Public/assets/img/top.png">
      </div>

   
    <div class="dl-log">欢迎您，<span class="dl-log-user"><?php echo (session('username')); ?></span><a href="/Home/Admin/cl_login_out" title="退出系统" class="dl-log-quit">[退出]</a>
  
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
        		<li class="nav-item dl-selected"><div class="nav-item-inner nav-home">蜗牛创意</div></li>
            <!-- <li class="nav-item dl-selected"><div class="nav-item-inner nav-order">业务管理</div></li>  -->      
      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>
  <script type="text/javascript" src="/Public/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="/Public/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="/Public/assets/js/common/main-min.js"></script>
  <script type="text/javascript" src="/Public/assets/js/config-min.js"></script>
  <script>
  //console.log(/Home);
    BUI.use('common/main',function(){
      var config = [{id:'1',menu:[            
                                    {text:'蜗牛创意后台管理',
                                          items:[{id:'12',text:'添加经验',href:'/Home/Admin/addexp'},
                                                  {id:'3',text:'添加文章',href:'/Home/Admin/addarticle'},
                                                  {id:'5',text:'添加新成员',href:'/Home/Admin/addnewbie'},
                                                  // {id:'4',text:'区域划分',href:'/Home/Menu/index'},///Home/User/index
                                                  // {id:'6',text:'等待开发',href:'#'},///Home/Menu/index
                                                ]
                                    }
                                  ]},
                    {id:'7',homePage : '9',menu:[{text:'业务管理',items:[{id:'9',text:'查询业务',href:'/Home/Node/index'}]}]
              }];

      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
 </body>
</html>