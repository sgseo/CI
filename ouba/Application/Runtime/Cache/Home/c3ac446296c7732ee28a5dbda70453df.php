<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
 <head>
  <title>财来做单管理系统</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="/Public/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="/Public/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="/Public/assets/css/main-min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"/>
 </head>
 <body>

  <div class="header" >
      <div class="dl-title" >
       <img src="/Public/assets/img/top.png">
      </div>

    <div class="dl-log" >
            欢迎您，<span class="dl-log-user"><?php echo (session('username')); ?></span>
      <a href="/index.php/Home/Index/cl_login_out" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>

   </div>
    </div>
    <div style="clear:both"></div>
      <input type='hidden' id='status' value='<?php echo (session('status')); ?>'/>
     <input type='hidden' id='pid' value='<?php echo (session('pid')); ?>'/>
  </div>
   <div class="content" >
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
          <ul id="J_Nav"  class="nav nav-list ks-clear navbar-fixed-top">
            <li class="nav-item dl-selected" id='system' style='display:none'><div class="nav-item-inner nav-home">系统管理</div></li>
            <li class="nav-item dl-selected" id='yewu' style='display:none'><div class="nav-item-inner nav-order">业务管理</div></li>
             <li class="nav-item dl-selected" id='zhaiwu' style='display:none'><div class="nav-item-inner nav-order">催收管理</div></li>
            <li class="nav-item dl-selected" id='mission' style='display:none'><div class="nav-item-inner nav-order">我的任务</div></li> 
            <li class="nav-item dl-selected" id='pro' style='display:none'><div class="nav-item-inner nav-order">项目录入</div></li>     
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
  var status=$("#status").val();
  var pid=$("#pid").val();//为了区分不同的机构
     if(status==9 && pid==1)
      {
        $("#system").show();
        $("#yewu").show();
        $("#zhaiwu").show();
        var config = [
                    {id:'1',menu:[            
                                    {text:'系统管理',
                                          items:[
                                          // {id:'12',text:'角色管理',href:'/index.php/Home/Role/index'},
                                          {id:'13',text:'角色列表',href:'/index.php/Home/Role/indexlist'},
                                                 {id:'8',text:'行为日志',href:'/index.php/Home/User/logop'},
                                                 // {id:'10',text:'机构管理',href:'/index.php/Home/Role/manage'},
                                                   {id:'11',text:'机构列表',href:'/index.php/Home/Role/managelist'},
                                                 {id:'23',text:'标的操作记录',href:'/index.php/Home/Node/index'},
                                              
                                                ]
                                    }
                                  ]},
                    {id:'7',menu:[
                                    {text:'业务管理',
                                      items:[
                                      {id:'13',text:'贷款列表',href:'/index.php/Home/User/end'},
                                      // {id:'4',text:'贷款录入',href:'/index.php/Home/Menu/index'},
                                      {id:'5',text:'项目审批',href:'/index.php/Home/Menu/admitshow'},
                                      // {id:'7',text:'贷款修改',href:'/index.php/Home/Menu/showlist'},
                                      {id:'8',text:'合同打印',href:'/index.php/Home/Menu/printer'},
                                      {id:'6',text:'贷款分配',href:'/index.php/Home/Menu/allotlist'},//
                                      {id:'10',text:'做单过程',href:'/index.php/Home/Role/process'},
                                      {id:'9',text:'风控复核',href:'/index.php/Home/Role/riskcontrol'},
                                      {id:'11',text:'放款审批',href:'/index.php/Home/Node/confirm'},
                                      {id:'12',text:'贷款还款',href:'/index.php/Home/User/index'},
                                      
                                      ]
                                    }
                                  ]},
                       {id:'8',menu:[            
                                    {text:'催收管理',
                                          items:[{id:'12',text:'催收列表',href:'/index.php/Home/Role/debt'},
                                                ]
                                    }
                                  ]},
           
                  ];
      }else if(status==2 && pid==1)
      { 
          $("#pro").show();
       var config = [
                    {id:'1',menu:[            
                                    {text:'贷款录入',
                                          items:[
                                                  {id:'4',text:'贷款录入',href:'/index.php/Home/Menu/index'},//
                                                  {id:'5',text:'贷款列表',href:'/index.php/Home/Menu/showlist'},

                                                ]
                                    }
                                  ]},
                     ];
      }else if(status==8 && pid==1){
        $("#mission").show();
        var config = [
                         {id:'9',menu:[
                         {text:'我的任务',
                              items:[
                               {id:'11',text:'未完成的任务',href:'/index.php/Home/Role/mytask'},
                               {id:'9',text:'已处理的任务',href:'/index.php/Home/Role/donetask'},
                               {id:'10',text:'催收还款日历',href:'/index.php/Home/Role/calendar'},
                               {id:'8',text:'催收列表',href:'/index.php/Home/Role/debt'}
                               // {id:'9',text:'查询业务',href:'/index.php/Home/Node/index'},
                              ]
                            }
                          ]}
                      ];
      }else if(status==9 && pid!=1)
      { 
       $("#yewu").show();
          var config = [
                         {id:'10',menu:[
                         {text:'业务管理',
                              items:[
                               {id:'11',text:'风控复核',href:'/index.php/Home/Role/riskcontrol'},
                              ]
                            }
                          ]}
                      ];
      }

    BUI.use('common/main',function(){    
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
 </body>
</html>