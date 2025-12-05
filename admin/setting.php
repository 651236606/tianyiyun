<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include 'config.php';
error_reporting(0);
echo '<!DOCTYPE html>
<html class="x-admin-sm">
  <head>
    <meta charset="UTF-8">
    <title>网站设置 - 基础设置</title>
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
          <cite>基本设置</cite></a>
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
              <form class="layui-form">
                <div class="layui-form-item">
                  <label for="site_name" class="layui-form-label">
                    <span class="x-red">*</span>网站名称</label>
                  <div class="layui-input-inline">
                    <input type="text" id="site_title" name="site_title" required="" lay-verify="required" value="';
echo $site['title'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>不超过8个汉字</div></div>
                <div class="layui-form-item">
                  <label for="site_url" class="layui-form-label">
                    <span class="x-red">*</span>网站域名</label>
                  <div class="layui-input-inline">
                    <input type="text" id="site_url" name="site_url" required="" lay-verify="url" value="';
echo $site['url'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>需要带 http:// 结尾不加 "/"  如：http://www.baidu.com</div></div>
                <div class="layui-form-item">
                  <label for="site_path" class="layui-form-label">
                    <span class="x-red">*</span>安装目录</label>
                  <div class="layui-input-inline">
                    <input type="text" id="site_path" name="site_path" required="" lay-verify="required" value="';
echo $site['path'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>程序安装在哪个目录，如果是安装在二级目录，这里就填写二级目录名</div></div>
					
                <div class="layui-form-item">
                    <label class="layui-form-label">伪静态</label>
                    <div class="layui-input-inline">
                      <input type="radio" name="rewrite" value="1" title="开启" ';
if ($site['rewrite'] == 1) {
    echo 'checked=""';
}
echo '>
                      <input type="radio" name="rewrite" value="0" title="不开启" ';
if ($site['rewrite'] == 0) {
    echo 'checked=""';
}
echo '>
                    </div>
                <div class="layui-form-mid layui-word-aux">
                   <span class="x-red">*</span>开启伪静态必须在程序根目录建立伪静态规则，无规则的情况下，开启无效！</div>		
                </div>	
                <div class="layui-form-item">
                  <label for="site_qq" class="layui-form-label">联系QQ</label>
                  <div class="layui-input-inline">
                    <input type="text" id="site_qq" name="site_qq" required="" autocomplete="off" value="';
echo $site['qq'];
echo '" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>不超过11位数字</div>
                </div>
                <div class="layui-form-item">
                  <label for="site_tj" class="layui-form-label">统计代码</label>
                  <div class="layui-input-block">
                    <textarea placeholder="请输入统计代码，例如：友盟、百度统计" id="site_tj" name="site_tj" class="layui-textarea">';
echo $site['tj'];
echo '</textarea>
					</div>
				</div>
                <div class="layui-form-item">
                  <label for="site_foot" class="layui-form-label">底部代码</label>
                  <div class="layui-input-block">
                    <textarea placeholder="仅在分享页面、播放页面展示，可输入广告代码、一些自定义js代码、html等，可不填写" id="site_foot" name="site_foot" class="layui-textarea">';
echo $site['foot'];
echo '</textarea>
					</div>
				</div>
                <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label"></label>
                  <button class="layui-btn" lay-filter="edit" lay-submit="">保存</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript" src="../js/setting.js"></script>
  </body>
</html>';