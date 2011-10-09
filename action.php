<?php
//操作页
session_start();
header("Content-type: text/html; charset=utf-8");
include_once('global.php');

//登录
if($_GET['act'] == 'login') {
    $loginUser = $_POST['loginUn'];
    $loginPw = $_POST['loginPw'];
    if($loginUser == $username && md5($loginPw) == $password) {
        $_SESSION['log'] = 'OK';
        echo '<span id="sysRe">loginSuccess</span>';
    }
}

//退出
if($_GET['act'] == 'logout') {
	$_SESSION['log'] = '';
	if($_SESSION['log'] == '') echo '<span id="sysRe">logoutSuccess</span>';
}

//留言
if($_GET['act'] == 'message') {
    $poster = $_POST['mePoster'];
    $content = $_POST['meContent'];
    if($poster && $content) {
        $message = new message($prefix);
        $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($message->connect()) {
            if($message->add($poster,$content)) {
				clearDir("cache/cache_message/");
                echo '<span id="sysRe">messageSuccess</span>';
            }
        }
    }
}

//获取回复
if($_GET['act'] == 'replyGet' && $_SESSION['log'] == 'OK') {
    if($_GET['mid']) {
        $message = new message($prefix);
        $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($message->connect()) {
            if($array = $message->getById($_GET['mid'])) {
                echo '<span id="sysRe">'.rawurlencode($array['reply']).'</span>';
            }
        }
    }
}

//回复
if($_GET['act'] == 'reply' && $_SESSION['log'] == 'OK') {
    $content = $_POST['reContent'];
    $mid = $_POST['mid'];
    if($content && $mid) {
        $message = new message($prefix);
        $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($message->connect()) {
            if($message->updateById($mid,$content)) {
				clearDir("cache/cache_message/");
                echo '<span id="sysRe">replySuccess</span>';
            }
        }
    }
}

//删除留言
if($_GET['act'] == 'messageDel' && $_SESSION['log'] == 'OK') {
    if($_GET['mid']) {
        $message = new message($prefix);
        $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($message->connect()) {
            if($message->delete($_GET['mid'])) {
				clearDir("cache/cache_message/");
                echo '<span id="sysRe">messageDelSuccess</span>';
            }
        }
    }
}

//获取文章
if($_GET['act'] == 'editGet' && $_SESSION['log'] == 'OK') {
    if($_GET['gid']) {
        $article = new article($prefix);
        $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($article->connect()) {
            if($array = $article->getById($_GET['gid'])) {
                echo '<span id="sysRe">'.rawurlencode($array['content']).'</span>';
            }
        }
    }
}

//修改文章
if($_GET['act'] == 'edit' && $_SESSION['log'] == 'OK') {
    $content = $_POST['editContent'];
    $gid = $_POST['gid'];
    if($content && $gid) {
        $article = new article($prefix);
        $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($article->connect()) {
            if($array = $article->updateById($gid,$content)) {
				clearDir("cache/cache_article/");
                echo '<span id="sysRe">editSuccess</span>';
            }
        }
    }
}

//删除文章
if($_GET['act'] == 'delete' && $_SESSION['log'] == 'OK') {
    if($_GET['gid']) {
        $article = new article($prefix);
        $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($article->connect()) {
            if($article->delete($_GET['gid'])) {
				clearDir("cache/cache_article/");
                echo '<span id="sysRe">deleteSuccess</span>';
            }
        }
    }
}

//发布文章
if($_GET['act'] == 'new' && $_SESSION['log'] == 'OK') {
    if($_POST['newContent']) {
        $article = new article($prefix);
        $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($article->connect()) {
            if($article->add($_POST['newContent'])) {
				clearDir("cache/cache_article/");
                echo '<span id="sysRe">newSuccess</span>';
            }
        }
    }
}

//文件上传
if($_GET['act'] == 'fileUpload' && $_SESSION['log'] == 'OK') {
    $upx = new uploadx();
    $upx->uploadx_form = 'uploadFile';
    $upx->uploadx_save = "files";
    $upx->uploadx_size = 1024*10;//10M
    $upx->uploadx_name = time();
	$upx->uploadx_type = "jpg|gif|png|zip|rar";
	if(!$upx->file()) {
		echo'<script>parent.funcUploadFailed();</script>';
	}else {
		$array = $upx->file;
		preg_match('/'.$array['type'].'/i',"jpg|gif|png",$arr);
		if($arr) {
			if($upload_resize == 1 && function_exists('gd_info')) {
				@resizeImage($array['path'],$array['path'],strtolower($array['type']),$upload_maxwidth,$upload_maxheight); 
			} 
			$str= '<a href=javascript:funcInsertTag(\'[IMG]'.$array['path'].'\',\'[/IMG]\',\'sysIdEditContent\')>插入</a>';
		}else {
			$str = '<a href=javascript:funcInsertTag(\''.$array['path'].'\',\'\',\'sysIdEditContent\')>插入</a>';
		}
		echo'<script>parent.funcUploadSuccess("文件路径：'.$array['path'].'&nbsp;&nbsp;'.$str
			.'&nbsp;&nbsp;<a href=\"javascript:funcFileDel(\''.$array['path'].'\')\">删除</a>");</script>';
	}    
}

//文件删除
if($_GET['act'] == 'fileDel' && $_SESSION['log'] == 'OK') {
    if($_GET['fileDir']) {
		if(@unlink($_GET['fileDir'])) echo '<span id="sysRe">fileDelSuccess</span>';
	}
}
?>