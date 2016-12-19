<?php
$con = mysql_connect("localhost:3306","root","lixia9");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("test", $con);
  mysql_query('SET NAMES UTF8');  
  $result = mysql_query("SELECT * FROM test");
// some code
echo '
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>戈秋力第一课</title>
	</head>
	<body>
	';
	while($row = mysql_fetch_array($result))
	echo 'ID：'.$row['Id'].'姓名：'.$row['name'].'年龄：'. $row['age'].'<br/>';
echo	
	'</body>
</html>
';
mysql_close($con);
?>


