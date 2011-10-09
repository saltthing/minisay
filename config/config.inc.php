<?php
//数据库连接信息
$mysql_server = 'localhost';//mysql服务器地址
$mysql_username = 'root';//mysql用户名
$mysql_password = '86210013';//mysql密码
$mysql_db = 'minisay';//mysql数据库名[很多人忘记修改]
//数据库前缀
$prefix = 'isay_';
//模板路径
$tpl_dir = 'tpl_default';
//登录用户名和密码,不能为空,默认都是admin
$username = 'admin';
$password = md5('admin');
//每页显示文章数
$each_article = 10;
//每页显示留言数
$each_message = 15;
//心情
$mood = ':-) 美好的生活需要用心记录。o(∩_∩)o...';
//公告
$notice = 'minisay主页：http://www.isay3.net，联系QQ：792278952';
//标题
$title = 'minisay 记录生活的点滴';
//扩展链接
$link = '';
//文件上传是否缩放图片
$upload_resize = 1;
//文件缩放最大宽度
$upload_maxwidth = 400;
//文件缩放最大高度
$upload_maxheight = 300;
?>
