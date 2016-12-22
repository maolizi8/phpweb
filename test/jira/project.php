<?php
@include_once('conToJira.php');
	$query="select * from project";
	$result=$conjira->query($query);
	if(!$result)
		{
			die("could not to the database</br>".$conjira->error());
		}

		while($result_array=$result->fetch_assoc())//取出结果并显示
		{
			$list[] = $result_array;
		}	

		echo json_encode($list);
				
		$conjira->close();
?>