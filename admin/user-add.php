<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-type: text/html; charset=utf-8');
include 'config.php';
error_reporting(0);
echo '<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>添加账号</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/xadmin.css">
        <script type="text/javascript" src="../lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/xadmin.js"></script>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script src="../js/1.js?123456"></script>
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
                          <input type="text" id="ty_id" name="ty_id" required="" lay-verify="required"
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
                          <input type="password" id="ty_pass" name="ty_pass" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>网盘登陆密码
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="beizhu" class="layui-form-label">备注</label>
                      <div class="layui-input-inline">
                          <input type="text" id="beizhu" name="beizhu" required="" autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">账号备注，非必填</div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          保存并登陆
                      </button>
                  </div>
				  <div class="layui-form-item">
				      <label class="layui-form-label"></label>
				      <div class="layui-form-mid layui-word-aux">如果返回提示需要验证码，说明账号登陆异常，<br>请更换其他账号登陆，异常的账号，等一段时间再登陆试试！</div>
				  </div>
              </form>
            </div>
        </div>			
      <script type="text/javascript" src="../js/user-add.js"></script>
    </body>
</html>
';