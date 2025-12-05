<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
date_default_timezone_set('PRC');
include '../save/config.php';
$uid = $_POST['uid'];
$pid = $_POST['pid'];
$time = $_POST['time'];
$sign = $_POST['sign'];
$code = $_POST['code'];
$t = time() - $time;
$reg = '/^[a-z0-9]*$/i';
if ($sign != md5($code . $time . $site['qq']) || !is_numeric($pid) || !is_numeric($uid) || !is_numeric($time) || !preg_match($reg, $sign) || !preg_match($reg, $code)) {
    exit(json_encode(array('code' => '0', 'msg' => '校验失败，提交的参数不合法，请刷新重试！'), !0));
}
if ($t > 180) {
    exit(json_encode(array('code' => '0', 'msg' => '下载链接超时了，请刷新后再试！'), !0));
}
include './file.php';
$db->query('UPDATE ty_share SET down_num=down_num+1 WHERE code="' . $code . '"');
$db->close();
if ($url) {
    exit(json_encode(array('code' => '200', 'downurl' => $url), !0));
} else {
    exit(json_encode(array('code' => '0', 'msg' => '获取下载地址失败，请联系管理员反馈！'), !0));
}