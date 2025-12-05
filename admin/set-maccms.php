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
          <cite>苹果cms对接设置</cite></a>
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
			开启后启用相应的功能！<br></blockquote>

              <form class="layui-form">
        <div class="layui-form-item">
        <label class="layui-form-label">V8对接</label>
        <div class="layui-input-block">
          <input type="radio" name="v8state" value="1" title="开启" ';
if ($mac['v8state'] == 1) {
    echo 'checked=""';
}
echo ' >
          <input type="radio" name="v8state" value="0" title="不开启" ';
if ($mac['v8state'] == 0) {
    echo 'checked=""';
}
echo ' >
        </div>
      </div>

  
	  
                <div class="layui-form-item">
                  <label for="v8url" class="layui-form-label">V8域名</label>
                  <div class="layui-input-inline">
                    <input type="text" id="v8url" name="v8url" required="" value="';
echo $mac['v8url'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>需要带 http://，要加后台目录名称，结尾不加 "/"  如：http://www.baidu.com/admin</div></div>

                <div class="layui-form-item">
                  <label for="v8pass" class="layui-form-label">V8入库密码</label>
                  <div class="layui-input-inline">
                    <input type="text" id="v8pass" name="v8pass" required="" value="';
echo $mac['v8pass'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>在苹果cmsv8后台，系统->站外入库配置->入库免登录密码中查看</div></div>

        <div class="layui-form-item">
        <label class="layui-form-label">V10对接</label>
        <div class="layui-input-block">
          <input type="radio" name="v10state" value="1" title="开启" ';
if ($mac['v10state'] == 1) {
    echo 'checked=""';
}
echo ' >
          <input type="radio" name="v10state" value="0" title="不开启" ';
if ($mac['v10state'] == 0) {
    echo 'checked=""';
}
echo ' >
        </div>
      </div>	
                <div class="layui-form-item">
                  <label for="v10url" class="layui-form-label">V10域名</label>
                  <div class="layui-input-inline">
                    <input type="text" id="v10url" name="v10url" required="" value="';
echo $mac['v10url'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>需要带 http:// 结尾不加 "/"  如：http://www.baidu.com</div></div>
					
                <div class="layui-form-item">
                  <label for="v10pass" class="layui-form-label">V10入库密码</label>
                  <div class="layui-input-inline">
                    <input type="text" id="v10pass" name="v10pass" required="" value="';
echo $mac['v10pass'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>在苹果cmsv10后台，系统->站外入库配置->入库免登录密码中查看</div></div>

                <div class="layui-form-item">
                  <label for="play_from" class="layui-form-label">播放器</label>
                  <div class="layui-input-inline">
                    <input type="text" id="play_from" name="play_from" required="" value="';
echo $mac['play_from'];
echo '" autocomplete="off" class="layui-input"></div>
                  <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>填写播放器编码，比如填写mp4，那么不管V8还是V10都用编码为mp4的播放器来播放视频</div></div>


                <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label"></label>
                  <button class="layui-btn" lay-filter="edit" lay-submit="">保存</button>
				  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
	  <script src="../js/set-maccms.js" charset="utf-8"></script>	  
  </body>

</html>';