<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-type:text/json');
date_default_timezone_set('PRC');
include '../include/cache.class.php';
include 'config.php';
error_reporting(0);
$id = $_GET['id'];
$page = $_GET['page'];
$limit = $_GET['limit'];
$wd = $_GET['wd'] ? $_GET['wd'] : '';
$orderby = $_GET['orderby'] ? $_GET['orderby'] : '1';
$by = $_GET['by'] ? $_GET['by'] : 'ASC';
$parentId = $_GET['parentId'] ? $_GET['parentId'] : '-11';
$db = new M($hostname, $username, $password, $database);
$sql = 'SELECT * FROM ty_user WHERE id=' . $id . '';
$row = $db->getRow($sql);
$cookie = $row['cookie'];
$cache_time = 3600;
if (@$_GET['v'] == 'file') {
    $cache_time = 180;
}
$cachedir = '../cache/';
$cache = new Cache($cachedir, $cache_time, '.js');
$cache->load();
if ($_GET['v'] == 'photos') {
    $pid = $_GET['pid'];
    $row = $db->getRow('SELECT * FROM ty_cache WHERE pid=' . $pid);
    if ($row['url']) {
        $imgarr[] = array('alt' => $row['name'], 'pid' => $pid, 'src' => $row['url'], 'thumb' => $row['url']);
    } else {
        if ($row['page']) {
            $parentId = $row['tid'];
        }
        $data = piclist($cookie, $parentId);
        $sql = 'INSERT INTO ty_cache (uid, pid, tid, name, type, page, url, add_time) VALUES ';
        $sq = array();
        foreach ($data['data'] as $key => $info) {
            $pagenum = intval($key / 60) + 1;
            if ($limit > 60) {
                if ($page > 1) {
                    $limit = ($page - 1) * $limit;
                    $pagenum = intval(($key + $limit) / 60) + 1;
                }
            }
            $sq[] = '("' . $id . '","' . $info['fileId'] . '","' . $info['parentId'] . '","' . $info['fileName'] . '","jpg","' . $pagenum . '","' . $info['origPicUrl'] . '","' . time() . '")';
            if ($info['fileId'] == $pid) {
                $imgarr[] = array('alt' => $info['fileName'], 'pid' => $info['fileId'], 'src' => $info['origPicUrl'], 'thumb' => $info['galPicUrl']);
                break;
            }
        }
        $sql .= join(',', $sq);
        $sql .= ' ON DUPLICATE KEY UPDATE url=VALUES(url),add_time=VALUES(add_time)';
        if (strpos($sql, '("') && strpos($sql, '")')) {
            $db->query($sql);
        }
        unset($sql, $sq);
    }
    $filedata = array('status' => '1', 'msg' => 'ok', 'title' => '预览相册', 'id' => 123, 'start' => 0, 'data' => $imgarr);
} else {
    if ($_GET['v'] == 'file') {
        $pid = $_GET['pid'];
        $row = $db->getRow('SELECT * FROM ty_cache WHERE pid=' . $pid);
        if ($row['url'] && $row['add_time'] + 180 > time()) {
            $file_url = $row['url'];
        } else {
            if ($row['page']) {
                $page = $row['page'];
                $parentId = $row['tid'];
            }
            $pandata = listfiles($cookie, $parentId, $page);
            foreach ($pandata['data'] as $dwon) {
                if ($dwon['fileId'] == $pid) {
                    $downurl = getrealurl('https:' . $dwon['downloadUrl'], $cookie);
                    $file_url = getrealurl($downurl, $cookie);
                    $db->query("update ty_cache set url='" . $file_url . "',add_time=" . time() . ' where pid=' . $pid);
                    break;
                }
            }
        }
        if (!$file_url) {
            $pandata = listfiles($cookie, $parentId, 1, 600, $row['name']);
            foreach ($pandata['data'] as $file) {
                if ($pid == $file['fileId']) {
                    $downurl = getrealurl('https:' . $file['downloadUrl'], $cookie);
                    $file_url = getrealurl($downurl, $cookie);
                    $db->query("update ty_cache set url='" . $file_url . "',add_time=" . time() . ' where pid=' . $pid);
                    break;
                }
            }
        }
        if ($file_url) {
            $filedata = array('code' => '1', 'msg' => '下载地址ok', 'data' => $file_url);
        } else {
            $filedata = array('code' => '0', 'msg' => 'error', 'data' => null);
        }
    } else {
        $pandata = listfiles($cookie, $parentId, $page, $limit, $wd, $orderby, $by);
        $datanum = $pandata['recordCount'];
        $pagenum = $pandata['pageNum'];
        $sql = 'INSERT INTO ty_cache (uid, pid, tid, name, type, page) VALUES ';
        $sq = array();
        foreach ($pandata['data'] as $key => $info) {
            $fileName = $info['fileName'];
            $createTime = $info['createTime'];
            $fileType = $info['fileType'];
            $num = count($pandata['data']);
            if ($limit > 60) {
                $pagenum = intval($key / 60) + 1;
                if ($page > 1) {
                    $limit = ($page - 1) * $limit;
                    $pagenum = intval(($key + $limit) / 60) + 1;
                }
            }
            if ($info['fileType'] != '' && $info['fileSize'] != '') {
                $fileSize = getFilesize($info['fileSize']);
                $sq[] = '("' . $id . '","' . $info['fileId'] . '","' . $info['parentId'] . '","' . $info['fileName'] . '","' . $info['fileType'] . '","' . $pagenum . '")';
            } else {
                $fileType = '文件夹';
                $fileSize = '';
                $fileName = '<a href="?id=' . $id . '&parentId=' . $info['fileId'] . '" style="color:blue;">' . $fileName . '</a>';
            }
            $fileinfo[] = array('fileName' => $fileName, 'fileId' => $info['fileId'], 'fileType' => $fileType, 'fileSize' => $fileSize, 'page' => $page, 'time' => $createTime);
        }
        $sql .= join(',', $sq);
        $sql .= ' ON DUPLICATE KEY UPDATE tid=VALUES(tid),name=VALUES(name),page=VALUES(page)';
        if (strpos($sql, '("') && strpos($sql, '")')) {
            $db->query($sql);
        }
        foreach ($pandata['path'] as $path) {
            $pathid = $path['fileId'];
            $pathname = $path['fileName'];
            $menu[] = '<a href="?id=' . $id . '&parentId=' . $pathid . '">' . $pathname . '</a><span lay-separator="">/</span>';
        }
        unset($sql, $sq);
        $filedata = array('code' => '0', 'msg' => 'ok', 'count' => $datanum, 'path' => $menu, 'data' => $fileinfo);
    }
}
$datainfo = json_encode($filedata, true);
if ($filedata['data'] !== null) {
    $cache->write(1, $datainfo);
}
echo $datainfo;
$db->close();