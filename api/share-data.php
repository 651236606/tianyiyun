<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
date_default_timezone_set('PRC');
include '../save/config.php';
$code = $_POST['code'];
$time = $_POST['time'];
$sign = $_POST['sign'];
$pwd = trim($_POST['pwd']);
$reg = '/^[a-z0-9]*$/i';
if (empty($code) || empty($time) || empty($sign) || $sign != md5($code . $time . $site['qq']) || !preg_match($reg, $sign) || !preg_match($reg, $code) || !is_numeric($time)) {
    $info = json_encode(array('zt' => '2', 'info' => '校验失败，参数不合法，无法找到文件', 'text' => ''), !0);
    exit($info);
}
$db = new M($hostname, $username, $password, $database);
$row = $db->getRow('SELECT * FROM ty_share WHERE code="' . $code . '"');
$state = $row['state'];
$name = $row['name'];
$type = $row['type'];
$uid = $row['uid'];
$pid = $row['pid'];
$pass = $row['pass'];
$mode = $row['mode'];
$size = $row['size'];
$text = $row['text'];
$end_time = $row['end_time'];
$down_num = $row['down_num'];
$share_time = date('Y-m-d H:i:s', $row['add_time']);
if ($state < 1 || $end_time < time()) {
    $db->close();
    $info = json_encode(array('zt' => '2', 'info' => '文件已取消分享', 'text' => ''), !0);
    exit($info);
}
if ($mode > 0 && $pass != $pwd) {
    $db->close();
    $info = json_encode(array('zt' => '3', 'info' => '密码不正确', 'text' => ''), !0);
    exit($info);
}
$rs = $db->getRow('SELECT * FROM ty_user WHERE id=' . $uid);
$cookie = $rs['cookie'];
if ($type == '文件夹') {
    $list = listfiles($cookie, $pid);
    $pagenum = $list['pageNum'];
    foreach ($list['data'] as $dwon) {
        if ($dwon['fileSize'] != '') {
            $sql = 'INSERT INTO ty_cache (uid, pid, tid, name, type, page) VALUES ("' . $uid . '","' . $dwon['fileId'] . '","' . $pid . '","' . $dwon['fileName'] . '","' . $dwon['fileType'] . '","' . $pagenum . '") ON DUPLICATE KEY UPDATE tid=VALUES(tid),name=VALUES(name),page=VALUES(page)';
            $db->query($sql);
            $down_data[] = array('icon' => $dwon['fileType'], 'name' => $dwon['fileName'], 'size' => getFilesize($dwon['fileSize']), 'time' => $share_time, 'uid' => $uid, 'pid' => $dwon['fileId']);
        }
    }
} else {
    $obj = $db->getRow('SELECT * FROM ty_cache WHERE pid=' . $pid . '');
    $tid = $obj['tid'];
    $page = $obj['page'];
    $down_data[] = array('icon' => file_exists('../images/' . $obj['type'] . '.png') ? $obj['type'] : 'unknown', 'name' => $obj['name'], 'size' => $size, 'time' => $share_time, 'uid' => $uid, 'pid' => $obj['pid']);
}
if (!$down_data) {
    $data = array('zt' => '2', 'info' => '没有文件', 'text' => '');
    if ($email['mailon'] > 0) {
        if ($rs['cishu'] > 3 && $rs['tz_time'] == '' || $rs['cishu'] > 3 && $rs['tz_time'] + 3600 < time()) {
            sendEmail($email, '网盘cookie失效了，请及时重新登陆更新cookie');
            $db->query('UPDATE ty_user SET cishu=cishu+1,tz_time=' . time() . ' WHERE id="' . $uid . '"');
        } else {
            $db->query('UPDATE ty_user SET cishu=cishu+1 WHERE id="' . $uid . '"');
        }
    }
} else {
    $data = array('zt' => '1', 'info' => 'sucess', 'text' => $down_data);
}
$datainfo = json_encode($data, !0);
echo $datainfo;
$db->close();