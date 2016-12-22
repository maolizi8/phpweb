
<?php
/*(c) Copyright 2016 geqiuli. All Rights Reserved. 
 * name：updateTesterStatus
 * 自动更新用户状态：
 * 1.先自动更新项目状态——updateProjStatus.php
 * 2.用户存在状态为进行中的项目，则用户状态为锁定；否则为可用。
*/

@include_once('conToMysqli.php');
	
	$query="select * from testerinfo";	//查询所有的projects
	$result=mysqli_query($mysqli,$query);	//执行查询
		
	$array=mysqli_fetch_all($result, MYSQLI_ASSOC);	// 获取数据
	
	$day=date("Y-m-d");	
	
	
	while(list($key,$value)=each($array)){	
		
		$testerid=$value['testerid'];
		$status=$value['status'];
		
		$querySelT="select * from testerinprojects where testerid='$testerid' and status=1;";//查询用户所有的进行中的项目
		$resultSelT=mysqli_query($mysqli, $querySelT);//执行查询语句
		$numProj= mysqli_num_rows($resultSelT);
		echo "testerid=".$value['testerid']." status=".$value['status']." number=".$numProj;

		if($numProj==0 && $status!=0){
			echo " update to 0 <br>";
			//更新用户状态为可用
			$queryUpdT="update testerinfo set status=0,updatetime='$day' where testerid='$testerid'";	
			mysqli_query($mysqli, $queryUpdT);	
		}else if($numProj!=0 && $status!=1){
			echo " update to 1 <br>";
			//更新用户状态为锁定
			$queryUpdT="update testerinfo set status=1,updatetime='$day' where testerid='$testerid'";	
			mysqli_query($mysqli, $queryUpdT);	
		}else{
			echo " no update"."<br> ";	
		}
	}
	
	mysqli_free_result($result);// 释放结果集
		
	mysqli_close($mysqli);	
?>