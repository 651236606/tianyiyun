<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include 'config.php';
error_reporting(0);
$uid = $_GET['uid'];
$pid = $_GET['pid'];
$name = $_GET['name'];
$type = $_GET['type'];
$size = $_GET['size'];
$db = new M($hostname, $username, $password, $database);
$sql = 'SELECT * FROM ty_share WHERE pid=' . $pid . '';
$row = $db->getRow($sql);
$db->close();
echo '<!DOCTYPE html>
<html class="x-admin-sm">
  
  <head>
    <meta charset="UTF-8">
    <title>分享设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/xadmin.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script src="../lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="../js/xadmin.js"></script>
    <script type="text/javascript" src="../js/qrcode.js"></script>
    <script type="text/javascript" src="../js/jquery.clipboard.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--></head>
  
  <body>
    <div class="layui-fluid">
      <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
          <div class="layui-card">
';
if ($row['code']) {
    $long_url = $site['url'] . $site['path'] . 'share.php?v=' . $row['code'];
    if ($site['rewrite'] > 0) {
        $long_url = $site['url'] . $site['path'] . 'share/' . $row['code'];
    }
    $ematxt = $long_url;
    if ($row['mode'] > 0) {
        $long_url = $long_url . '&nbsp;&nbsp;密码：' . $row['pass'];
    }
    echo '
            <div class="layui-card-body">
              <table class="layui-table">
                <tbody>
                  <tr>
                    <th>文件名</th>
                    <td>';
    echo $name;
    echo '</td>
                  </tr>
                  <tr>
                    <th>分享链接</th>
                    <td>
                      <span id="long_url">';
    echo $long_url;
    echo '</span>&nbsp;&nbsp;
                      <span class="layui-btn layui-btn-xs" data-clipboard-target="#long_url">复制</span></td>
                  </tr>
                  <tr>
                    <th>完整分享</th>
                    <td>
                      <span id="share-txt">';
    echo $name;
    ?>&nbsp;&nbsp;<?php 
    echo $long_url;
    echo '</span>&nbsp;&nbsp;
                      <span class="layui-btn layui-btn-xs" data-clipboard-target="#share-txt">复制</span></td>
                  </tr>
                  <tr>
                    <th>分享二维码</th>
                    <td id="qrcode"></td>
                  </tr>
                </tbody>
              </table>
            </div>
      <script>
layui.use([\'layer\'], function() {
    $ = layui.jquery;
    var layer = layui.layer;
    var qrcode = new QRCode(\'qrcode\', {
        text: \'';
    echo $ematxt;
    echo "',\n        width: 256,\n        height: 256,\n        colorDark: '#000000',\n        colorLight: '#ffffff',\n        correctLevel: QRCode.CorrectLevel.H\n    });\n    var clipboard = new ClipboardJS('.layui-btn');\n    clipboard.on('success', function(e) {\n        layer.msg('已复制到剪贴板！');\n    });\n    clipboard.on('error', function(e) {\n        layer.alert('复制失败！请手动选中后复制！');\n    });\n});\n</script>\t\t\t\n";
} else {
    echo '            <div class="layui-card-body">
              <form class="layui-form">
                <div class="layui-form-item">
                  <label class="layui-form-label">分享文件</label>
                  <div class="layui-input-block">
                    <input type="text" name="name" id="name" lay-verify="required" value="';
    echo $name;
    echo '" class="layui-input" disabled=""></div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">分享形式</label>
                  <div class="layui-input-inline" style="width:100px">
                    <select name="mode" lay-filter="mode">
                      <option value="1" selected>有提取码</option>
                      <option value="0">无提取码</option></select>
                  </div>
                  <div class="layui-form-mid layui-word-aux">有提取码则需要输入提取码查看，无提取码则打开链接即可查看</div></div>
                <div class="mode mode_1">
                  <div class="layui-form-item">
                    <label class="layui-form-label">提取码</label>
                    <div class="layui-input-inline" style="width:100px">
                      <input type="text" name="pass" id="mima" lay-verify="mima" value="" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">可自定义提取码，不超过4个字符！</div></div>
                  <div class="layui-form-item">
                    <label for="text" class="layui-form-label">一句话引流</label>
                    <div class="layui-input-block">
                      <textarea placeholder="例如：关注公众号，获取提取码，或者加群获取提取码，自由发挥，可留空！" id="text" name="text" class="layui-textarea"></textarea>
                    </div>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label for="site_name" class="layui-form-label">有效期</label>
                  <div class="layui-input-block">
                    <input type="radio" name="endtime" value="2147483647" title="永久有效" checked="">
                    <input type="radio" name="endtime" value="';
    echo strtotime('+7day');
    echo '" title="7天">
                    <input type="radio" name="endtime" value="';
    echo strtotime('+1day');
    echo '" title="1天"></div>
                </div>
                <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label"></label>
                  <input type="hidden" name="uid" value="';
    echo $uid;
    echo '" />
                  <input type="hidden" name="pid" value="';
    echo $pid;
    echo '" />
				  <input type="hidden" name="size" value="';
    echo $size;
    echo '" />
                  <input type="hidden" name="filetype" value="';
    echo $type;
    echo '" />
                  <button class="layui-btn layui-btn-normal" lay-filter="edit" lay-submit="">创建链接</button>
                  <button class="layui-btn" onclick="xadmin.close();return false;">放弃</button></div>
              </form>
            </div>
         <script type="text/javascript" src="../js/share-add.js"></script>		
';
}
echo '			
          </div>
        </div>
      </div>
  </body>
</html>';