<?php
//留言页模板
include_once('head.tpl.php');

if(!empty($array)) {
	foreach($array as $item) {
		echo '<div class="right_item"><span style="font: bold 12px Verdana;color: green;">'
			.htmlToStr($item['poster']).'</span> ：'.htmlToStr($item['message']).'<br>';
		if(!empty($item['reply'])) {
			echo '<blockquote>'.htmlToStr($item['reply']).'</blockquote>';
		}
		echo '<div class="right_item_info">';
		echo '发布于：'.$item['postdate'].'&nbsp;&nbsp;'.$item['posttime'];
		if(isset($_SESSION['log']) && $_SESSION['log'] == 'OK') {
			echo '&nbsp;&nbsp;<a href="javascript:funcReply('.$item['mid'].')">Reply</a>'
			.'&nbsp;&nbsp;<a href="javascript:funcMessageDel('.$item['mid'].')">Delete</a>';
		}
		echo '</div></div>';
	}
	echo '<div class="right_page">'.$pageStr.'</div>';
}

include_once('foot.tpl.php');
?>