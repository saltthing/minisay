<?php
//首页
session_start();
header("Content-type:text/html; charset=utf-8");
include_once('global.php');

//创建article对象
$article = new article($prefix);
//配置连接
$article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);

if($article->connect()) {
    //获取第几页
    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1;
    //获取记录集,总数,分页字符串
    if(isset($_GET['key'])) {
        //通过关键字获取记录
		$file_name = "cache/cache_article/key_".md5($_GET['key'])."_".$page.".cache";
        if(file_exists($file_name)) {
            $handle = fopen($file_name,'r');
            $array = unserialize(fread($handle,filesize($file_name)));
            fclose($handle);
        }else {
            $array = $article->search($_GET['key'],$each_article,$page);
            $handle = fopen($file_name,'w');
            fwrite($handle,serialize($array));
            fclose($handle);
        }

		$file_name = "cache/cache_article/key_".md5($_GET['key'])."_count.cache";
        if(file_exists($file_name)) {
            $handle = fopen($file_name,'r');
            $count = fread($handle,filesize($file_name));
            fclose($handle);
        }else {
            $count = $article->searchCount($_GET['key']);
            $handle = fopen($file_name,'w');
            fwrite($handle,$count);
            fclose($handle);
        }
        $pageStr = pagination($count,$each_article,$page,'index.php?key='.rawurlencode($_GET['key']).'&');
    }elseif(isset($_GET['gid'])) {
        //通过gid获取记录
		$file_name = "cache/cache_article/gid_".$_GET['gid'].".cache";
        if(file_exists($file_name)) {
            $handle = fopen($file_name,'r');
            $array = unserialize(fread($handle,filesize($file_name)));
            fclose($handle);
        }else {
            $arrayTp = $article->getById($_GET['gid']);
            if(!empty($arrayTp)) $array[] = $arrayTp;
            $handle = fopen($file_name,'w');
            fwrite($handle,serialize($array));
            fclose($handle);
        }
        $count = count($array);
        $pageStr = pagination($count,$each_article,$page,'index.php?gid='.$_GET['gid'].'&');
    }else {
        //获取分页记录
		$file_name = "cache/cache_article/page_".$page.".cache";
        if(file_exists($file_name)) {
            $handle = fopen($file_name,'r');
            $array = unserialize(fread($handle,filesize($file_name)));
            fclose($handle);
        }else {
            $array = $article->getByPage($each_article,$page);
            $handle = fopen($file_name,'w');
            fwrite($handle,serialize($array));
            fclose($handle);
        }
		$file_name = "cache/cache_article/count.cache";
        if(file_exists($file_name)) {
            $handle = fopen($file_name,'r');
            $count = fread($handle,filesize($file_name));
            fclose($handle);
        }else {
            $count = $article->count();
            $handle = fopen($file_name,'w');
            fwrite($handle,$count);
            fclose($handle);
        }
        $pageStr = pagination($count,$each_article,$page,'index.php?');
    }
    //引入模板
    include_once("tpl/$tpl_dir/index.tpl.php");
}
else
	echo "connect failed";
?>