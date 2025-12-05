<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include 'config.php';
echo '<!doctype html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>后台管理页面</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/xadmin.css">
        <script src="../lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/xadmin.js"></script>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            // 是否开启刷新记忆tab功能
            // var is_remember = false;
        </script>
    </head>
    <body class="index">
        <!-- 顶部开始 -->
        <div class="container">
            <div class="logo">
                <a href="./">天翼云盘管理</a></div>
            <div class="left_open">
                <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
            </div>
            <ul class="layui-nav right" lay-filter="">	
                <li class="layui-nav-item to-index"><a href="';
echo $site['path'];
echo '" target="_blank">前台首页</a></li>				
                <li class="layui-nav-item">				
                    <a href="javascript:;">';
echo $user_name;
echo '</a>
                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a onclick="xadmin.open(\'修改密码\',\'./admin_edit.php\',500,300)">修改密码</a></dd>
                        <dd>
                            <a href="./ajax.php?action=logout">退出</a></dd>
                    </dl>
                </li>					
            </ul>
        </div>
        <!-- 顶部结束 -->
        <!-- 中部开始 -->
        <!-- 左侧菜单开始 -->
        <div class="left-nav">
            <div id="side-nav">
                <ul id="nav">
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="网站设置">&#xe6ae;</i>
                            <cite>网站设置</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab(\'基本设置\',\'setting.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>基本设置</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab(\'播放器设置\',\'set-player.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>播放器设置</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab(\'对接苹果cms设置\',\'set-maccms.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>对接苹果cms设置</cite></a>
                            </li>							
                            <li>
                                <a onclick="xadmin.add_tab(\'邮箱设置\',\'set-email.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>邮箱设置</cite></a>
                            </li>							
                            <li>
                                <a onclick="xadmin.add_tab(\'防盗链设置\',\'set-domain.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>防盗链设置</cite></a>
                            </li>							
                            <li>
                                <a onclick="xadmin.add_tab(\'修改密码\',\'admin_edit.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>修改密码</cite></a>
                            </li>
                        </ul>
                    </li>		
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="账号管理">&#xe6b8;</i>
                            <cite>账号管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab(\'我的账号\',\'user-list.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>我的账号</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab(\'我的分享\',\'share-list.php\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>我的分享</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab(\'文件上传\',\'https://cloud.189.cn/main.action\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>文件上传</cite></a>
                            </li>							
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="站长工具">&#xe6b4;</i>
                            <cite>站长工具</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab(\'随机密码生成器\',\'https://suijimimashengcheng.51240.com/\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>随机密码生成器</cite></a>
                            </li>	
                            <li>
                                <a onclick="xadmin.add_tab(\'多功能工具箱\',\'https://tool.lu/\')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>多功能工具箱</cite></a>
                            </li>								
                        </ul>
                    </li>					
            </div>
        </div>
        <!-- <div class="x-slide_left"></div> -->
        <!-- 左侧菜单结束 -->
        <!-- 右侧主体开始 -->
        <div class="page-content">
            <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
                <ul class="layui-tab-title">
                    <li class="home">
                        <i class="layui-icon">&#xe68e;</i><span class="layui-nav-more"></span>我的桌面</li>
				</ul>

                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe src=\'./welcome.php\' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                    </div>
                </div>
                <div id="tab_show"></div>
            </div>
        </div>
        <div class="page-content-bg"></div>
        <style id="theme_style"></style>
        <!-- 右侧主体结束 -->
        <!-- 中部结束-->
    </body>
</html>';