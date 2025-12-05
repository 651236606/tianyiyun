<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include 'config.php';
include '../include/db.class.php';
session_start();
if (isset($_SESSION['lock_config'])) {
    $time = (int) $_SESSION['lock_config'] - (int) time();
    if ($time > 0) {
        exit(json_encode(array('code' => 400, 'msg' => '请勿频繁提交，' . $time . '秒后再试！')));
    }
}
$_SESSION['lock_config'] = time() + $from_timeout;
if (!filter_has_var(INPUT_POST, 'type')) {
    exit(json_encode(array('code' => 400, 'msg' => '请勿非法调用！')));
}
$type = filter_input(INPUT_POST, 'type');
switch ($type) {
    case 'admin_edit':
        $user_name = trim(filter_input(INPUT_POST, 'user_name'));
        $user_pass = md5('www.vrecf.com' . trim(filter_input(INPUT_POST, 'user_pass')));
        break;
    case 'set_edit':
        $site = array('title' => trim(filter_input(INPUT_POST, 'site_title')), 'url' => trim(filter_input(INPUT_POST, 'site_url')), 'path' => trim(filter_input(INPUT_POST, 'site_path')), 'qq' => trim(filter_input(INPUT_POST, 'site_qq')), 'rewrite' => trim(filter_input(INPUT_POST, 'rewrite')), 'tj' => trim(filter_input(INPUT_POST, 'site_tj')), 'foot' => trim(filter_input(INPUT_POST, 'site_foot')));
        break;
    case 'player':
        $player = array('state' => trim(filter_input(INPUT_POST, 'state')), 'autoplay' => trim(filter_input(INPUT_POST, 'autoplay')));
        break;
    case 'maccms':
        $mac = array('v8state' => trim(filter_input(INPUT_POST, 'v8state')), 'v8url' => trim(filter_input(INPUT_POST, 'v8url')), 'v8pass' => trim(filter_input(INPUT_POST, 'v8pass')), 'v10state' => trim(filter_input(INPUT_POST, 'v10state')), 'v10url' => trim(filter_input(INPUT_POST, 'v10url')), 'v10pass' => trim(filter_input(INPUT_POST, 'v10pass')), 'play_from' => trim(filter_input(INPUT_POST, 'play_from')));
        break;
    case 'email_edit':
        $email = array('host' => trim(filter_input(INPUT_POST, 'host')), 'port' => trim(filter_input(INPUT_POST, 'port')), 'user' => trim(filter_input(INPUT_POST, 'user')), 'pass' => trim(filter_input(INPUT_POST, 'pass')), 'email' => trim(filter_input(INPUT_POST, 'email')), 'mailon' => trim(filter_input(INPUT_POST, 'mailon')));
        break;
    case 'dl_edit':
        $dl = array('state' => trim(filter_input(INPUT_POST, 'state')), 'domain' => trim(filter_input(INPUT_POST, 'domain')));
        break;
    default:
        exit(json_encode(array('code' => 400, 'msg' => '参数错误！')));
}
if (Main_db::save('../save/config.php')) {
    exit(json_encode(array('code' => 200, 'msg' => '保存成功!')));
} else {
    exit(json_encode(array('code' => 400, 'msg' => '保存失败!请检测配置文件权限')));
}