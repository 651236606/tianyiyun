<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include 'config.php';
error_reporting(0);
$id = @$_GET['id'];
if (!is_numeric($id)) {
    exit('参数错误！');
}
$db = new M($hostname, $username, $password, $database);
$sql = 'SELECT * FROM ty_share WHERE id=' . $id . '';
$row = $db->getRow($sql);
$name = $row['name'];
$pass = $row['pass'];
$state = $row['state'];
$mode = $row['mode'];
$text = $row['text'];
$db->close();
echo '<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>修改分享信息</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/xadmin.css">
        <script type="text/javascript" src="../lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/xadmin.js"></script>
		<script src="../js/jquery.clipboard.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
	
    <div class="layui-fluid">
      <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
          <div class="layui-card">	
		   <div class="layui-card-body">
                <form class="layui-form">
                  <div class="layui-form-item">
                      <label for="tyuser" class="layui-form-label">分享文件名</label>
                      <div class="layui-input-block">
                          <input type="text" id="name" name="name" value="';
echo $name;
echo '" required="" lay-verify="required"
                          autocomplete="off" class="layui-input" disabled="">
                      </div>
                  </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">分享形式</label>
                  <div class="layui-input-inline" style="width:100px">
                    <select name="mode" lay-filter="mode">
                      <option value="1" ';
echo $mode ? 'selected' : '';
echo '>有提取码</option>
                      <option value="0" ';
echo $mode ? '' : 'selected';
echo '>无提取码</option></select>
                  </div>
                  <div class="layui-form-mid layui-word-aux">有提取码则需要输入提取码查看，无提取码则打开链接即可查看</div></div>
                <div class="mode mode_1" ';
echo $mode ? '' : 'style="display: none;"';
echo '>
                  <div class="layui-form-item">
                    <label class="layui-form-label">提取码</label>
                    <div class="layui-input-inline" style="width:100px">
                      <input type="text" name="pass" id="mima" lay-verify="mima" value="';
echo $pass;
echo '" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">可自定义提取码，不超过4个字符！</div></div>
                  <div class="layui-form-item">
                    <label for="text" class="layui-form-label">一句话引流</label>
                    <div class="layui-input-block">
                      <textarea placeholder="例如：关注公众号，获取提取码，或者加群获取提取码，自由发挥，可留空！" id="text" name="text" class="layui-textarea">';
echo $text;
echo '</textarea>
                    </div>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label for="site_name" class="layui-form-label">有效期</label>
                  <div class="layui-input-block">
                    <input type="radio" name="endtime" value="2147483647" title="永久有效" checked="">
                    <input type="radio" name="endtime" value="';
echo strtotime('+7day');
echo '" title="7天">
                    <input type="radio" name="endtime" value="';
echo strtotime('+1day');
echo '" title="1天"></div>
                </div>				
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label"></label>
					  <input type="hidden" name="id" value="';
echo $id;
echo '" />
                      <button  class="layui-btn" lay-filter="edit" lay-submit="">保存修改</button>
					  <button  class="layui-btn" onclick="xadmin.close();return false;">放弃</button>
                  </div>				  
              </form>

  </div> </div>
			   </div>
            </div>
        </div>			
        <script type="text/javascript" src="../js/share-edit.js"></script>
    </body>
</html>
';