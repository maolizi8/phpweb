
<?php
/*(c) Copyright 2016 geqiuli. All Rights Reserved.
 * name：updateProjStatus 
 * 自动更新项目状态：
 * 1.当日时间小于项目的开始时间，则项目状态为未开始；
 * 2.当日时间介于项目的开始时间和结束时间之前，则项目状态为进行中；
 * 3.当日时间大于项目的结束时间，则项目状态为已结束；
 * 执行完后更新用户状态——updateTesterStatus.php
*/

@include_once('conToMysqli.php');
	$query="select * from testerinprojects";	//查询所有的projects
	$result=mysqli_query($mysqli,$query);	//执行查询
		
	$array=mysqli_fetch_all($result, MYSQLI_ASSOC);	// 获取数据
	$day=date("Y-m-d");	
	echo $day."<br> ";
	
	//遍历关联数组，判断时间以确定项目状态；
	while(list($key,$value)=each($array)){	
		//echo "id=".$value['id']." start=".$value['starttime']." complete=".$value['completetime']." status=".$value['status'];
		$id=$value['id'];
		echo $id;
		$start=date("Y-m-d",strtotime($value['starttime']));
		$complete=date("Y-m-d",strtotime($value['completetime']));
		$status=$value['status'];
	
		if($complete<$day && $value['status']!=2){
			echo " update to 2"."<br> ";
			//$status=2;	
			//$update="update testerinprojects set status='$status',updatetime='$day' where id='$id'";
			$update="update testerinprojects set status=2,updatetime='$day' where id='$id'";
			mysqli_query($mysqli,$update);			
		}else if($start<=$day && $complete>=$day && $value['status']!=1){
			echo " update to 1"."<br> ";	
			//$status=1;	
			//$update="update testerinprojects set status='$status',updatetime='$day' where id='$id'";
			$update="update testerinprojects set status=1,updatetime='$day' where id='$id'";
			mysqli_query($mysqli,$update);	
		}else if($start>$day && $value['status']!=0){
			echo " update to 0"."<br> ";	
			//$status=0;	
			//$update="update testerinprojects set status='$status',updatetime='$day' where id='$id'";
			$update="update testerinprojects set status=0,updatetime='$day' where id='$id'";
			mysqli_query($mysqli,$update);	
		}else{
			
			echo " no update"."<br> ";		
		}
			
				
	}
	
	mysqli_free_result($result);// 释放结果集
		
	mysqli_close($mysqli);	
?>