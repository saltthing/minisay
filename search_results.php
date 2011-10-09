<?php
//获得传递数据
	$searchType = $_POST[searchType];
	$searchWord = $_POST[$searchWord];
	echo "\$searchType:"."&nbsp&nbsp"."$searchType";
//连接数据库
	mysql_connect("localhost","root","86210013");
	mysql_select_db("minisay");
	$bquery = mysql_query("select * from books where searchType=".$searchType. "like". $searchWord);
//进行数据库查询，将结果保存在数据books中
	$res = mysql_fetch_array($bquery);
	while($res){
		echo $res;
	}
?>