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
        <title>欢迎页面-天翼云盘管理</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/xadmin.css">
        <script src="../lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/xadmin.js"></script>
		<script type="text/javascript">var version = \'3.4\';</script>
        <script type="text/javascript" src="//caiji-api.oss-cn-shanghai.aliyuncs.com/ty189/update.js"></script>			
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
                        <div class="layui-card-body ">
                            <blockquote class="layui-elem-quote">欢迎管理员：
                                <span class="x-red">';
echo $user_name;
?></span>！当前时间:<?php 
echo date('Y-m-d H:i:s');
echo '<br>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">系统信息</div>
                        <div class="layui-card-body ">
                            <table class="layui-table">
                                <tbody>
                                    <tr>
                                        <th>当前版本</th>
                                        <td><span class="x-red"><script type="text/javascript">document.writeln(version);</script></span></td></tr>
                                   									
                                    <tr>								
                                        <th>安装目录</th>
                                        <td>';
echo $_SERVER['DOCUMENT_ROOT'];
echo '</td></tr>
                                    <tr>
                                        <th>操作系统</th>
                                        <td>';
echo PHP_OS;
echo '</td></tr>
                                    <tr>
                                        <th>运行环境</th>
                                        <td>';
echo $_SERVER['SERVER_SOFTWARE'];
echo '</td></tr>
                                    <tr>
                                        <th>PHP版本</th>
                                        <td>';
echo PHP_VERSION;
echo '</td></tr>
                                    <tr>
                                        <th>CURL支持</th>
                                        <td>';
$curl = @curl_version();
echo $curl['version'] ? $curl['version'] : $error;
echo '</td></tr>										
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">团队</div>
                        <div class="layui-card-body ">
                            <table class="layui-table">
                                <tbody>
                                    <tr>
                                        <th>官网</th>
                                        <td>www.vrecf.com</td>
                                    </tr>
                                    
                                    <tr>
                                        <th>免责声明</th>
                                        <td>本程序仅供技术研究使用，请勿用于非法用途；在任何情况下，对于因使用本程序而导致的任何损害赔偿，作者均无须承担法律责任。</td></tr>										
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <style id="welcome_style"></style>
            </div>
        </div>
        </div>		
    </body>
</html>';