<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="images/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="images/action.js"></script>
    <link href="images/action.css" rel="stylesheet" type="text/css" media="all" />
    <link href="tpl/<?php echo $tpl_dir; ?>/images/style.css" rel="stylesheet" type="text/css" media="all" />
    <title><?php echo $title; ?></title>
</head>
<body>
<div id="wrapper">
<div id="head">
	<div id="logo"> <img src="tpl/<?php echo $tpl_dir; ?>/images/logo.png" title="我的mini微博" /></div>
	<div id="topNav"> <a href="index.php">首页</a> |
        <a href="message.php">脚印</a> |
        <?php
			$url = $_SERVER['PHP_SELF'];
			$filename = end(explode('/',$url));

            if(isset($_SESSION['log']) && $_SESSION['log'] == 'OK') {
                echo '<a href="javascript:funcLogout()">退出</a>';
				if($filename == 'index.php') {
					echo ' | <a href="javascript:funcNew()">写点</a>';
				}
            }else {
                echo '<a href="javascript:funcLogin()">登录</a>';
            }
			if($filename == 'message.php') {
				echo ' | <a href="javascript:funcMessage()">踩踩</a>';
			}
        ?>
	</div>
</div>
<div id="sysIdContain">
<div id="left">
    <div class="left_item" style="text-align: center;">
       
       
    </div>
    <div class="left_item">网站公告：<br /><?php echo $notice; ?></div>
    <?php
        if(!empty($link)) {
            echo '<div class="left_item">友情链接：<br />'.$link.'</div>';
        }
    ?>
    <div class="left_item" style="text-align: center;border-bottom: none;">ISAY3.NET &copy; 2011</div>
</div>
<div id="right">
	<div class="right_search">
		<div class="right_mood"><?php echo $mood; ?></div>
		<a href="javascript:funcSearch()">GO</a><input id="sysIdSearch" type="text" />
	</div>
