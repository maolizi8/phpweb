<?php
	//@include_once('conToMysql.php');
	@include_once('conToMysqli.php');
		//$query="select count(*) from testerinprojects where testerid=1";
		$query="select * from testerinprojects where testerid=1 and status=1";
//		$result=mysql_query($query);//执行查询
//		if(!$result)
//		{
//			die("could not to the database</br>".mysql_error());
//		}
		
	//echo mysql_num_rows($result);
		
	//mysql_close($connection);
	
	//mysqli_query($mysqli,$query);
	$result=mysqli_query($mysqli,$query);
	$num=mysqli_num_rows($result);
	echo "有进行中的项目个数: ".$num;
	echo "<br />";
	if($num==0){
		$queryAll="select * from testerinprojects where testerid=1";
		$resultAll=mysqli_query($mysqli,$queryAll);
		echo "项目个数: ".mysqli_num_rows($resultAll);
	}
	/* close connection */				
	$mysqli->close();	
						
?>