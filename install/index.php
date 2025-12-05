<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-type: text/html; charset=utf-8');
error_reporting(0);
if ('PHP_VERSION' < '5.4' || constant('PHP_VERSION') > '7.2') {
    exit('您当前的php版本不符合安装要求，请选用支持PHP5.4以上，php7.1以下的环境');
}
if (!function_exists('mysqli_connect')) {
    exit('mysqli没有启用,请找到php.ini 去掉mysqli前面的注释并重启web服务。<br>启用方法：删除extension=php_mysqli.dll前面的 ;');
}
if (file_exists('install.lock')) {
    exit('您已安装，若需要重新安装，请删除 install/install.lock 文件');
}
if (!is_writable('../save/config.php')) {
    exit('您没有写入权限 请将save/config.php文件改为可写入');
}
function geturl($OO0O, $OOO0 = 10)
{
    $O0000 = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36';
    $O000O = curl_init();
    curl_setopt($O000O, CURLOPT_URL, $OO0O);
    curl_setopt($O000O, CURLOPT_USERAGENT, $O0000);
    curl_setopt($O000O, CURLOPT_REFERER, $OO0O);
    curl_setopt($O000O, CURLOPT_AUTOREFERER, 1);
    curl_setopt($O000O, CURLOPT_TIMEOUT, $OOO0);
    curl_setopt($O000O, CURLOPT_HEADER, 0);
    curl_setopt($O000O, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($O000O, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($O000O, CURLOPT_SSL_VERIFYHOST, '0');
    curl_setopt($O000O, CURLOPT_SSL_VERIFYPEER, '0');
    curl_setopt($O000O, CURLOPT_ENCODING, '');
    $O00O0 = curl_exec($O000O);
    curl_close($O000O);
    return $O00O0;
}
echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>天翼网盘解析管理程序安装</title>
        <link rel="stylesheet" href="../lib/layui/css/layui.css">
        <script type="text/javascript" src="../lib/layui/layui.js"></script>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
        <style>body{text-align:center;}.header{position:fixed;left:0;top:0;width:80%;height:60px;line-height:60px;background:#000;padding:0 10%;z-index:10000;}.header h1{color:#fff;font-size:20px;font-weight:600;text-align:center;}.install-box{margin:100px auto 0;background:#fff;border-radius:10px;padding:20px;overflow:hidden;box-shadow:5px 5px 15px #888888;display:inline-block;width:680px;min-height:500px;}.protocol{text-align:left;height:400px;overflow-y:auto;padding:10px;color:#333;}.protocol h2{text-align:center;font-size:16px;color:#000;}.step-btns{padding:20px 0 10px 0;}.copyright{padding:25px 0;}.copyright,.copyright a{color:#ccc;}.layui-table td, .layui-table th{text-align:left;}</style>
    </head>
<body>
<div class="header">
    <h1>感谢您选择天翼云盘解析管理系统建站</h1>
</div>


';
if (@$_GET['step'] == 1) {
    echo '<style type="text/css">
.layui-table td, .layui-table th{text-align:left;}
.layui-table tbody tr.no{background-color:#f00;color:#fff;}
</style>
<div class="install-box">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>网站基本信息配置</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">网站名称</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="site_title" lay-verify="required" value="">
            </div>
            <div class="layui-form-mid layui-word-aux">一般不超过8个汉字</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">网站域名</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" id="url" name="site_url" lay-verify="url">
            </div>
            <div class="layui-form-mid layui-word-aux">需要带 http:// 结尾不加 "/" 如：http://www.baidu.com</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">安装路径</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" id="path" name="site_path">
            </div>
            <div class="layui-form-mid layui-word-aux">根目录就是“/”，二级目录就是“/二级目录/”；结尾必须加  “/”</div>
        </div>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>数据库配置</legend>
    </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">服务器地址</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="hostname" lay-verify="required" value="127.0.0.1">
            </div>
            <div class="layui-form-mid layui-word-aux">数据库服务器地址，一般为127.0.0.1</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库端口</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="hostport" lay-verify="required" value="3306">
            </div>
            <div class="layui-form-mid layui-word-aux">系统数据库端口，一般为3306</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库名称</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="database" lay-verify="required">
            </div>
            <div class="layui-form-mid layui-word-aux">系统数据库名,必须包含字母</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库账号</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="username" lay-verify="required">
            </div>
            <div class="layui-form-mid layui-word-aux">连接数据库的用户名</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库密码</label>
            <div class="layui-input-inline w200">
                <input type="password" class="layui-input" name="password" lay-verify="required">
            </div>
            <div class="layui-form-mid layui-word-aux">连接数据库的密码</div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>管理账号设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">管理员账号</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="user_name" lay-verify="required">
            </div>
            <div class="layui-form-mid layui-word-aux">管理员账号最少4位</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">管理员密码</label>
            <div class="layui-input-inline w200">
                <input type="password" class="layui-input" name="user_pass" lay-verify="required">
            </div>
            <div class="layui-form-mid layui-word-aux">保证密码最少6位</div>
        </div>
        <div class="step-btns">
            <button type="submit" class="layui-btn layui-btn-big layui-btn-normal fr" lay-submit="add" lay-filter="formSubmit" >立即执行安装</button>
        </div>
    </form>
</div>	
';
} else {
    echo '<div class="install-box">
    <fieldset class="layui-elem-field site-demo-button">
        <legend>程序用户协议 适用于所有用户</legend>
        <div class="protocol">
            <p>
                请您在使用(程序)前仔细阅读如下条款。包括免除或者限制作者责任的免责条款及对用户的权利限制。您的安装使用行为将视为对本《用户许可协议》的接受，并同意接受本《用户许可协议》各项条款的约束。 <br /><br />
                一、安装和使用： <br />
                (程序)无限制提供给您使用，您可安装无限制数量副本。 您必须保证在不进行非法活动，不违反国家相关政策法规的前提下使用本程序。 <br /><br />
                二、免责声明：  <br />
                本程序并无附带任何形式的明示的或暗示的保证，包括任何关于本程序的适用性, 无侵犯知识产权或适合作某一特定用途的保证。  <br />
                在任何情况下，对于因使用本程序或无法使用本程序而导致的任何损害赔偿，作者均无须承担法律责任。作者不保证本程序所包含的资料,文字、图形、链接或其它事项的准确性或完整性。作者可随时更改本程序，无须另作通知。  <br />
                所有由用户自己制作、下载、使用的第三方信息数据和插件所引起的一切版权问题或纠纷，本程序概不承担任何责任。<br /><br />
                三、协议规定的约束和限制：  <br />
                禁止去除(程序)源码里的版权信息！</br>
                禁止在(程序)整体或任何部分基础上发展任何衍生版本、修改版本或第三方版本用于重新分发。</br></br>
                <strong>版权所有 (c) 2019-2020，本程序，保留所有权利</strong>。
            </p>
        </div>
    </fieldset>
    <div class="step-btns">
        <a href="?step=1" class="layui-btn layui-btn-big layui-btn-normal">同意协议并安装程序</a>
    </div>
</div>
';
}
echo '

<div class="copyright">
    (c) 2019-2020 <a href="http://www.vrecf.com/?ty189" target="_blank">VRECF.COM</a> All Rights Reserved.
</div>
</body>
</html>
<script type="text/javascript">
	var ishttps = \'https:\' == document.location.protocol ? \'https://\' : \'http://\';
	var pathName = window.document.location.pathname.split("/in");
	$("#url").val(ishttps + window.location.host);
	$("#path").val(pathName[0]?pathName[0]+"/":\'/\');
	layui.use([\'form\', \'layer\'],function() {
        $ = layui.jquery;
        var form = layui.form,
        layer = layui.layer;
        form.on(\'submit(formSubmit)\',function(data) {
            layer.msg(\'安装中，请稍后...\', {icon: 16, time:false});			  
                $.ajax({
                    url: "install.php?t=vrecf", 
                    data: data.field,
                    type: "post", 
					dataType: \'json\',
                    success: function (data) {
		            	if(data[\'code\']==200){
		            	    layer.msg(data[\'msg\'],{icon: 6},function(){
								window.location.href = "../admin/login.html";
							});					
						}else{
							layer.alert(data[\'msg\'], {icon: 5});
		            	}                      
                    },
                    error: function () {
                        layer.alert("安装环境异常!", {icon: 5});
                    }
                });				  
			return false;
        });
	});
</script>';