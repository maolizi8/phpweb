<?php
	@include_once('conToMysql.php');		
		if($_GET['action'] == 'all'){
			$query="select * from testerinprojects";//查询所有的projects
		}else{
			$testerid = $_POST['testerid'];
			$query="select * from testerinprojects where testerid='$testerid'";//根据用户id查询	
			//$query="select * from testerinprojects where testerid=1";
		}
		
		$result=mysql_query($query);//执行查询
		if(!$result)
		{
			die("could not to the database</br>".mysql_error());
		}
		//echo $result;

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