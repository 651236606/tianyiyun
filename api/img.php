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
include './file.php';
$db->close();
if (!preg_match('/^(mp4)$/i', $type)) {
    header('location:' . $url);
    exit;
}