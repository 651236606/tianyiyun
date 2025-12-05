<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
date_default_timezone_set('PRC');
include 'save/config.php';
$code = $_GET['v'];
$reg = '/^[a-z0-9]*$/i';
if (!preg_match($reg, $code)) {
    exit('请勿提交非法参数');
}
$db = new M($hostname, $username, $password, $database);
$rs = $db->query('SELECT * FROM ty_share WHERE code="' . $code . '"');
while ($row = $db->fetch_array($rs)) {
    $state = $row['state'];
    $name = $row['name'];
    $type = $row['type'];
    $uid = $row['uid'];
    $pid = $row['pid'];
    $mode = $row['mode'];
    $text = $row['text'];
    $end_time = $row['end_time'];
    $down_num = $row['down_num'];
}
if ($state < 1 || $end_time < time()) {
    echo '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
</head>
<body>
<style>
body{margin: 20px;}
.off{text-align: center;font-size: 16px;color: #b3b3b3;}
.off0{background: #eee;width: 70px;height: 60px;margin: 10% auto 30px auto;border-radius: 3px;padding-top: 10px;}
.off1{border-top: 30px solid #b1b1b1;width: 10px;height: 10px;border-bottom: 10px solid #b1b1b1;margin: auto;}
</style>
<div class="off"><div class="off0"><div class="off1"></div></div>来晚啦...文件取消分享了</div>
<div style="display:none">' . $site['tj'] . '</div>
' . $site['foot'] . '
</body>
</html>';
    exit;
}
$db->getRow('UPDATE ty_share SET pv_num=pv_num+1 WHERE code="' . $code . '"');
$db->close();
echo '<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <title>';
echo $name;
?> - <?php 
echo $site['title'];
echo '</title>
    <style>body{font-family:Tahoma,Arial,Roboto,”Droid Sans”,”Helvetica Neue”,”Droid Sans Fallback”,”Heiti SC”,sans-self;font-size:16px;color: #333;margin: 0;padding: 0;background-color:transparent; border-color:transparent;-webkit-appearance: none;-webkit-tap-highlight-color:rgba(0,0,0,0);-webkit-tap-highlight-color:rgba(0,0,0,0.0);} input:focus, textarea:focus {outline: none;} #infomores{clear: both;padding: 38px; font-size: 14px;}.load2 .loader, .load2 .loader:before, .load2 .loader:after {border-radius: 50%;} .load2 .loader:before, .load2 .loader:after {position: absolute;content: \'\';} .load2 .loader:before {width: 16px;height: 32px;background: #fff;border-radius: 32px 0 0 32px;top: -1px;left: -1px;transform-origin: 16px 16px;animation: load2 2s infinite ease 1.5s;} .load2 .loader {font-size: 11px;text-indent: -99999em;margin: auto;position: relative;width: 30px;height: 30px;box-shadow: inset 0 0 0 4px #09f;} .load2 .loader:after {width: 16px;height: 32px;background: #fff;border-radius: 0 31px 31px 0;top: -1px;left: 15px;transform-origin: 0px 16px;animation: load2 2s infinite ease;} @keyframes load2 { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } } .load2{position: fixed;width: 100%;background: #fff;height: 100%;z-index: 999;padding-top: 10%;display: none;} .loader2{text-align:center;padding-top: 30px;} .user-top{ height: 30px; border-bottom: 1px solid #eee; padding: 10px;} .user-ico{float: left;} .user-ico-img{width: 30px; height: 30px; border-radius: 50%; position: absolute;} .user-ico-div{ background: #bbb; width: 30px; height: 25px; border-radius: 50%; padding-top: 5px;} .user-ico-div-1{ background: #777; width: 10px; height: 10px; border-radius: 50%; margin: auto;} .user-ico-div-2{background: #777; width: 20px; height: 10px; border-radius: 50%; margin: auto; margin-top: 1px;} .user-name{ float: left;font-size: 14px; color: #888; line-height: 30px; margin-left: 10px;} .user-name-txt{ color: #333; margin-left: 10px; display: none; } .user-radio{background: #f5f5f5; padding: 8px 10px; margin: 20px;margin-bottom: 25px; border-radius: 3px;} .user-radio-0{ background: #f5f5f5; width: 10px; height: 10px; position: absolute; margin-top: -12px; -webkit-transform: rotate(45deg);} .user-radio-1{font-size: 12px;padding: 3px;background: #de5823;color: #fff;border-radius: 3px 0 0 3px;} .user-radio-2{background:#666;margin-right:5px;border-radius: 0 3px 3px 0;} .user-title{display:none} .n_foot{display:none} .n_login{ padding: 6px 0; font-size: 12px; -webkit-transition: 0.2s; float: right; color: #888;text-decoration: none;} .file{ margin-top: -1px;} .mbx{padding: 0 20px;} .mbx:hover{ background: #f1f1f1;} .mbxfolder{border-bottom: 1px solid #f7f7f7;} #folder{ border-top: 1px solid #f7f7f7;} .mlink{ display: inline-block; color: #333; padding: 20px 0; width: 100%; height: 35px;} .mlink:visited{color: #77848a;} .fileimg{float: left;background: #eee; width: 35px; height: 35px; margin-right: 10px; border-radius: 7px;} .fileimg img{ margin: auto;width: 100%; border-radius: 7px;} .filename{float: left;line-height: 1em; overflow: hidden; max-width: 250px; text-overflow: ellipsis; -webkit-transition: 0.1s;} .filesize{font-size: 12px; color: #999; padding-top: 3px;} .filedown{ color: #999; background: rgba(255, 255, 255, .7); position: absolute; width: 32px; height: 32px; border: 1px solid #5bccff; border-radius: 50%; right: 20px;} .filedown-1{height: 12px; margin-top: 8px; border-left: 1px solid #5bccff; margin-left: 50%;} .filedown-2{ border-left: 1px solid #5bccff; border-bottom: 1px solid #5bccff; height: 8px; width: 8px; transform: rotate(-45deg); margin-left: 12px; margin-top: -9px;} .folderdown{ background: #eee; float: right; width: 34px; height: 34px; border-radius: 50%; transform: rotate(-90deg);} .folderdown-2{ border-left: 1px solid #333; border-bottom: 1px solid #333; height: 8px; width: 8px; transform: rotate(-45deg); margin-left: 12px; margin-top: 10px;} .user-right{ position: fixed; top: 80px; right: 50%; margin-right: -640px; width: 180px; } .user-code{ border: 1px solid #e7e7e7; height: 180px; padding: 20px; text-align:center; border-radius: 6px; } .user-code-r{ padding-top: 20px; font-size: 14px; } #sms{ display: none; z-index: 99; text-align: center; position: fixed; top: 40px; left: 0px; right: 0px; width: 200px; height: 30px; margin-left: auto; margin-right: auto; line-height: 1.2em; } #smsspan{ background: rgba(0, 0, 0, .7); color: #fff; font-size: 14px; padding: 5px 8px; border-radius: 3px; } @media (min-width: 768px){ .user-top{ position: fixed; background: rgba(255, 255, 255, .9); z-index: 8; right: 0; left: 0; } .off{width: 300px; margin: 150px auto 30px auto;} .input{width: 300px;} .btnpwd{width: 300px;} .user-name{ color:#ff6740; } .n_login{display:block;background: #ffd1c5; -webkit-transition: 0.2s;text-decoration: none; padding: 8px 12px; font-size: 12px; -webkit-transition: 0.2s; float: right; border-radius: 3px;} .n_login:hover{ opacity: .7;} .n_login font{color: #fff;} .user-name-txt{display:initial} .user-radio-0{background: #fff;} .user-radio{ width: 776px;background: #fff; line-height: 1.7em;margin: 10px auto 50px auto;} .user-title{ display: block; font-size: 32px; font-weight: 700; padding: 100px 0 20px 0; width: 800px; margin: auto;} .file-box{ width: 800px; min-height: 450px;border-top: 3px solid #eee; margin: auto; margin-top: 20px;} .mbx{ } .mbx:hover{ background: #f7f7f7;} #folder{ border-top: 0;} .filename{ max-width: 600px;} .filename:hover{color: #77848a;} .filedown{position: inherit;float: right;} .filedown:hover{opacity: .7;} .n_foot{font-size: 12px;color: #999;padding: 20px;text-align: center;display:block} #smsspan{ padding: 2px 5px; } } @media (max-width: 768px){ .passwddiv-user{ font-size: 16px; } .passwddiv-input{ padding: 8px; width: 210px; } .passwdinput{ line-height: 34px; height: 34px; } .passwddiv-btn{ width: 34px; height: 34px; } .passwddiv-btn-1{ margin-top: 16px; margin-left: 8px; } .passwddiv-btn-2{ margin-left: 10px; } .folderdown{ position: absolute; right: 20px; } }#info{display:none}.off{text-align:center;font-size:16px}.off0{background:#eee;width:70px;height:60px;margin:6% auto 30px auto;border-radius:3px;padding-top:10px}.off1{border-top:30px solid #aaa;width:10px;height:10px;border-bottom:10px solid #aaa;margin:auto}#pwdload{text-align:center;line-height:50px}.input{font-size:22px;width:170px;border:1px solid #CCCCCC;padding:5px;box-shadow:inset 0 1px 2px rgba(0,0,0,0.075);border-radius:3px;outline:0}.input:hover{border:#52A6EF 1px solid}.input:focus{border:#52A6EF 1px solid;box-shadow:inset 0 1px 2px rgba(0,0,0,0.275)}.btnpwd{width:118px;height:34px;font:12px \\9ED1\\4F53;font-weight:700;border-radius:4px;border:1px solid #D5D5D5;background-image:linear-gradient(#FCFCFC,#EEE);background-color:#f7f7f7;outline:0}.btnpwd:hover{background:#eee;background-image:linear-gradient(#EEE,#DDD)}.btnpwd:focus{background-color:#CCC;border-color:#ccc;background-image:none;border-radius:0;color:#888}#pwderr{color:#ff7171}@media (max-width:768px){#pwdload{margin:28px 8px}.off0{display:none}.input{box-shadow:none;border-radius:0;width:100%;border:0;border-bottom:1px solid #eee;padding:0}.input:hover{border:0;border-bottom:1px solid #eee}.input:focus{border:0;border-bottom:1px solid #52A6EF;box-shadow:none}.btnpwd{width:100%}</style>	
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/qrcode.js"></script>
	<script type="text/javascript" src="../lib/layui/layui.js"></script>
  </head>
  <body>

    <div id="pwdload">
        <div class="off"><div class="off0"><div class="off1"></div></div>文件受密码保护，请输入密码继续下载</div>
            <input type="text" name="pwd" class="input" id="pwd" value="" /><br>
            <input id="sub" onclick="file();" type="submit" class="btnpwd" value="确认" />
        <div id="pwderr"></div>
		<div id="pwdtip">';
echo $text;
echo '</div>
    </div>  
    <div id="sms">
      <span id="smsspan"></span>
    </div>
  <div id="down" ';
echo $mode ? 'style="display: none;"' : '';
echo '>
    <div class="user-top">
      <div class="user-ico">
        <div class="user-ico-img" style="background:url(<?$site[\'path\'];?>images/logo.jpg);background-size:100%;background-repeat:no-repeat;background-position:50%;"></div>
        <div class="user-ico-div">
          <div class="user-ico-div-1"></div>
          <div class="user-ico-div-2"></div>
        </div>
      </div>
      <div class="user-name">';
echo $site['title'];
echo '        <span class="user-name-txt">的分享文件</span>
	  </div>
	  <a href="//wpa.qq.com/msgrd?v=3&uin=';
echo $site['qq'];
echo '&site=qq&menu=yes" class="n_login"><font id="rpt">无法下载？点我反馈</font></a>
    </div>
    
    <div class="user-right">
      <div class="user-code">
        <div id="code"></div>
        <div class="user-code-r">手机下载请扫二维码</div></div>
    </div>
    <div class="user-title">';
echo $name;
echo '</div>
    <div class="load2" id="load2">
      <div class="loader"></div>
      <div class="loader2">努力加载中...</div>
	</div>
    <div class="file" id="info">
      <div class="file-box">
        <div id="infos"></div>
      </div>
    </div>
	<div id="weixin-tip" style="display: none;"></div>
    <div class="n_foot">
      <div class="n_copy">如果无法下载，请联系QQ：<a href="//wpa.qq.com/msgrd?v=3&uin=';
echo $site['qq'];
?>&site=qq&menu=yes"><?php 
echo $site['qq'];
echo '</a></div>&copy; 2019
      <a href="';
echo $site['url'] . $site['path'];
?>"><?php 
echo $site['title'];
echo '</a></div>
	</div>  
    <script type="text/javascript">
	  var path = \'';
echo $site['path'];
?>';var mode = '<?php 
echo $mode;
?>';var code = '<?php 
echo $code;
?>';var time = '<?php 
echo time();
?>';var type = '<?php 
echo $type;
?>';var sign = '<?php 
echo md5($code . time() . $site['qq']);
echo '\';var pgs;pgs = 1;
	  layui.use([\'layer\'],function(){
          var layer = layui.layer,
           $ = layui.jquery;
      });
      document.getElementById("load2").style.display = "block";
	  if(mode>0){
		 document.getElementById("down").style.display = "none"; 
	  }else{
		 document.getElementById("pwdload").style.display = "none"; 
		 file();
	  }
      function sms(stx) {
        document.getElementById("sms").style.display = "none";
        $("#smsspan").text(stx);
        document.getElementById("sms").style.display = "block";
        setTimeout(\'document.getElementById("sms").style.display="none";\', 5000);
      }

      function file() { 
        var pwd = document.getElementById(\'pwd\').value;
        $.ajax({
          type: \'POST\',
          url: path+\'api/share-data.php\',
          data: {
            \'pg\': pgs,
            \'code\': code,
            \'time\': time,
            \'sign\': sign,
			\'pwd\': pwd,
          },
          dataType: \'json\',
          success: function(msg) {
            document.getElementById("load2").style.display = "none";
            if (msg.zt == \'1\') {
			  document.getElementById("pwdload").style.display = "none"; 
			  document.getElementById("info").style.display = "block";
			  document.getElementById("down").style.display = "block";
              var data = msg.text;
              $.each(data,function(i, n) {
                var str;
                var file_ico;
                file_ico = \'<div class=fileimg><img src=\' + path + \'images/\' + n.icon + \'.png align=absmiddle border=0></div>\';
                str = \'<div id=ready><div class=mbx><a href="javascript:void(0);" onclick="down(\' + n.uid + \',\' + n.pid +\')" class="mlink minPx-top">\' + file_ico + \'<div class=filename>\' + n.name + \'<div class=filesize>\' + n.size + \'</div></div><div class=filedown><div class=filedown-1></div><div class=filedown-2></div></div></a></div></div>\';
                $(str).appendTo("#infos");
              });
              pgs++;
            } else if (msg.zt == \'2\') {
                sms(msg.info);
				document.getElementById("pwdload").style.display = "none";
				document.getElementById("info").style.display = "block";
            } else if (msg.zt == \'3\'){
				$("#pwderr").text(msg.info);
				$(\'#sub\').val("确认");				
			}else {
                sms(msg.info);
            }
          },
          error: function() {
            $("#infos").text("获取失败，请重试");
          }
        });
      }
	  function down(uid,pid) { 
        if (is_weixin()) {
            var cssText = "#weixin-tip{position: fixed; left:0; top:0; background: rgba(0,0,0,0.8); filter:alpha(opacity=80); width: 100%; height:100%; z-index: 9999;} #weixin-tip p{text-align: center; margin-top: 10%; padding:0 5%;}";
            var u = navigator.userAgent;
            var isAndroid = u.indexOf(\'Android\') > -1 || u.indexOf(\'Linux\') > -1;
            var isIOS = !!u.match(/\\(i[^;]+;( U;)? CPU.+Mac OS X/);
            var imgurl = \'https://ae01.alicdn.com/kf/HTB12mz9eRCw3KVjSZR0762cUpXaS.png\';
            if (isAndroid) {
                var imgurl = \'https://ae01.alicdn.com/kf/HTB1yXMXeGSs3KVjSZPi763siVXas.png\';
            }
            if (isIOS) {
                var imgurl = \'https://ae01.alicdn.com/kf/HTB1OG_4eRWD3KVjSZFs763qkpXab.png\';
            }
            $(\'#weixin-tip\').show();
            $("#weixin-tip").html(\'<p><img src="\' + imgurl + \'" alt="浏览器打开" style="max-width: 100%; height: auto;"><img src="https://ae01.alicdn.com/kf/HTB11fj9eRKw3KVjSZTE763uRpXal.png"></p>\');
            loadStyleText(cssText);
            return false;
        }	  
	    var index = layer.msg(\'请求中，请稍后...\',{icon:16, time:false});
        $.ajax({
          type: \'post\',
          url: path+\'api/down.php\',
          data: {
            \'uid\': uid,
            \'pid\': pid,
            \'time\': time,
			\'code\': code,
            \'sign\': sign
          },
          dataType: \'json\',
          success: function(data) {
            if (data.code == \'200\') {
              layer.close(index); 				
              window.location.href = data.downurl;
            } else if (data.code == \'0\') { 
              layer.msg(data.msg,{icon:5});
            } else { 
              layer.msg(\'获取下载地址失败，请刷新重试\',{icon:5});
            }
          },
          error: function() {
            layer.alert(\'服务器处理失败，请刷新重试！\');
          }
        });		  
	  }
      var urls = window.location.href;
      var qrcode = new QRCode(\'code\', {
        text: urls,
        width: 138,
        height: 138,
        colorDark: \'#3f3f3f\',
        colorLight: \'#ffffff\',
        correctLevel: QRCode.CorrectLevel.H
      });
      $("#weixin-tip").click(function() {
        document.getElementById("weixin-tip").style.display = "none";
      });	  
      function is_weixin() {
          var ua = navigator.userAgent.toLowerCase();
          if (ua.match(/MicroMessenger/i) == "micromessenger") {
              return true;
          } else {
              return false;
          }
      }
      function loadStyleText(cssText) {
          var style = document.createElement(\'style\');
          style.rel = \'stylesheet\';
          style.type = \'text/css\';
          try {
              style.appendChild(document.createTextNode(cssText));
          } catch (e) {
              style.styleSheet.cssText = cssText;
          }
          var head = document.getElementsByTagName("head")[0];
          head.appendChild(style);
      }	 
	</script>
    <div style="display:none">';
echo $site['tj'];
?></div>
	<?php 
echo $site['foot'];
?>
  </body>
</html>