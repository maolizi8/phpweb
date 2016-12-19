<?php
$con = mysql_connect("localhost:3306", "root", "root");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("testlink", $con);
mysql_query('SET NAMES UTF8');
$result = mysql_query("SELECT * FROM testerinfo");
while($array = mysql_fetch_assoc($result)){

$list[] = $array;
}


// some code
echo json_encode($list);

mysql_close($con);
?>
