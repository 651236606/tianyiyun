<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include 'config.php';
echo '<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>管理员信息修改</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/xadmin.css">
        <script type="text/javascript" src="../lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/xadmin.js"></script>
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
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>登录名</label>
                        <div class="layui-input-inline">
                            <input type="text" id="user_name" name="user_name" required="" lay-verify="nikename" autocomplete="off" 
							 value="';
echo $user_name;
echo '" class="layui-input">
							</div>
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>至少5个字符</div></div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>新密码</label>
                        <div class="layui-input-inline">
                            <input type="password" id="L_pass" name="user_pass" required="" lay-verify="pass" autocomplete="off"  class="layui-input">
							</div>
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>6到16个字符</div></div>							
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>确认密码</label>
                        <div class="layui-input-inline">
                            <input type="password" id="L_repass" name="repass" required="" lay-verify="repass" class="layui-input">
							</div>
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>请重复输入密码</div></div>
				

                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button  class="layui-btn" lay-filter="edit" lay-submit="" >修改</button>
                        <button  class="layui-btn" onclick="xadmin.close();return false;">放弃</button>
					</div>
                </form>
            </div>
        </div>
        <script>layui.use([\'form\', \'layer\',\'jquery\'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return \'昵称至少得5个字符啊\';
                        }
                    },
                    pass: [/(.+){6,12}$/, \'密码必须6到12位\'],
                    repass: function(value) {
                        if ($(\'#L_pass\').val() != $(\'#L_repass\').val()) {
                            return \'两次密码不一致\';
                        }
                    }
                });
                form.on(\'submit(edit)\',function(data) {
                    console.log(data);
					data.field.type=\'admin_edit\';
                    $.ajax({
                        url: "save.php", 
                        data: data.field,
                        type: "post", 
				    	dataType: \'json\',
                        success: function (data) {
		                	if(data[\'code\']==200){
		                	    layer.alert(data[\'msg\']+"将重新登陆！",function(){
									top.location.href = "./login.html";
				    			});							
				    		}else{
				    			layer.alert(data[\'msg\'], {icon: 5});
		                	}                      
                        },
                        error: function () {
                            layer.alert("文件读取写入异常!", {icon: 5});
                        }
                    });						
                    return false;
                });

            });</script>
    </body>

</html>';