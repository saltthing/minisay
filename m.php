<?php
//手机访问页
session_start();
header("Content-type: text/html; charset=utf-8");
include_once('global.php');
//登录
if(isset($_GET['act']) && $_GET['act'] == 'login') {
    if($_POST['logUn'] == $username && md5($_POST['logPw']) == $password) {
        $_SESSION['log'] = 'OK';
    }
    header('location:m.php');
}
//退出
if(isset($_GET['act']) && $_GET['act'] == 'logout') {
    $_SESSION['log'] = '';
    header('location:m.php');
}
if(isset($_SESSION['log']) && $_SESSION['log'] == 'OK') {
	//发布内容提交处理
    if(isset($_GET['act']) && $_GET['act'] == 'newSub') {
        if(!empty($_POST['newContent'])) {
            $article = new article($prefix);
            $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
            if($article->connect()) {
                $article->add($_POST['newContent']);
				clearDir("cache/cache_article/");
            }
        }
        header('location:m.php');
    }
	//修改内容提交处理
    if(isset($_GET['act']) && $_GET['act'] == 'editSub') {
        if(!empty($_POST['editContent'])) {
            $article = new article($prefix);
            $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
            if($article->connect()) {
                $article->updateById($_GET['gid'],$_POST['editContent']);
				clearDir("cache/cache_article/");
            }
        }
        header('location:m.php');
    }
	//删除文章
    if(isset($_GET['act']) && $_GET['act'] == 'delete') {
        if(!empty($_GET['gid'])) {
            $article = new article($prefix);
            $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
            if($article->connect()) {
                $article->delete($_GET['gid']);
				clearDir("cache/cache_article/");
            }
        }
        header('location:m.php');
    }
	//删除留言
    if(isset($_GET['act']) && $_GET['act'] == 'mesDelete') {
        if(!empty($_GET['mid'])) {
            $message = new message($prefix);
            $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
            if($message->connect()) {
                $message->delete($_GET['mid']);
				clearDir("cache/cache_message/");
            }
        }
        header('location:m.php?act=message');
    }
	//回复留言提交处理
    if(isset($_GET['act']) && $_GET['act'] == 'replySub') {
        if(!empty($_GET['mid']) && !empty($_POST['replyContent'])) {
            $message = new message($prefix);
            $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
            if($message->connect()) {
                $message->updateById($_GET['mid'],$_POST['replyContent']);
				clearDir("cache/cache_message/");
            }
        }
        header('location:m.php?act=message');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
</head>
<body>
<?php
if(isset($_SESSION['log']) && $_SESSION['log'] == 'OK') {
	//公共菜单
    echo ' <p><a href="m.php">首页</a> | '
        .'<a href="m.php?act=message">留言</a> | '
        .'<a href="m.php?act=logout">退出</a> | '
        .'<a href="m.php?act=new">发布</a></p><p>------------</p>';
	//留言页面
    if(isset($_GET['act']) && $_GET['act'] == 'message') {
        $message = new message($prefix);
        $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($message->connect()) {
            //获取第几页
            if(isset($_GET['page'])) $page = $_GET['page'];
            else $page = 1;
            //获取记录集,总数,分页字符串
            $array = $message->getByPage($each_message,$page);
            $count = $message->count();
            $pageStr = pagination($count,$each_message,$page,'m.php?act=message&');
            if(!empty($array)) {
                foreach($array as $item) {
                    echo '<p>'.$item['poster'].'：'.htmlToStr($item['message']);
                    if(!empty($item['reply'])) {
                        echo '<br />#回复# '.htmlToStr($item['reply']);
                    }
                    echo '<br /><span class="info">'.$item['postdate'].' , '.$item['posttime'].' , '
                        .'<a href="m.php?act=reply&mid='.$item['mid'].'">Reply</a> , '
                        .'<a href="m.php?act=mesDelete&mid='.$item['mid'].'">Delete</a></span></p><p>------------</p>';
                }
                echo '<p class="page">'.$pageStr.'</p>';
            }
        }
    }elseif(isset($_GET['act']) && $_GET['act'] == 'new') {//发布页面
        echo '<p><form action="m.php?act=newSub" method="post">'
            .'发布内容：<br /><textarea name="newContent"></textarea><br />'
            .'<input type="submit" value="发布" /></form></p>';
    }elseif(isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['gid']) ) {//修改页面
        $article = new article($prefix);
        //配置连接
        $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($article->connect()) {
            $item = $article->getById($_GET['gid']);
            echo '<p><form action="m.php?act=editSub&gid='.$_GET['gid'].'" method="post">'
                .'内容修改：<br /><textarea name="editContent">'.$item['content'].'</textarea><br />'
                .'<input type="submit" value="修改" /></form></p>';
        }
    }elseif(isset($_GET['act']) && $_GET['act'] == 'reply' && isset($_GET['mid']) ) {//回复页面
        $message = new message($prefix);
        $message->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($message->connect()) {
            $item = $message->getById($_GET['mid']);
            echo '<p><form action="m.php?act=replySub&mid='.$_GET['mid'].'" method="post">'
                .'留言回复：<br /><textarea name="replyContent">'.$item['reply'].'</textarea><br />'
                .'<input type="submit" value="回复" /></form></p>';
        }
    }else {//首页
        $article = new article($prefix);
        $article->config($mysql_server,$mysql_username,$mysql_password,$mysql_db);
        if($article->connect()) {
            //获取第几页
            if(isset($_GET['page'])) $page = $_GET['page'];
            else $page = 1;
            //获取记录集,总数,分页字符串
            if(isset($_GET['key'])) {
                $array = $article->search($_GET['key'],$each_article,$page);
                $count = $article->searchCount($_GET['key']);
                $pageStr = pagination($count,$each_article,$page,'m.php?key='.rawurlencode($_GET['key']).'&');
            }elseif(isset($_GET['gid'])) {
                $arrayTp = $article->getById($_GET['gid']);
                if(!empty($arrayTp)) $array[] = $arrayTp;
                $count = count($array);
                $pageStr = pagination($count,$each_article,$page,'m.php?gid='.$_GET['gid'].'&');
            }else {
                $array = $article->getByPage($each_article,$page);
                $count = $article->count();
                $pageStr = pagination($count,$each_article,$page,'m.php?');
            }
            if(!empty($array)) {
                foreach($array as $item) {
                    echo '<p>'.ubbToHtml($item['content']).'<br /><span class="info">'
                        .$item['postdate'].' , '.$item['posttime'].' , '
                        .'<a href="m.php?act=edit&gid='.$item['gid'].'">Edit</a> , '
                        .'<a href="m.php?act=delete&gid='.$item['gid'].'">Delete</a></span></p><p>------------</p>';
                }
                echo '<p class="page">'.$pageStr.'</p>';
            }
        }
    }
}else {//登录页面
    echo '<p><form action="m.php?act=login" method="post">'
        .'用户名：<br /><input type="text" name="logUn" /><br />'
        .'密码：<br /><input type="password" name="logPw" /><br />'
        .'<input type="submit" value="登录" /></form></p>';
}
?>
<p>Copyright &copy; 2011</p>
</body>
</html>