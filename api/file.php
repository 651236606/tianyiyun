<?php

error_reporting(0);
date_default_timezone_set('PRC');
$db = new M($hostname, $username, $password, $database);
$row = $db->getRow('SELECT * FROM ty_cache WHERE pid=' . $pid);
$uid = $row['uid'];
$tid = $row['tid'];
$file_name = $row['name'];
$file_url = $row['url'];
$add_time = $row['add_time'];
$type = $row['type'];
$page = $row['page'] ? $row['page'] : 1;
if (!$tid) {
    exit('参数错误，未找到数据！' . $tid);
}
$db->query('UPDATE ty_cache SET cishu=cishu+1 WHERE pid="' . $pid . '"');
if (preg_match('/^(mp4)$/i', $type)) {
    $endtime = 10500;
} else {
    if (preg_match('/^(jpg|png|gif|jpeg)$/i', $type)) {
        $endtime = 99999999;
    } else {
        $endtime = 180;
    }
}
if ($file_url && $add_time + $endtime > time()) {
} else {
    $sql = 'SELECT * FROM ty_user WHERE id=' . $uid . '';
    $obj = $db->getRow($sql);
    $cookie = $obj['cookie'];
    if (preg_match('/^(jpg|png|gif|jpeg)$/i', $type)) {
        $arr = piclist($cookie, $tid);
        foreach ($arr['data'] as $file) {
            $db->query("update ty_cache set url='" . $file['origPicUrl'] . "',add_time=" . time() . ' where pid=' . $file['fileId']);
            if ($file['fileId'] == $pid) {
                $file_url = $file['origPicUrl'];
            }
        }
    } else {
        $arr = listfiles($cookie, $tid, $page);
        foreach ($arr['data'] as $dwon) {
            if ($dwon['fileId'] == $pid) {
                if (preg_match('/^(mp4)$/i', $type)) {
                    $video = curl('http:' . $dwon['videoUrl'], $cookie);
                    $playurl = json_decode($video, true);
                    $mp4url = 'http:' . $playurl['url'];
                    $vod_url = getrealurl($mp4url, $cookie);
                    $file_url = str_replace('http:', 'https:', $vod_url);
                } else {
                    $downurl = getrealurl('https:' . $dwon['downloadUrl'], $cookie);
                    $file_url = getrealurl($downurl, $cookie);
                }
            }
        }
    }
    unset($arr);
    if (!$file_url) {
        $pandata = listfiles($cookie, $tid, 1, 600, $file_name);
        foreach ($pandata['data'] as $file) {
            if ($pid == $file['fileId']) {
                $filetype = $file['fileType'];
                if (preg_match('/^(mp4)$/i', $type)) {
                    $video_url = $file['videoUrl'];
                    $video = curl('http:' . $video_url, $cookie);
                    $playurl = json_decode($video, true);
                    $mp4url = 'http:' . $playurl['url'];
                    $vod_url = getrealurl($mp4url, $cookie);
                    $file_url = str_replace('http:', 'https:', $vod_url);
                } else {
                    $downurl = getrealurl('https:' . $file['downloadUrl'], $cookie);
                    $file_url = getrealurl($downurl, $cookie);
                }
                break;
            }
        }
    }
    if ($file_url) {
        $db->query('UPDATE ty_cache SET url="' . $file_url . '",add_time=' . time() . ' WHERE pid="' . $pid . '"');
        $db->query('UPDATE ty_user SET cishu=0,tz_time=0 WHERE id="' . $uid . '"');
    } else {
        if (preg_match('/^(mp4)$/i', $type)) {
            $file_url = $site['url'] . $site['path'] . 'api/403.mp4';
        }
        if ($obj['cishu'] > 3 && $obj['tz_time'] == '' || $obj['cishu'] > 3 && $obj['tz_time'] + 3600 < time()) {
            if ($email['mailon'] > 0) {
                sendEmail($email, '账号：' . $obj['uid'] . '的网盘cookie失效了，请及时重新登陆更新cookie');
            }
            $db->query('UPDATE ty_user SET cishu=cishu+1,tz_time=' . time() . ' WHERE id="' . $uid . '"');
        } else {
            $db->query('UPDATE ty_user SET cishu=cishu+1 WHERE id="' . $uid . '"');
        }
    }
}
$url = $file_url;