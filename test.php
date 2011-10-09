<?php
//1.从数据库中取出数据；2.循环输出数组
	
	mysql_connect("localhost","root","86210013") or die("con failed");
	mysql_select_db("minisay");
	$msql = "select * from isay_article";
	$res = mysql_query($msql) or die("query failed.");

	//$article_arr = mysql_fetch_array($res);
	echo "<table>";
	$article_arr = mysql_fetch_array($res)
	foreach($article_arr as $item){
	//while($article_arr = mysql_fetch_array($res)){
	  //	 ;
	    echo "<tr>";
		echo "<td>gid"."=>"."$item[gid] "."</td>";
		echo "<td>content"."=>"."$item[content]"."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>