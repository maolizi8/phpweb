<?php
	@include_once('conToMysqli.php');
	
		$query="select * from testerinfo order by testerid ASC";//查询所有的tester
		
		$result=$mysqli->query($query);//执行查询
		
		if(!$result)
		{
			die("could not to the database</br>".$mysqli->error());
		}

		while($result_array=$result->fetch_assoc())//取出结果并显示
		{
			$list[] = $result_array;
		}	

		echo json_encode($list);
				
		$mysqli->close();
?>