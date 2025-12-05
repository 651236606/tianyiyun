<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
$pid = $_GET['v'];
if (!is_numeric($pid)) {
    exit('参数错误');
}
include '../save/config.php';
if ($dl['state'] > 0) {
    $ref = @$_SERVER['HTTP_REFERER'];
    $refurl = explode('/', $ref);
    $domain = $refurl[2];
    $site_url = explode('/', $site['url']);
    $site_url = $site_url[2];
    if ($ref == '' || stristr($dl['domain'] . $site_url, $domain) === !1) {
        header('HTTP/1.1 403 Forbidden');
        exit('<font>已开启防盗链，域名未授权！');
    }
}
include 'file.php';
$db->close();
if (preg_match('/^(mp4)$/i', $type)) {
    if ($player['state'] == 0) {
        header('location:' . $url);
        exit;
    }
} else {
    header('location:' . $url);
    exit;
}
echo '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="referrer" content="never">
<title>';
echo $file_name;
?> - <?php 
echo $site['title'];
echo '</title>
<link rel="stylesheet" href="';
echo $site['path'];
echo 'css/DPlayer.min.css">
<script src="';
echo $site['path'];
echo 'js/hls.min.js"></script>
<script src="';
echo $site['path'];
echo 'js/DPlayer.min.js"></script>
<style>body, html, .dplayer {padding: 0;margin: 0;width: 100%;height: 100%;background-color:#000;}a {text-decoration: none;}.dplayer-menu{display:none!important} </style>
</head>
<body>
<div id="player" class="dplayer"></div>
<script type="text/javascript">
  var url = \'';
echo $url;
echo '\';
  var isiPad = navigator.userAgent.match(/iPad|iPhone|Android|Linux|iPod/i) != null;
  if(isiPad){
	document.getElementById(\'player\').innerHTML = \'<video src="\'+url+\'" width="100%" height="100%" poster="';
echo $path;
echo 'images/loading.gif" preload="meta" controls="controls" webkit-playsinline="true" style="width: 100%; height: 100%; background-color: rgb(0, 0, 0);"></video>\';
      }else {
		var pic = "";
		var dplayer = new DPlayer({
			element: document.getElementById("player"),
			autoplay: ';
echo $player['autoplay'] ? 'true' : 'false';
echo ',
			video: {
				url: url,
                pic: pic
			}
		});
       }
</script>
<!--统计代码--><div style="display:none">';
echo $site['tj'];
?></div>
<?php 
echo $site['foot'];
?>
</body>
</html>