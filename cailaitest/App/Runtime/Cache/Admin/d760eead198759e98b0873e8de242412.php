<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <script type="text/javascript" src="__ROOT__/Style/A/js/jquery.js"></script>
<meta charset="utf-8">
<title></title> 
<style>

#container{ width:800px; margin:0 auto; display:block;}
.input1{ width:260px;line-height:22px; min-height:22px;padding:3px;} 

.input2{ width:230px;line-height:22px; min-height:22px;padding:3px;}  

.table_100{width:99%;float:left;height:auto;background:#cecece;color:#000;margin:5px 0; text-align:center;}
.table_100 tr{ background:#fff;} 
.table_100 tr td{ padding:10px 3px;}
.table_100 tr:nth-of-type(odd) {background: #eeeded}   
.tdTitle {padding-left: 10px; font-size: 18px; height:40px; line-height: 40px; vertical-align: middle; width: 110px; color: #000; }
#submit {height:26px; line-height:16px; vertical-align: middle;vertical-align: middle; width:100px;}
 
.table_100s{width:99%;float:left;height:auto;background:#fff;color:#000;margin:5px 0;}
.table_100s tr{ background:#fff; font-size:16px;} 
.table_100s tr td{ padding:3px;}    
.red{ color:red; }
.list_bottom_right { width:100%; float:right;}
.list_bottom_right ul{height:26px;margin-top:8px; float:right; text-align:right;}

.list_bottom_right ul span.current {width:32px;height:30px;font-size: 16px;line-height:30px; display:block; float:left;
border:#00b7ef solid 1px; background:#00b7ef;color: #fff;text-align: center;margin-right:5px;}

.list_bottom_right ul a{width:32px;height:30px;font-size:14px;line-height:30px;color: #949494;float:left;display:block; text-align:center; border:1px solid #ccc;margin-right:8px; text-decoration:none;background:#fff;}
.list_bottom_right ul a:hover {color:#00b7ef; border:#00b7ef solid 1px; background:#00b7ef;}
.list_bottom_right ul a.prevnext{padding:0px 10px 0px 10px;border:1px solid #ccc;color:#666;width:50px;background:#fff;height:30px;line-height:30px;}
.list_bottom_right ul a.prevnext:hover{color:#00b7ef;border:1px solid #00b7ef;background:#fff;}
.list_bottom_right ul a:hover{color:#fff;}
.list_bottom_right ul a.delcolor:hover{color:#00b7ef; border:#00b7ef solid 1px; background:#fff;}
.list_bottom_right ul a.delcolor{padding:0px 10px 0px 10px;border:1px solid #ccc;color:#666;width:50px;background:#fff;height:30px;line-height:30px;}
</style>
<script type="text/javascript">
    //hover 
   $(document).ready(function(){
        $('.del').live({
            mouseover:function(){
                $(this).css('color','red');
            },
            mouseout:function(){
                $(this).css('color','');
            }
        })
       
       $('.del').live('click',function(){
           var id = $(this).siblings('.blackid').html();
           if(confirm('确定要删除'+id+'吗？')){
               $.ajax({
                type:'post',
                url:"__URL__/index",
                dataType:'json',
                data:{'type':'zwdel','id':id},
                success:function(str){
                    console.log(str);  
                    console.log(str.status);  
                    if(str.status=='1'){
                       alert('删除成功！')
                    }else{
                        alert('删除失败！')
                    }
                    
                         self.location.reload();                
       }
   })
           }else{
               alert('你已经取消删除！');
           }
       });
   })
   


</script>

</head>
<body>
 
<div class="clear"></div>
<div id="container">
<form action="__URL__/memberrec" method="post">     
    <table class="table_100s" cellpadding="1" cellspacing="1">
        <tr> 
            <td width="19%">按照手机号搜索： </td> 
            <td width="32%"><input name="searchtel" type="text" class="input2"></td>
            <td width="49%"><input type="submit" id="submit" value="确定"> </td>
        </tr>  
    </table>      
</form>     
<table class="table_100" cellpadding="1" cellspacing="1">

    <tr>
        <td width="35">id</td>
        <td  class="tdTitle">姓名 </td>
        <td  class="tdTitle">手机号</td>
        <td  class="tdTitle">推荐人id</td>
        <td  class="tdTitle">推荐人手机号</td>
        <td  class="tdTitle">推荐人姓名</td>
        <td  class="tdTitle">操作</td>

    </tr> 
        <?php foreach($minfo as $v) {?>
        <!-- class="<?php echo $v['flage'];?>" -->
    <tr >        
        <td class="blackid">   <?php echo $v['id']; ?>         </td>         
        <td><?php echo $v['sreal_name']; ?></td>
        <td><?php echo $v['user_phone']; ?></td>
        <td><?php echo $v['recommend_id'];?></td> 
         <td><?php echo $v['cell_phone'];?></td>
        <td><?php echo $v['real_name'];?></td>
        <td><a href="__URL__/marec?id=<?php echo $v['id'];?>" style="text-decoration:none;">修改推荐人</a></td>


        <!--  <td class="red"><?php if($v['flage']=='red'){echo '异常'; } else{ echo '';} ?></td> -->
        <!--td style="cursor:pointer;" class="del"></td-->
    </tr> 
       <?php } ?>
</table>  
<div class="clear"></div>  
 
<div class="list_bottom">
        <div class="list_bottom_right">
            <ul>
                <?php echo ($page); ?>
            </ul>
        </div>
 </div>
    
</div>
 
</body>
</html>