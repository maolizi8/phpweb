<?php
@include_once('conToMysqli.php');
	
	$username=$_POST['username'];
	$password=$_POST['password'];
//	$username="tester";
//	$password="tester";
	$role="0";
	$sql="select role from users where username='".$username."' and password='".$password."'";
	$result=mysqli_query($mysqli,$sql);
	if (mysqli_num_rows($result)>0) {
		$row=mysqli_fetch_array($result,MYSQLI_NUM);
		$role=$row[0];
	}else {
		$role="0";
	}
	$list=array('role' => $role);
	echo json_encode($list);
	mysqli_close($mysqli);		
?>