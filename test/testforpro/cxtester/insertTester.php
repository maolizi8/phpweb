<?PHP
@include_once('conToMysql.php');		
	//$testerid = $_POST['testerid'];
	$name=$_POST['name'];
	$skill=$_POST['skill'];
	$jiraid=$_POST['jiraid'];
	
	$sql="insert into testerinfo (name,skill,status,jiraid) values('$name','$skill',0,'$jiraid')";//构建插入语句	
	
	if (!mysql_query($sql,$connection))
 		{
			die('Error: ' . mysql_error());
		}	

	mysql_close($connection);

?>