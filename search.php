<?php
print <<<EOT
	<form action = "search_results.php" method = "post">
		<input name = "searchWord" type = "text" size = "80" />
		<select name = "searchType">
			<option value = "author">作者</option>
			<option value = "title">标题</option>
			<option value = "ISBN">ISBN</option>
		</select>
		<input name = "searchSubmit" type = "submit" value = "搜索" /> 
		
	
	</form>
EOT
?>