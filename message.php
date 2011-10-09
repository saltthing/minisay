<?php
//留言页
session_start();
header("Content-type:text/html; charset=utf-8");
include_once('global.php');

//创建message对象
$message = new message($prefix);
//配置连接
$message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
if($message->connect()) {
    //获取第几页
    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1;
    //获取记录集,总数,分页字符串
	$file_name = "cache/cache_message/page_".$page.".cache";
    if(file_exists($file_name)) {
        $handle = fopen($file_name,'r');
        $array = unserialize(fread($handle,filesize($file_name)));
        fclose($handle);
    }else {
        $array = $message->getByPage($each_message,$page);
        $handle = fopen($file_name,'w');
        fwrite($handle,serialize($array));
        fclose($handle);
    }
	$file_name = "cache/cache_message/count.cache";
    if(file_exists($file_name)) {
        $handle = fopen($file_name,'r');
        $count = fread($handle,filesize($file_name));
        fclose($handle);
    }else {
        $count = $message->count();
        $handle = fopen($file_name,'w');
        fwrite($handle,$count);
        fclose($handle);
    }
    $pageStr = pagination($count,$each_message,$page,'message.php?');
    //引入模板
    include_once("tpl/$tpl_dir/message.tpl.php");
}
?>