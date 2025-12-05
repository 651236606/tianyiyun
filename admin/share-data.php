<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('PRC');
include 'config.php';
error_reporting(0);
$page = $_GET['page'];
$limit = $_GET['limit'];
if (isset($page)) {
    $page = $page;
} else {
    $page = 1;
}
$page = ($page - 1) * $limit;
$db = new M($hostname, $username, $password, $database);
$sql = 'SELECT * FROM ty_share order by id desc LIMIT ' . $page . ',' . $limit . '';
$rs = $db->query($sql);
while ($row = $db->fetch_array($rs)) {
    $end_time = date('Y-m-d H:i:s', $row['end_time']);
    if ($row['end_time'] < time()) {
        $end_time = '<font color="red">' . date('Y-m-d H:i:s', $row['end_time']) . '</font>';
    }
    $fileinfo[] = array('id' => $row['id'], 'name' => $row['name'], 'code' => $row['code'], 'type' => $row['type'], 'state' => $row['state'], 'mode' => $row['mode'], 'pass' => $row['pass'], 'add_time' => date('Y-m-d H:i:s', $row['add_time']), 'end_time' => $end_time, 'pv' => $row['pv_num'], 'down' => $row['down_num']);
}
$sql = 'SELECT * FROM ty_share';
$total = $db->num_rows($sql);
$data_arr = array('code' => '0', 'count' => $total, 'data' => $fileinfo);
$datainfo = json_encode($data_arr, !0);
echo $datainfo;
$db->close();