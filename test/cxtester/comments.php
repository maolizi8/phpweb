<?php
@include_once('conToMysql.php');
	$action=$_GET['action'];		
	$day=date("Y-m-d H:i:s");	
	
	if ($action=='add') {
		$commbody=$_POST['commbody'];
		$sql="insert into comments (commbody,created) values('$commbody','$day')";	
		mysql_query($sql,$connection);
	} elseif ($action=='search') {
		$sql="select id,commbody,created from comments";
		mysql_query($sql,$connection);
		$result=mysql_query($sql,$connection);
		while($result_array=mysql_fetch_assoc($result))
		{
			$list[] = $result_array;
		}
		$jsonOut=json_encode($list);
		echo $jsonOut;
	}elseif ($action=='delete')  {
		$id=$_GET['id'];
		$sql="delete from comments where id='$id'";
		mysql_query($sql,$connection);		
	}else{
		$sql="";
	}
	

	mysql_close($connection);

?>