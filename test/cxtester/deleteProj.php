<?php
/*	@include_once('conToMysqli.php');
	$id = $_POST['id'];
	$testerid=$_POST['testerid'];
		
	$queryDelP="delete from testerinprojects where id='$id' ;";//构建删除语句	

	if(mysqli_query($mysqli, $queryDelP)){
		$querySelT="select * from testerinprojects where testerid='$testerid' and status=1;";//查询用户所有的进行中的项目
		$result=mysqli_query($mysqli, $querySelT);//执行查询语句
		$numProj= mysqli_num_rows($result);
		if($numProj==0){
			$queryUpdT="update testerinfo set status=0 where testerid='$testerid'";	//更新用户状态为可用
			mysqli_query($mysqli, $queryUpdT);	//执行更新语句
		}
	}
						
	mysqli_close($mysqli);									
*/

@include_once('conToMysql.php');
	$id = $_POST['id'];
	$testerid=$_POST['testerid'];
		
	$queryDelP="delete from testerinprojects where id='$id' ;";//构建删除语句	

	if(mysql_query($queryDelP,$connection)){
		$querySelT="select * from testerinprojects where testerid='$testerid' and status=1;";//查询用户所有的进行中的项目
		$result=mysql_query($querySelT);
		$numProj= mysql_num_rows($result);
		if($numProj==0){
			$queryUpdT="update testerinfo set status=0 where testerid='$testerid'";	//更新用户状态为可用
			mysql_query($queryUpdT);	//执行更新语句
		}
	}
	
	/* close connection */				
	mysql_close($connection);
?>