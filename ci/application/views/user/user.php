<html>  
    <head>  
        <meta http-equiv="content-type" content="text/html; charset=utf-8">  
        <title>一个ci分页类-示例</title>  
       
    </head>  
    <body>  
        <div id="test">1111</div>
        <div>  
            <table width="500px">  
                <tr>  
                    <th>ID号</th>  
                    <th>姓名</th>  
                    <th>头像</th>  
                   
                </tr>  
            
                <?php foreach ($userList as $item): ?>  
                <tr style="text-align:center;">  
                    <td><?=$item['id']?></td>  
                    <td><?php echo $item['name'] ;?></td>  
                    <td><img src=<?php echo $url.substr($item['b_thumb'],2);?> /></td>
                    <?php echo ul($item);?>
                   <!-- <td>上一个链接的地址为：<?php echo $_SERVER['HTTP_REFERER'];?></td>-->
                  <!--./upload/big_thumb/2014/11/19/20131227233154_3aeeS_300_300.jpg-->
                </tr>  
                <?php endforeach; ?>  
               
                 <?php echo heading("welcome","1");?>
            </table> 
  
            <form action="/ci/index.php/user/add" method="post" enctype="multipart/form-data">
            用户名：<input type="text" name="name" value=""/><br/>
            昵称：<input type="text" name="nickname" value=""/><br/>
            密码：<input type="password" name="password" value=""/><br/>
            确认密码：<input type="password" name="confirm" value=""/><br/>
            邮箱：<input type="text" name="mail" value=""/><br/>

            电话：<input type="text" name="tel" value=""/><br/>
               <!-- <input type="file" name="img" value="浏览"/>-->
            <input type="submit" value="提交"/>
            </form>
    
        </div>  
        <?php echo $page;?>
    </body>  
</html>