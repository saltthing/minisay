<?php
/**
 * 分页函数
 */
function pagination($count,$each,$page,$url) {
    $total = ceil($count/$each);
    $str = '<a href="'.$url.'">首页</a> ';
    for($num = $page-2; $num < $page+3; $num++) {
        if($num == $page) $str .= "$num ";
        elseif($num >0 && $num<=$total) $str .= '<a href="'.$url.'page='.$num.'">['.$num.']</a> ';
    }
    $str .= '<a href="'.$url.'page='.$total.'">末页</a>';
    $str .= ' | 共'.$total.'页/'.$count.'条记录';
    return $str;
}
/**
 * ubb转换成html
 */
function ubbToHtml($getstr) {
    $str = $getstr;
	//去除多余空格,回车
	$str = preg_replace("/\[CENTER\] *\r?\n/i","[CENTER]",$str);
	$str = preg_replace("/\[RIGHT\] *\r?\n/i","[RIGHT]",$str);
	$str = preg_replace("/\[QUOTE\] *\r?\n/i","[QUOTE]",$str);

	$str = preg_replace("/\[\/CENTER\] *\r?\n/i","[/CENTER]",$str);
	$str = preg_replace("/\[\/RIGHT\] *\r?\n/i","[/RIGHT]",$str);
	$str = preg_replace("/\[\/QUOTE\] *\r?\n/i","[/QUOTE]",$str);
	//特殊字符处理
    $str = htmlspecialchars($str);
    $str = preg_replace("/\ /", "&nbsp;",$str);  
    $str = preg_replace("/\t/", "&nbsp;&nbsp;&nbsp;&nbsp;",$str); 
	$str=preg_replace("/\r?\n/",'<br />',$str);
    //字体样式
    $match = array("/(\[B\])(.*)(\[\/B\])/iU",
                   "/(\[I\])(.*)(\[\/I\])/iU",
                   "/(\[U\])(.*)(\[\/U\])/iU");
    $replace = array("<B>\\2</B>",
                     "<I>\\2</I>",
                     "<U>\\2</U>");
    $str = preg_replace($match, $replace, $str);
    //文字大小
    $str = preg_replace("/(\[SIZE=(.*)px\])(.*)(\[\/SIZE\])/iU", "<span style=\"font-size:\\2px;\">\\3</span>", $str);
    //字体
    $str = preg_replace("/(\[FONT=(.*)\])(.*)(\[\/FONT\])/iU", "<span style=\"font-family:\\2;\">\\3</span>", $str);
    //文字对其方式
    $match = array("/(\[CENTER\])(.*)(\[\/CENTER\])/iU",
                   "/(\[LEFT\])(.*)(\[\/LEFT\])/iU",
                   "/(\[RIGHT\])(.*)(\[\/RIGHT\])/iU");
    $replace = array("<div style=\"text-align:center;\">\\2</div>",
                     "<div style=\"text-align:left;\">\\2</div>",
                     "<div style=\"text-align:right;\">\\2</div>");
    $str = preg_replace($match, $replace, $str);
    //简单颜色
    $match = array("/(\[RED\])(.*)(\[\/RED\])/iU",
                   "/(\[BLUE\])(.*)(\[\/BLUE\])/iU",
                   "/(\[GREEN\])(.*)(\[\/GREEN\])/iU");
    $replace = array("<span style=\"color:red;\">\\2</span>",
                     "<span style=\"color:blue;\">\\2</span>",
                     "<span style=\"color:green;\">\\2</span>");
    $str = preg_replace($match, $replace, $str);
    //完整颜色
    $str = preg_replace("/(\[COLOR=(.*)\])(.*)(\[\/COLOR\])/iU", "<font color=\"\\2\">\\3</font>", $str);
    //引用
    $str = preg_replace("/(\[QUOTE\])(.*)(\[\/QUOTE\])/iU", "<blockquote>\\2</blockquote>", $str);
    //图片
    $str = preg_replace("/(\[IMG\])(.*)(\[\/img\])/iU", "<img src=\"\\2\" />", $str);
    //URL
    $str = preg_replace("/(\[URL\])(.*)(\[\/url\])/iU", "<a href=\"\\2\" target=\"new\">\\2</a>", $str);
    $str = preg_replace("/(\[URL=(.*)\])(.*)(\[\/url\])/iU", "<a href=\"\\2\" target=\"new\">\\3</a>", $str);
	//标签
    $str = preg_replace("/(\[TAG\])(.*)(\[\/TAG\])/iUe", "'<a href=\"index.php?key='.rawurlencode('[TAG]\\2[/TAG]').'\">\\2</a>'", $str);

	//Flash
	$str = preg_replace("/(\[FLASH=(.*),(.*)\])(.*)(\[\/FLASH\])/iU",
'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="\\2" height="\\3"><param name="movie" value="\\4" /><param name="quality" value="high" /><param name="wmode" value="Opaque"><embed src="\\4" width="\\2" height="\\3" quality="high" type="application/x-shockwave-flash" wmode="Opaque" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object>',$str);
    //mp3
	$str = preg_replace('/\[mp3\](.*)\[\/mp3\]/iU',
'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="290" height="24"><param name="movie" value="http://www.568g.cn/mp3/player.swf?soundFile=\\1&s=3&bg=0xC2C2C2&leftbg=0xA1A1A1&lefticon=0xF2F2F2&rightbg=0xA1A1A1&rightbghover=0x808080&righticon=0xF2F2F2&righticonhover=0xFFFFFF&text=0xFFFFFF&slider=0x858585&track=0xFFFFFF&border=0xFFFFFF&loader=0xB3B3B3&autostart=no&loop=yes&.swf" /><param name="quality" value="high" /><param value="transparent" name="wmode" /><embed src="http://www.568g.cn/mp3/player.swf?soundFile=\\1&s=3&bg=0xC2C2C2&leftbg=0xA1A1A1&lefticon=0xF2F2F2&rightbg=0xA1A1A1&rightbghover=0x808080&righticon=0xF2F2F2&righticonhover=0xFFFFFF&text=0xFFFFFF&slider=0x858585&track=0xFFFFFF&border=0xFFFFFF&loader=0xB3B3B3&autostart=no&loop=yes&.swf" width="290" height="24" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed></object>',$str);
	return $str;
}
/**
 * 格式化输出
 */
function htmlToStr($getstr) {
    $str = $getstr;
    $str = trim($str);
    $str = htmlspecialchars($str);
	//空格
    $str = preg_replace("/\ /", "&nbsp;",$str);  
    //水平制表符
    $str = preg_replace("/\t/", "&nbsp;&nbsp;&nbsp;&nbsp;",$str); 
    //换行
	$str=preg_replace("/\r?\n/",'<br />',$str);
	return $str;
}
/**
 * 清空文件夹,一级目录
 */
function clearDir($path) {
    if($dirhandle = opendir($path)) {
        while(false !=($file = readdir($dirhandle))) {
            if ($file == '.' || $file == '..') continue;  
            else unlink($path.$file); 
        }
    }
}
/**
 * 图片缩放
 */
function resizeImage($imagePath, $thumb, $type, $width = 400, $height = 300) {
	list($imageWidth, $imageHeight) = getimagesize($imagePath);
	if($type == "jpg") { 
		$imagePath = imagecreatefromjpeg($imagePath); 
	} 
	if($type == "gif") { 
		$imagePath = imagecreatefromgif($imagePath); 
	} 
	if($type == "png") { 
		$imagePath = imagecreatefrompng($imagePath); 
	} 
	if($width < $imageWidth) {
		$heightx = ($width/$imageWidth)*$imageHeight;
	}else {
		$width = $imageWidth;
		$heightx = $imageHeight;
	}
	if($height < $heightx) {
		$width = ($height/$heightx)*$width;
	}else {
		$height = $heightx;
	}

	$image = imagecreatetruecolor($width, $height);
	$background = imagecolorallocate($image, 255, 255, 255);   
    imagefill($image,0,0,$background);
	imagecopyresampled($image, $imagePath, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight);
	imagejpeg($image, $thumb);
	imagedestroy($image);
}
?>