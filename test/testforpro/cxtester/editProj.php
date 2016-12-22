<?php
//@require_once('conToMysqli.php');
@include_once('conToMysqli.php');
	$id=$_POST['id'];
	$testerid = $_POST['testerid'];
	$project=$_POST['project'];
	$starttime=$_POST['starttime'];
	$completetime=$_POST['completetime'];
	
	$day=date("Y-m-d");		
	$start=date("Y-m-d",strtotime($starttime));
	$complete=date("Y-m-d",strtotime($completetime));
	
	if($start>$day){
		$status=0;
	}else if($start<=$day && $complete>=$day){
		$status=1;
	}else{
		$status=2;
	}
	
	$projmanager=$_POST['projmanager'];
	$department=$_POST['department'];
			
	$updateProj="update testerinprojects set project='$project',starttime='$starttime',completetime='$completetime',projmanager='$projmanager',status='$status',department='$department',updatetime='$day' where id='$id';";
	//$done=mysqli_query($mysqli,$updateProj);
	
	if(mysqli_query($mysqli,$updateProj)){
		$querySelT="select * from testerinprojects where testerid='$testerid' and status=1;";//查询用户所有的进行中的项目
		$result=mysqli_query($mysqli, $querySelT);//执行查询语句
		$numProj= mysqli_num_rows($result);	//获取用户的进行中项目的个数
	
		if($numProj==0){
			$queryUpdT="update testerinfo set status=0 where testerid='$testerid'";	//更新用户状态为可用
			mysqli_query($mysqli, $queryUpdT);	//执行更新语句
		}else{
			$queryUpdT="update testerinfo set status=1 where testerid='$testerid'";	//更新用户状态为锁定
			mysqli_query($mysqli, $queryUpdT);	//执行更新语句
		}
	
	}else{
		echo "update fail";
	}
	
	
	
	
	/* close connection */				
	mysqli_close($mysqli);	

?>