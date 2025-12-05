<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-type: text/html; charset=utf-8');
$type = @$_POST['type'];
if (!$type) {
    exit(json_encode(array('code' => 1, 'msg' => '参数错误！' . $type)));
}
include 'config.php';
$db = new M($hostname, $username, $password, $database);
switch ($type) {
    case 'user':
        $uid = @$_POST['uid'];
        $pass = @$_POST['pass'];
        $beizhu = @$_POST['beizhu'];
        if (@$_POST['form'] == 'add') {
            $row = $db->getRow('SELECT * FROM ty_user WHERE uid=' . $uid);
            if ($row) {
                exit(json_encode(array('code' => 2, 'msg' => '账号已存在！')));
            }
            $sql = 'INSERT INTO `ty_user` (`uid`,`pass`,`beizhu`,`add_time`) VALUES (\'' . $uid . '\',\'' . $pass . '\',\'' . $beizhu . '\',\'' . time() . '\')';
        }
        if (@$_POST['form'] == 'edit') {
            $sql = 'UPDATE `ty_user` SET pass="' . $pass . '",beizhu="' . $beizhu . '",add_time="' . time() . '" WHERE uid="' . $uid . '"';
        }
        break;
    case 'del':
        $id = @$_POST['id'];
        $sql = 'DELETE FROM `ty_user` WHERE id="' . $id . '"';
        $sql2 = 'DELETE FROM `ty_share` WHERE uid="' . $id . '"';
        $sql3 = 'DELETE FROM `ty_cache` WHERE uid="' . $id . '"';
        $db->query($sql2);
        $db->query($sql3);
        break;
    case 'share_del':
        $id = @$_POST['id'];
        $sql = 'DELETE FROM `ty_share` WHERE id="' . $id . '"';
        break;
    case 'share_state':
        $id = @$_POST['id'];
        $state = @$_POST['state'];
        $sql = 'UPDATE `ty_share` SET state=' . $state . ' WHERE id="' . $id . '"';
        break;
    case 'share_add':
        $code = randomkeys(8);
        $sql = 'INSERT INTO ty_share (name, code, type, uid, pid, pass, state, mode, add_time, end_time, text, size) VALUES ("' . $_POST['name'] . '","' . $code . '","' . $_POST['filetype'] . '","' . $_POST['uid'] . '","' . $_POST['pid'] . '","' . $_POST['pass'] . '","1","' . $_POST['mode'] . '",' . time() . ',"' . $_POST['endtime'] . '","' . $_POST['text'] . '","' . $_POST['size'] . '")';
        break;
    case 'share_edit':
        $sql = 'UPDATE `ty_share` SET pass="' . $_POST['pass'] . '",mode="' . $_POST['mode'] . '",text="' . $_POST['text'] . '",end_time="' . $_POST['endtime'] . '" WHERE id="' . $_POST['id'] . '"';
        break;
    default:
        exit(json_encode(array('code' => 1, 'msg' => '参数错误！')));
}
$rs = $db->query($sql);
$db->close();
if ($rs) {
    exit(json_encode(array('code' => 0, 'msg' => '操作成功！')));
} else {
    exit(json_encode(array('code' => 1, 'msg' => '操作失败！')));
}