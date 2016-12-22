<?php
//@require_once('conToMysql.php');
@include_once('conToMysqli.php');
	
	$testerid = $_POST['testerid'];
	$name=$_POST['name'];
	$skill=$_POST['skill'];
	$jiraid=$_POST['jiraid'];	
	$day=date("Y-m-d");	
	
	$updateTester="update testerinfo set name='$name',skill='$skill',updatetime='$day',jiraid='$jiraid' where testerid='$testerid';";
	mysqli_query($mysqli,$updateTester);
		
	/* close connection */				
	mysqli_close($mysqli);	

?>