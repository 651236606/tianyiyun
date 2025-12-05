<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);

if (@$_GET['t'] !== 'vrecf') {
    exit(json_encode(array('code' => 400, 'msg' => '提交了非法参数！')));
}
$hostname = $_POST['hostname'];
$hostport = $_POST['hostport'];
$username = $_POST['username'];
$password = $_POST['password'];
$database = $_POST['database'];
$user_name = $_POST['user_name'];
$user_pass = MD5('www.vrecf.com' . $_POST['user_pass']);
$site = array('title' => trim(filter_input(INPUT_POST, 'site_title')), 'url' => trim(filter_input(INPUT_POST, 'site_url')), 'path' => trim(filter_input(INPUT_POST, 'site_path')), 'qq' => trim(filter_input(INPUT_POST, 'site_qq')), 'rewrite' => trim(filter_input(INPUT_POST, 'rewrite')), 'tj' => trim(filter_input(INPUT_POST, 'site_tj')), 'foot' => trim(filter_input(INPUT_POST, 'site_foot')));
$_mysqli = @new mysqli($hostname, $username, $password, $database, $hostport);
if (mysqli_connect_errno()) {
    exit(json_encode(array('code' => 401, 'msg' => '数据库链接失败！' . mysqli_connect_error()), !0));
}
if (file_exists('../save/config.php')) {
    require_once '../include/db.class.php';
    if (Main_db::save()) {
    } else {
        exit(json_encode(array('code' => 402, 'msg' => '数据库信息保存失败！'), !0));
    }
} else {
    exit(json_encode(array('code' => 402, 'msg' => '配置文件不存在，无法写入信息！'), !0));
}
$_mysqli->set_charset('UTF8');
$_mysqli->query('drop table if exists ty_user');
$_mysqli->query('drop table if exists ty_cache');
$_mysqli->query('drop table if exists ty_share');
$rs1 = $_mysqli->query('CREATE TABLE `ty_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL DEFAULT \'0\' COMMENT \'天翼账号\',
  `pass` varchar(100) NOT NULL COMMENT \'天翼密码\',
  `cookie` text NULL COMMENT \'天翼cookie\',
  `quota` varchar(20) NOT NULL DEFAULT \'0\' COMMENT \'网盘总容量\',
  `size` varchar(20) NULL COMMENT \'已使用容量\',
  `cishu` int(11) NULL COMMENT \'失效次数\',
  `beizhu` varchar(255) COMMENT \'备注信息\',
  `tz_time` int(10) unsigned NULL DEFAULT \'0\' COMMENT \'通知时间\',
  `add_time` int(10) unsigned NULL DEFAULT \'0\' COMMENT \'更新时间\',
  PRIMARY KEY (`id`,`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT=\'网盘账号\';');
$rs2 = $_mysqli->query('CREATE TABLE `ty_cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NULL DEFAULT \'0\' COMMENT \'账号ID\',
  `pid` varchar(100) NOT NULL DEFAULT \'0\' COMMENT \'文件ID\',
  `tid` varchar(100) NULL DEFAULT \'0\' COMMENT \'目录ID\',
  `name` varchar(255) NULL DEFAULT \'0\' COMMENT \'文件名\',
  `type` varchar(20) NULL DEFAULT \'0\' COMMENT \'文件类型\',
  `page` int(11) NULL DEFAULT \'1\' COMMENT \'所在页数\',
  `cishu` int(11) NULL DEFAULT \'0\' COMMENT \'请求次数\',
  `url` text NULL COMMENT \'文件源地址\',
  `add_time` int(10) unsigned NULL DEFAULT \'0\' COMMENT \'源地址入库时间\',
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'更新时间\',
  PRIMARY KEY (`id`,`pid`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT=\'缓存记录\';');
$rs3 = $_mysqli->query('CREATE TABLE `ty_share` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NULL DEFAULT \'0\' COMMENT \'文件名\',
  `code` varchar(20) NOT NULL DEFAULT \'0\' COMMENT \'识别码\',
  `size` varchar(10) NULL DEFAULT \'0\' COMMENT \'文件大小\',
  `type` varchar(10) NULL DEFAULT \'0\' COMMENT \'文件类型\',
  `uid` varchar(20) NULL DEFAULT \'0\' COMMENT \'账号ID\',
  `pid` varchar(100) NOT NULL DEFAULT \'0\' COMMENT \'文件ID\',
  `pass` varchar(20) NULL DEFAULT \'0\' COMMENT \'提取码\',
  `state` tinyint(1) NULL DEFAULT \'0\' COMMENT \'分享状态\',
  `mode` tinyint(1) NULL DEFAULT \'0\' COMMENT \'分享模式\',
  `add_time` int(10) unsigned NULL DEFAULT \'0\' COMMENT \'分享时间\',
  `end_time` int(10) unsigned NULL DEFAULT \'0\' COMMENT \'分享到期时间\',
  `text` varchar(255) NULL DEFAULT \'0\' COMMENT \'引流提示\',
  `pv_num` int(11) NULL DEFAULT \'0\' COMMENT \'浏览次数\',
  `down_num` int(11) NULL DEFAULT \'0\' COMMENT \'下载次数\',
  PRIMARY KEY (`id`,`pid`,`code`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT=\'分享记录\';');
showError($_mysqli);
if ($rs1 && $rs2 && $rs3) {
    $myfile = fopen('install.lock', 'w');
    fwrite($myfile, '删除该文件 才可重新安装');
    fclose($myfile);
    exit(json_encode(array('code' => 200, 'msg' => '安装成功！'), !0));
} else {
    exit(json_encode(array('code' => 400, 'msg' => '写入数据库失败！'), !0));
}
function getErrno($OOO0O)
{
    if ($OOO0O == 1044) {
        return '用户无权访问';
    }
    return $OOO0O;
}
function showError($OOOOO)
{
    if ($OOOOO->error) {
        exit(json_encode(array('code' => 400, 'msg' => '错误代码：<font color=\'red\'>' . getErrno($OOOOO->errno) . "</font>；<br /> 错误信息：<font color='red'>{$OOOOO->error}</font>"), !0));
    }
}