<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include 'config.php';
error_reporting(0);
echo '<!DOCTYPE html>
<html class="x-admin-sm">
  <head>
    <meta charset="UTF-8">
    <title>网站设置 - 邮件设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/xadmin.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script src="../lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="../js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--></head>
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">网站设置</a>
        <a>
          <cite>邮箱设置</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
      </a>
    </div>
    <div class="layui-fluid">
      <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
          <div class="layui-card">
            <div class="layui-card-body ">
			<blockquote class="layui-elem-quote"><b class="x-red">发送邮件请开启openssl扩展库，否则无法发送邮件</b>！<a target="_blank" href="https://www.cnblogs.com/imysql/p/6370141.html" style="color:blue">点此查看开启方式</a><br>
			开启邮箱通知，则cookies失效进行邮件通知，通知频率每小时1次，由用户访问触发！<br>
			如果你不会配置，或者配置不成功，此功能不要开启即可</blockquote>

              <form class="layui-form">
        <div class="layui-form-item">
        <label class="layui-form-label">邮箱通知</label>
        <div class="layui-input-block">
          <input type="radio" name="mailon" value="1" title="开启" ';
if ($email['mailon'] == 1) {
    echo 'checked=""';
}
echo ' >
          <input type="radio" name="mailon" value="0" title="不开启" ';
if ($email['mailon'] == 0) {
    echo 'checked=""';
}
echo ' >
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">邮箱服务器</label>
        <div class="layui-input-inline">
          <input type="text" name="host" id="host" lay-verify="required"  value="';
echo $email['host'];
echo '" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">如：smtp.qq.com</div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">邮箱端口</label>
        <div class="layui-input-inline">
          <input type="text" name="port" id="port" lay-verify="required"  value="';
echo $email['port'];
echo '" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">如：465</div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">邮箱发件账号</label>
        <div class="layui-input-inline">
          <input type="text" name="user" id="user" lay-verify="email"  value="';
echo $email['user'];
echo '" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">如：209910539@qq.com；<a target="_blank" href="https://service.mail.qq.com/cgi-bin/help?subtype=1&no=166&id=28" style="color:blue">QQ邮箱如何打开SMTP？点此查看>></a></div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">邮箱密码</label>
        <div class="layui-input-inline">
          <input type="password" name="pass" id="pass" lay-verify="required"  value="';
echo $email['pass'];
echo '" class="layui-input">
        </div>
      <div class="layui-form-mid layui-word-aux">如果是QQ邮箱，这里密码不是QQ登陆密码，是邮箱授权码；<a target="_blank" href="https://service.mail.qq.com/cgi-bin/help?subtype=1&&no=1001256&&id=28" style="color:blue">QQ邮箱如何获取授权码？点此查看>></a></div>
      </div>
	  
      <div class="layui-form-item">
        <label class="layui-form-label">接收通知账号</label>
        <div class="layui-input-inline">
          <input type="text" name="email" id="email" lay-verify="email" value="';
echo $email['email'];
echo '" class="layui-input">
        </div>
       <div class="layui-form-mid layui-word-aux">就是你要接收通知的邮箱账号，可以和发件账号一样，也可以另外设置账号接收通知</div>
      </div>
                <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label"></label>
                  <button class="layui-btn" lay-filter="edit" lay-submit="">保存</button>
				  <p class="layui-btn" id="ceshi">测试发件</p>
				  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
	  <script src="../js/set-email.js" charset="utf-8"></script>	  
  </body>

</html>';