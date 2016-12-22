<?php
	@include_once('conToMysql.php');
	$query="select * from projectbrief ";
	
	$result=mysql_query($query);//执行查询
		if(!$result)
		{
			die("could not to the database</br>".mysql_error());
		}

		while($result_array=mysql_fetch_assoc($result))//取出结果并显示//$result_array=mysql_fetch_array($result);
		{
			$list[] = $result_array;
		}	
		
		echo json_encode($list);
	
	mysql_close($connection);
?>