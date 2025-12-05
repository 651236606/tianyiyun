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
          <cite>播放器设置</cite></a>
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
			<blockquote class="layui-elem-quote">
			例如：对接到苹果cms里面，你这里关闭本地播放器，那么苹果cms那边你就要自己配置播放器<br>
			如果你不会在其他程序中配置播放器，那么直接用本程序自带的播放器吧！</blockquote>

              <form class="layui-form">
        <div class="layui-form-item">
        <label class="layui-form-label">本地播放器</label>
        <div class="layui-input-inline">
          <input type="radio" name="state" value="1" title="启用" ';
if ($player['state'] == 1) {
    echo 'checked=""';
}
echo ' >
          <input type="radio" name="state" value="0" title="关闭" ';
if ($player['state'] == 0) {
    echo 'checked=""';
}
echo ' >
        </div>
		<div class="layui-form-mid layui-word-aux">启用后使用本程序自带的播放器播放视频，关闭后，直接输出播放地址！</div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">自动播放</label>
        <div class="layui-input-inline">
          <input type="radio" name="autoplay" value="1" title="启用" ';
if ($player['autoplay'] == 1) {
    echo 'checked=""';
}
echo ' >
          <input type="radio" name="autoplay" value="0" title="关闭" ';
if ($player['autoplay'] == 0) {
    echo 'checked=""';
}
echo ' >
        </div>
        <div class="layui-form-mid layui-word-aux">只针对PC端，移动端不支持自动播放！</div>
      </div>
	  
                <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label"></label>
                  <button class="layui-btn" lay-filter="edit" lay-submit="">保存</button>
				  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript" src="../js/set-player.js"></script>	  
  </body>
</html>';