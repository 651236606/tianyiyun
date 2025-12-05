<?php
/*##################################################
# 萌芽天翼网盘管理
###################################################*/
header('Content-Type:text/html;charset=utf-8');
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.4.0','<'))  {die('PHP版本过低，最少需要PHP5.4，请升级PHP版本！');}
//不显示读取错误
ini_set("error_reporting","E_ALL & ~E_NOTICE");

function Typefiles($cookie,$fileid='-11',$type='',$page=1){
    $url = "http://cloud.189.cn/v2/listFiles.action?fileId=".$fileid."&mediaType=".$type."&keyword=&inGroupSpace=false&orderBy=1&order=ASC&pageNum=".$page."&pageSize=60&noCache=".lcg_value();
    $data = curl($url,$cookie);
    $provinces = json_decode($data ,true);
    return $provinces;
}

function listfiles($cookie,$fileid='-11',$page=1){
    $url = "http://cloud.189.cn/v2/listFiles.action?fileId=".$fileid."&mediaType=&keyword=&inGroupSpace=false&orderBy=1&order=ASC&pageNum=".$page."&pageSize=60&noCache=".lcg_value();
    $data = curl($url,$cookie);
    $provinces = json_decode($data ,true);
    return $provinces;
}


function piclist($cookie,$list,$page=1){
    $url = "http://cloud.189.cn/v2/getPhotoPreviewList.action?pageNum=".$page."&pageSize=6000&orderBy=1&order=ASC&noCache=".lcg_value()."&parentId=".$list;
    $data = curl($url,$cookie);
    $provinces = json_decode($data ,true);
    return $provinces;
}


//清空文件夹函数和清空文件夹后删除空文件夹函数的处理
function deldir($path){
	//如果是目录则继续
	if(is_dir($path)){
		//扫描一个文件夹内的所有文件夹和文件并返回数组
		$p = scandir($path);
		foreach($p as $val){
			//排除目录中的.和..
			if($val !="." && $val !=".."){
				//如果是目录则递归子目录，继续操作
				if(is_dir($path.$val)){
					//子目录中操作删除文件夹和文件
					deldir($path.$val.'/');
					//目录清空后删除空文件夹
					@rmdir($path.$val.'/');
				} else{
					//如果是文件直接删除
					unlink($path.$val);
				}
			}
		}
		return true;
	}
}

/*邮件通知*/
function sendEmail($mailconfig, $mailcontent)
{
    require_once("email.php");
    $smtpserver = $mailconfig['host'];
    $smtpserverport = $mailconfig['port'];
    $smtpusermail = $mailconfig['user'];
    $smtpemailto = $mailconfig['email'];
    $smtpuser = $mailconfig['user'];
    $smtppass = $mailconfig['pass'];
    $mailtitle = '★★天翼网盘重要通知★★';
    $mail = new MySendMail();
    $mail->setServer( $smtpserver, $smtpuser, $smtppass, $smtpserverport, true); 
    $mail->setFrom($smtpusermail); 
    $mail->setReceiver($smtpemailto); 
    $mail->setMail($mailtitle,$mailcontent); 
    $state=$mail->sendMail();
    if ($state == "") {
        return false;
    }else{
		return true;
	}
}

//主动判断是否HTTPS
function isHTTPS()
{
    if (defined('HTTPS') && HTTPS) return true;
    if (!isset($_SERVER)) return FALSE;
    if (!isset($_SERVER['HTTPS'])) return FALSE;
    if ($_SERVER['HTTPS'] === 1) {  //Apache
        return TRUE;
    } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
        return TRUE;
    } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
        return TRUE;
    }
    return FALSE;
}

/*
 * UC浏览器判断
*/
function Is_UC(){
	$agent = $_SERVER["HTTP_USER_AGENT"]; //浏览器标识信息
	if(strpos($agent, 'UCBrowser')){
		return true;
	}else{
		return false;
	}
}

function  curl($url,$cookies) {
	$ch = curl_init();
	$cookie[] = 'Cookie: '.$cookies;
    curl_setopt($ch, CURLOPT_HTTPHEADER,$cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent,Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;');
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT,10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//302redirect
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书和hosts	
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);  
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

/*
 * 文件大小计算
*/
function getFilesize($num){
   $p = 0;
   $format='bytes';
   if($num>0 && $num<1024){
     $p = 0;
     return sprintf("%.2f",number_format($num)).' '.$format;
   }
   if($num>=1024 && $num<pow(1024, 2)){
     $p = 1;
     $format = 'KB';
  }
  if ($num>=pow(1024, 2) && $num<pow(1024, 3)) {
    $p = 2;
    $format = 'MB';
  }
  if ($num>=pow(1024, 3) && $num<pow(1024, 4)) {
    $p = 3;
    $format = 'GB';
  }
  if ($num>=pow(1024, 4) && $num<pow(1024, 5)) {
    $p = 3;
    $format = 'TB';
  }
  $num /= pow(1024, $p);
  return sprintf("%.2f",number_format($num, 3)).' '.$format;
}

/*
 * 重定向302跳转地址。支持https
*/
function getrealurl($url,$cookies){
        $ch = curl_init();
	    $cookie[] = 'Cookie: '.$cookies;
        curl_setopt($ch, CURLOPT_HTTPHEADER,$cookie);	
        curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent,Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;');
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");		
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1); // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书和hosts	
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环	
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true); 
        $data = curl_exec($ch);
		preg_match_all('/^Location: (.*)$/mi', $data, $info);
        curl_close($ch);
		$url = str_replace(array("\r\n", "\r", "\n"), "", $info[1][0]); //去掉换行符
		return $url;		
}


function randomkeys($length) {
        $returnStr = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for($i = 0; $i < $length; $i ++) {
            $returnStr .= $pattern {
                mt_rand (0, 61)} ; //生成php随机数
        } 
        return $returnStr;
}


// 新浪短网址生成
function httpGet($url) {
	$curl = curl_init();
	$httpheader[] = "Accept:*/*";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
	curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10); //最大执行秒数
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_URL, $url);
	$res = curl_exec($curl);
	curl_close($curl);
	return $res;
}

function dwz_sina($longurl) {
	$appkey = '31641035'; //31641035
	$url='http://api.t.sina.com.cn/short_url/shorten.json?source='.$appkey.'&url_long='.urlencode($longurl);
	$result = httpGet($url);
	$arr = json_decode($result, true);
	return isset($arr[0]['url_short'])?$arr[0]['url_short']:false;
}

/*
 * 腾讯短网址生成
*/

function dwz_qq($longurl) {
	$url='http://sa.sogou.com/gettiny?url='.urlencode($longurl);
	$result = httpGet($url);
	return isset($result)?$result:false;
}

function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0,$extraJs='')
{
	$htmlhead  = "<html>\r\n<head>\r\n<title>提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><meta name=\"viewport\" content=\"width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no\">\r\n";
	$htmlhead .= "<base target='_self'/>\r\n<style>body{background:#f9fafd;color:#818181}.msg_jump{width:90%;max-width:624px;min-height:60px;padding:20px 50px 50px;margin:5% auto 0;font-size:14px;line-height:24px;border:1px solid #cdd5e0;border-radius:10px;background:#fff;box-sizing:border-box;text-align:center}.msg_jump .title{margin-bottom:11px}.msg_jump .text{margin-bottom:11px}.msg_jump_tit{width:100%;height:35px;margin:25px 0 10px;text-align:center;font-size:25px;color:#0099CC;letter-spacing:5px}</style></head>\r\n<body leftmargin='0' topmargin='0'>\r\n<center>\r\n<script>\r\n";
        $htmlfoot  = "</script>\r\n$extraJs</center>\r\n</body>\r\n</html>\r\n";       
        $litime=($limittime==0)?($gourl=="-1"? 3000:1000) :$limittime;
        if($gourl=="-1"){$gourl = "javascript:history.go(-1);";$msg_color="F00";}else{$msg_color="0FF";}
	if($gourl==''||$onlymsg==1)
	{
		$msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
	}else{
		$func = " var pgo=0;function JumpUrl(){ if(pgo==0){ location='$gourl'; pgo=1; } }\r\n";
		$rmsg = $func;
		$rmsg .= "document.write(\"<br /><div class='msg_jump'><div class='msg_jump_tit'>系统提示</div>";
	        $rmsg .= "<div class='text'>\");\r\n";

		$rmsg .= "document.write(\"<font style='color:$msg_color;'>".str_replace("\"","“",$msg)."</font>\");\r\n";
		$rmsg .= "document.write(\"";
		if($onlymsg==0)
		{
                        if($gourl!="javascript:;" && $gourl!=""){$rmsg .= "<br /><br /><a href='{$gourl}'><font style='color:#777777;'>如果你的浏览器没反应，请点击这里...</font></a>";}
			$rmsg .= "<br/></div></div>\");\r\n";
			if($gourl!="javascript:;" && $gourl!=''){$rmsg .= "setTimeout('JumpUrl()',$litime);";}                 
                }else{              
                    $rmsg .= "<br/><br/></div></div>\");\r\n";     
                }
		$msg  = $htmlhead.$rmsg.$htmlfoot;
	}
	echo $msg;
}

/*
 * 远程post数据
*/
function  curl_post($url,$post_data) {
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent,Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;');
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_TIMEOUT,10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);  
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

//获取远程内容
function geturl($url,$timeout = 10) {  
    $user_agent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36";  
	$curl = curl_init();                                        //初始化 curl
    curl_setopt($curl, CURLOPT_URL, $url);                      //要访问网页 URL 地址
	curl_setopt($curl, CURLOPT_USERAGENT,$user_agent);		   //模拟用户浏览器信息 
    curl_setopt($curl, CURLOPT_REFERER,$url) ;               //伪装网页来源 URL
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                //当Location:重定向时，自动设置header中的Referer:信息                   
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);             //数据传输的最大允许时间 
    curl_setopt($curl, CURLOPT_HEADER, 0);                     //不返回 header 部分
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);            //返回字符串，而非直接输出到屏幕上
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);             //跟踪爬取重定向页面
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');        //不检查 SSL 证书来源
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '0');        //不检查 证书中 SSL 加密算法是否存在
	curl_setopt($curl, CURLOPT_ENCODING, '');	          //解决网页乱码问题
    $data = curl_exec($curl);
	curl_close($curl);
    return $data;
}

function SubmitData($id,$tid,$page,$typecms){
	global $db,$site;
	$sql = 'SELECT * FROM ty_user WHERE id='.$id.'';
	$row = $db->getRow($sql);
	$cookie = $row['cookie'];
	$arr = listfiles($cookie,$tid,$page);
	$play_url = '';
	$pic_url = '';
	$i=1;
	foreach ($arr['data'] as $info) {
		if($info['fileType']!='' && $info['fileSize']!=''){
			$sql = 'INSERT INTO ty_cache (uid, pid, tid, name, type, page) VALUES ("'.$id.'","'.$info['fileId'].'","'.$tid.'","'.$info['fileName'].'","'.$info['fileType'].'","'.$page.'") ON DUPLICATE KEY UPDATE tid=VALUES(tid),name=VALUES(name),page=VALUES(page)';
			$db->query($sql);
		}
		if(preg_match('/^(jpg|png|gif|jpeg)$/i',$info['fileType'])) {
			$pic_url = $site['url'].$site['path'].'api/img.php?v='.$info['fileId'];
			if($site['rewrite']>0){
				$pic_url = $site['url'].'/yunimg/'.$info['fileId'];
			}
		}
		if(preg_match('/^(mp4)$/i',$info['fileType'])){
			if($site['rewrite']>0){
				if($i==1){
					$play_url .= "第".$i."集$".$site['url'].'/yunmp4/'.$info['fileId'].'.mp4';
				} else{
					$play_url .= "#第".$i."集$".$site['url'].'/yunmp4/'.$info['fileId'].'.mp4';
				}
			} else{
				if($i==1){
					$play_url .= "第".$i."集$".$site['url'].$site['path'].'api/index.php?v='.$info['fileId'];
				} else{
					$play_url .= "#第".$i."集$".$site['url'].$site['path'].'api/index.php?v='.$info['fileId'];
				}
			}
			$i++;
		}
	}
	if($pic_url=='' || $play_url==''){
		return false;
	}else{
	    if($typecms=='maccmsv8'){
		    $data_arr['d_pic'] = $pic_url;
		    $data_arr['d_playurl'] = $play_url;
	    } else if($typecms=='maccmsv10'){
		    $data_arr['vod_pic'] = $pic_url;
		    $data_arr['vod_play_url'] = $play_url;
	    }
	    return $data_arr;		
	} 
}


function lsMobile(){
if(isset($_SERVER['HTTP_USER_AGENT']))
  {
   $clientkeywords=array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
   if(preg_match("/(". implode('|',$clientkeywords). ")/i",strtolower($_SERVER['HTTP_USER_AGENT']))){return true;}
  }	
   return false;
}

/* 验证码类
*/
class ValidateCode {
 private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//随机因子
 private $code;//验证码
 private $codelen = 4;//验证码长度
 private $width = 120;//宽度
 private $height = 50;//高度
 private $img;//图形资源句柄
 private $font;  //注意字体路径要写对
 private $fontsize = 20;//指定字体大小
 private $fontcolor;//指定字体颜色
 
 //构造方法初始化
   public function __construct() {
    $this->isgd();
    $this->font = dirname(__FILE__)."/data/Elephant.ttf";
    $this->doimg(); 
 }
   
//检测是否支持GD,如果不支持输出固定图片(ABCD)
 private function isgd(){
     if(!function_exists("imagecreate")){
		    $this->code="ABCD";
		    header('Content-type:image/png');
	            exit(file_get_contents(dirname(__FILE__)."/data/vdcode.png"));
      }
  }
 
 //生成随机码
 private function createCode() {    
     
   $_len = strlen($this->charset)-1; for ($i=0;$i<$this->codelen;$i++) {$this->code .= $this->charset[mt_rand(0,$_len)];}
   
  //for($i=0; $i<$this->codelen; $i++)$this->code .= chr(mt_rand(65,90));   
 }
 //生成背景
 private function createBg() {
  $this->img = imagecreatetruecolor($this->width, $this->height);
  $color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
  imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
 }
 //生成文字
 private function createFont() {
  $_x = $this->width / $this->codelen;
  for ($i=0;$i<$this->codelen;$i++) {
     $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
  if(!imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i])) 
     {
       imagestring($this->img, 5,$_x*$i+mt_rand(1,5),mt_rand(1,$this->height-20), $this->code[$i], $this->fontcolor);

     }
  }
 }
 //生成线条、矩阵
 private function createLine() {
  //线条
  for ($i=0;$i<6;$i++) {
   $color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
   imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
  }
 
   //雪花
  for ($i=0;$i<100;$i++) {
   $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
   imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
  }
 
 
 
 }
 //输出特定类型的图片格式，优先级为png -> jpg   
 private function outPut() {    

	if(function_exists("imagepng"))
	{
		 header("content-type:image/png\r\n");
		 imagepng($this->img);
	}else{	
		header("content-type:image/jpeg\r\n");
		imagejpeg($this->img);
			
	} 
       imagedestroy($this->img);
 }
 //对外生成
 public function doimg() {
  $this->createBg();
  $this->createCode();
  $this->createLine();
  $this->createFont();
  $this->outPut();
 }
 
 //获取验证码
 public function getCode(){ return $this->code; }
 
}