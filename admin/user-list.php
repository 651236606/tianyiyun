<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-type: text/html; charset=utf-8');
include 'config.php';
error_reporting(0);
$db = new M($hostname, $username, $password, $database);
$num_page = 15;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $num_page;
$sql = 'SELECT * FROM ty_user order by id desc LIMIT ' . $start . ',' . $num_page . '';
$rs = $db->query($sql);
echo '<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>天翼云网盘账号列表</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/xadmin.css">
        <script src="../lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="../js/xadmin.js"></script>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script>var config = {"path":"';
echo $site['path'];
?>", "url":"<?php 
echo $site['url'];
?>", "static":"<?php 
echo $site['rewrite'];
echo '"}</script>
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">账号列表</a>
            <a>
              <cite>云盘账号</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
					<blockquote class="layui-elem-quote"><b class="x-red">可无限添加多个账号！</b><br>同一个账号下的资源并发请求量过大，可能导致解析异常！<br>如果网站流量比较大，建议添加多个账号，将文件存放到不同账号中使用<br><p class="x-red">网站禁止使用CDN，使用CDN会造成cookie失效和无法登陆</p></blockquote>
                        <div class="layui-card-header">
                            <button class="layui-btn" onclick="xadmin.open(\'添加账号\',\'./user-add.php\',600,400)"><i class="layui-icon"></i>添加账号</button>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>序号</th>
                                  <th>账号</th>
								  <th>总容量</th>
								  <th>已使用</th>
								  <th>cookie状态</th>
								  <th>账号备注</th>
                                  <th>更新时间</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>                            
							';
while ($row = $db->fetch_array($rs)) {
    $quota = getFilesize($row['quota']);
    if ($quota > 0 && $row['cishu'] == 0) {
        $state = '<font color="blue">cookie有效</font>';
    }
    if ($quota == 0) {
        $state = '<font color="red">未登录</font>';
    }
    if ($row['cishu'] > 3) {
        $state = '<font color="red">cookie失效</font>';
    }
    echo '<tr><td>' . $row['id'] . "</td>\n\t\t\t\t\t\t\t\t<td><a onclick=\"parent.xadmin.add_tab('" . $row['uid'] . "','pan.php?id=" . $row['id'] . '\')" class="x-admin-sm layui-btn" href="javascript:;">' . $row['uid'] . '</a></td>
								<td>' . $quota . '</td>
								<td>' . getFilesize($row['size']) . '</td>
								<td>' . $state . '</td>
								<td>' . $row['beizhu'] . '</td>
								<td>' . date('Y-m-d H:i:s', $row['add_time']) . "</td>\n\t\t\t\t\t\t\t\t<td class='td-manage'>\n\t\t\t\t\t\t\t\t<a title='编辑' class=\"layui-btn layui-btn-sm\"  onclick=\"xadmin.open('编辑','user-edit.php?id=" . $row['id'] . "',600,400)\" href='javascript:;'><i class='layui-icon'>&#xe642;</i>修改 / 重登</a>\n\t\t\t\t\t\t\t\t<a title='删除' class=\"layui-btn layui-btn-sm layui-btn-danger\" onclick=\"member_del(this,'" . $row['id'] . "')\" href='javascript:;'><i class='layui-icon'>&#xe640;</i>删除</a>\n\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t";
}
echo '                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
';
$sql2 = 'SELECT * FROM ty_user';
$total = $db->query($sql2);
$total = $db->num_rows($total);
$total_pages = ceil($total / $num_page);
if ($total_pages > 1) {
    echo '<a class="prev" href="?page=1">&lt;&lt;</a>';
}
for ($i = 1; $i <= $total_pages; $i++) {
    if ($page == $i) {
        echo '<span class="current">' . $i . '</span>';
    } else {
        echo "<a class='num' href='?page=" . $i . "'>" . $i . '</a>';
    }
}
if ($total_pages > 1) {
    echo '<a class="next" href="?page=' . $total_pages . '">&gt;&gt;</a>';
}
$db->close();
echo "\t\t\t\t\t\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div> \n    </body>\n    <script>\n      layui.use(['layer','form'], function(){\n        var layer = layui.layer;\n        var form = layui.form;\n      });\n      function member_del(obj,id){\n          layer.confirm('确认要删除吗？',function(index){\n            \$.ajax({\n                url: \"user-save.php\",\n                data: {type:'del',id:id},\n                type: \"post\", \n\t\t\t\tdataType: 'json',\n                success: function (data) {\n\t\t\t\t\tif(data.code == 0){\n\t\t\t\t\t\t\$(obj).parents(\"tr\").remove();\n\t\t\t\t\t\tlayer.msg('已删除!',{icon:1,time:1000});\t\t\t\t\t\t\t\n\t\t\t\t\t}else{\n                        layer.alert(data.msg, {icon: 5});\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t}\t\t\t\t\t\t\t\n                },\n                error: function () {\n                    layer.alert(\"执行异常!\", {icon: 5});\n                }\n            });\t\t\t\t  \n            return false;\n          });\n      }  \n    </script>\n</html>";