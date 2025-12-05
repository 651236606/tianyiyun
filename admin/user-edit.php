<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-type: text/html; charset=utf-8');
include 'config.php';
error_reporting(0);
$id = @$_GET['id'];
if (!is_numeric($id)) {
    exit('参数错误！');
}
$db = new M($hostname, $username, $password, $database);
$sql = 'SELECT * FROM ty_user WHERE id=' . $id . '';
$row = $db->getRow($sql);
$t_id = $row['uid'];
$t_pass = $row['pass'];
$t_cookie = $row['cookie'];
$t_beizhu = $row['beizhu'];
$db->close();
echo '<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>修改账号</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/xadmin.css">
        <script type="text/javascript" src="../lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/xadmin.js"></script>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script src="../js/1.js?123456"></script>
		<script src="../js/jquery.clipboard.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                  <div class="layui-form-item">
                      <label for="tyuser" class="layui-form-label">
                          <span class="x-red">*</span>天翼账号
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="ty_id" name="ty_id" value="';
echo $t_id;
echo '" disabled lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>一般为手机号，不加@189.cn
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="ty_pass" class="layui-form-label">
                          <span class="x-red">*</span>登陆密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="ty_pass" name="ty_pass" value="';
echo $t_pass;
echo '" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div><p class="x-admin-sm layui-btn" id="copy" data-clipboard-text="';
echo $t_pass;
echo '">复制密码</p>
                  </div>
                  <div class="layui-form-item">
                      <label for="beizhu" class="layui-form-label">备注</label>
                      <div class="layui-input-inline">
                          <input type="text" id="beizhu" name="beizhu" value="';
echo $t_beizhu;
echo '" autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">账号备注，非必填</div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="edit" lay-submit="">
                           保存修改
                      </button>
                      <button  class="layui-btn" id="login">
                           重新登陆
                      </button>					  
                  </div>				  
              </form>
            </div>
        </div>			
        <script type="text/javascript" src="../js/user-edit.js"></script>	
    </body>
</html>
';