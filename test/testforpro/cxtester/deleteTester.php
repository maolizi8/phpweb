<?php
	@include_once('conToMysql.php');
		$testerid = $_POST['testerid'];
		$sql="delete from testerinfo where testerid='$testerid' ";	//删除用户	
										
		if (!mysql_query($sql,$connection))
 		{
			die('Error: ' . mysql_error());
		}else{
			$deleteProj="delete from testerinprojects where testerid='$testerid'";	//删除用户的项目
			mysql_query($deleteProj);
		}
				
		mysql_close($connection);
?>