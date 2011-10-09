<?php
//首页模板
include_once('head.tpl.php');

if(!empty($array)) {
	foreach($array as $item) {
		echo '<div class="right_item">';
		echo ubbToHtml($item['content']).'<div class="right_item_info">'
			.'发布于：<a href="index.php?gid='.$item['gid'].'">'.$item['postdate'].'&nbsp;&nbsp;'.$item['posttime'].'</a>';
		if(isset($_SESSION['log']) && $_SESSION['log'] == 'OK') {
			echo '&nbsp;&nbsp;<a href="javascript:funcEdit('.$item['gid'].')">Edit</a>'
			.'&nbsp;&nbsp;<a href="javascript:funcDel('.$item['gid'].')">Delete</a>';
		}
		echo '</div></div>';
	}
	echo '<div class="right_page">'.$pageStr.'</div>';
}

include_once('foot.tpl.php');
?>
