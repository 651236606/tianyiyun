<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
include_once dirname(__FILE__) . '/../save/config.php';
$action = filter_input(INPUT_GET, 'action');
session_start();
switch ($action) {
    case 'validate':
        $_vc = new ValidateCode();
        $_SESSION['authnum_session'] = $_vc->getCode();
        break;
    case 'logout':
        if (!empty($_SESSION['hashstr'])) {
            unset($_SESSION['hashstr']);
            unset($_SESSION['username']);
        }
        ShowMsg('注销登录成功！', 'login.html');
        exit;
        break;
    case 'email':
        $arr = array('host' => $_POST['host'], 'port' => $_POST['port'], 'user' => $_POST['user'], 'pass' => $_POST['pass'], 'email' => $_POST['email']);
        $txt = '当你收到这封邮件，说明邮件配置成功了！<br/>本测试邮件由『天翼网盘管理程序』发出，<br/>源码来自『萌芽模板网』www.vrecf.com，感谢您的使用！';
        if (sendEmail($arr, $txt)) {
            echo json_encode(array('code' => 200, 'msg' => '测试发件成功，请登陆邮箱查看邮件！'));
        } else {
            echo json_encode(array('code' => 201, 'msg' => '测试发件失败，请检查邮件配置！'));
        }
        exit;
        break;
    case 'del_cache':
        if (deldir('../cache/')) {
            exit(json_encode(array('code' => 200, 'msg' => '清理成功，请刷新页面重新加载！'), !0));
        } else {
            exit(json_encode(array('code' => 203, 'msg' => '清理失败，权限不足！'), !0));
        }
        exit;
        break;
    case 'login':
        if (!filter_has_var(INPUT_POST, 'user_name') || !filter_has_var(INPUT_POST, 'user_pass')) {
            exit(json_encode(array('code' => 400, 'msg' => '用户名或者密码没填写完整！')));
        }
        if (strtolower(filter_input(INPUT_POST, 'validate')) !== strtolower($_SESSION['authnum_session'])) {
            exit(json_encode(array('code' => 403, 'msg' => '验证码错误！')));
        }
        $username = htmlspecialchars(filter_input(INPUT_POST, 'user_name'));
        $password = MD5('www.vrecf.com' . filter_input(INPUT_POST, 'user_pass'));
        if ($username == $user_name && $password == $user_pass) {
            $hashstr = md5($username . $password);
            $_SESSION['hashstr'] = $hashstr;
            $_SESSION['username'] = $username;
            exit(json_encode(array('code' => 200, 'msg' => '登陆成功,跳转中...', 'url' => './index.php')));
        } else {
            exit(json_encode(array('code' => 401, 'msg' => '用户或者密码错误！')));
        }
        break;
    case 'maccmsv10':
        if (!$_POST) {
            exit(json_encode(array('code' => 404, 'msg' => '参数错误'), !0));
        }
        $db = new M($hostname, $username, $password, $database);
        $apiurl = $mac['v10url'] . '/api.php/receive/vod';
        $name = $_POST['name'];
        $a1 = array('pass' => $mac['v10pass'], 'vod_play_from' => $mac['play_from'], 'vod_remarks' => '正片', 'type_id' => $_POST['type_id'], 'vod_name' => $name);
        $a2 = SubmitData($_POST['id'], $_POST['tid'], $_POST['page'], $action);
        if (!$a2) {
            exit(json_encode(array('code' => 404, 'msg' => '发布失败，《' . $name . '》没有找到图片文件或者视频文件！'), !0));
        }
        $data_arr = array_merge($a1, $a2);
        $html = curl_post($apiurl, $data_arr);
        $tip = json_decode($html, !0);
        $msg = '《' . $name . '》' . $tip['msg'];
        if ($tip['code'] == 1 || $tip['code'] == 1001) {
            echo json_encode(array('code' => 1, 'msg' => $msg), !0);
        } else {
            echo $html;
        }
        sleep(1);
        exit;
        break;
    case 'maccmsv8':
        if (!$_POST) {
            exit(json_encode(array('code' => 404, 'msg' => '参数错误'), !0));
        }
        $db = new M($hostname, $username, $password, $database);
        $apiurl = $mac['v8url'] . '/admin_interface.php?ac=vod';
        $name = $_POST['name'];
        $a1 = array('pass' => $mac['v8pass'], 'd_playfrom' => $mac['play_from'], 'd_remarks' => '正片', 'd_type' => $_POST['type_id'], 'd_name' => $name);
        $a2 = SubmitData($_POST['id'], $_POST['tid'], $_POST['page'], $action);
        if (!$a2) {
            exit(json_encode(array('code' => 404, 'msg' => '发布失败，《' . $name . '》没有找到图片文件或者视频文件！'), !0));
        }
        $data_arr = array_merge($a1, $a2);
        $html = curl_post($apiurl, $data_arr);
        if (strpos($html, '新增') !== !1) {
            echo json_encode(array('code' => 1, 'msg' => '《' . $name . '》新增数据成功！'), !0);
        } else {
            if (strpos($html, '无需更新') !== !1) {
                echo json_encode(array('code' => 1, 'msg' => '《' . $name . '》无需更新播放地址！'), !0);
            } else {
                if (strpos($html, '更新播放地址') !== !1) {
                    echo json_encode(array('code' => 1, 'msg' => '《' . $name . '》更新播放地址成功！'), !0);
                } else {
                    echo json_encode(array('code' => 404, 'msg' => $html), !0);
                }
            }
        }
        sleep(1);
        exit;
        break;
    default:
        exit('参数错误');
}