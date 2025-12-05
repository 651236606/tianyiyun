<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
$pid = $_GET['pid'];
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
include './file.php';
$db->close();
echo '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="referrer" content="never">
<title>音乐播放器</title>
<link href="https://fonts.googleapis.com/css?family=Barlow+Condensed:300,400,700" rel="stylesheet">
<link href="style/css/font-awesome.min.css" rel="stylesheet">
<link href="style/css/index.processed.css" rel="stylesheet">
<script src="style/js/react.min.js"></script>
<script src="style/js/react-dom.min.js"></script>
</head>
<body>
<div id="root"></div>
<script>
var title = \'';
echo $row['name'];
?>';
var sub = '';
var mp3url = '<?php 
echo $url;
echo '\';
</script>
<script src="style/js/init.processed.js"></script>
</body>
</html>';