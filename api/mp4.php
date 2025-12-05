<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>在线预览视频</title>
    <script src="style/h5.js" type="text/javascript"></script>
    <link href="style/h5.css" rel="stylesheet">
    <style>.tip{ position: fixed; z-index: 4; top: 0px; left: 0px; height: auto; width: 100%;}</style>
  </head>
  <body style="overflow-y:hidden;">
    <div style="background-color: black;text-align: center;" class=\'tip\'>
      <marquee scrollamount="3"><font color="#00FF00">视频在线播放只支持mp4格式，且视频编码必须为H264编码，否则可能无法播放，或者播放有声音，无画面！</font></marquee>
    </div>
    <div style="margin:0px auto;width:100%;height:100%;">
      <iframe scrolling="no" allowtransparency="true" allowfullscreen="true" frameborder="0" src="./player.php?pid=';
echo $_GET['pid'];
echo '" width="100%" height="100%"></iframe>
    </div>
    <span style="display: none;"></span>
  </body>
</html>

';