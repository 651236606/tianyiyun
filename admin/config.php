<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
if (!file_exists('../install/install.lock')) {
    exit('您还未安装，请先安装，<a href="../install/">点此安装>></a>');
}
if (function_exists('opcache_reset')) {
    opcache_reset();
}
if (file_exists('../save/config.php')) {
    include '../save/config.php';
}
session_start();
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'admin';
if (empty($_SESSION['hashstr']) || $_SESSION['hashstr'] !== md5($user_name . $user_pass)) {
    header('location:./login.html');
    exit;
}