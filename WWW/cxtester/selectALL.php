<?php
	@include_once('conToMysql.php');
	
		if($_GET['action'] == 'projects'){
			$testerid = $_POST['testerid'];
			$query="select * from testerinprojects where testerid='$testerid'";//构建查询语句		
		}
		if ($_GET['action'] =='tester') {
			$query="select * from testerinfo ";//构建查询语句							
		}		

		$result=mysql_query($query);//执行查询
		if(!$result)
		{
			die("could not to the database</br>".mysql_error());
		}

		while($result_array=mysql_fetch_assoc($result))//取出结果并显示//$result_array=mysql_fetch_array($result);
		{
			$list[] = $result_array;
		}	
		
		if(empty($list)){	
			$list=array(array("id"=>"0","testerid"=>"0"));			
			echo json_encode($list);
		}else{
			echo json_encode($list);
		}
		
		
	mysql_close($connection);
?>