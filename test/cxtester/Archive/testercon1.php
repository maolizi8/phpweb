<?php
	
$db_host='localhost:3306';
$db_username='root';
$db_password='';
$connection=mysql_connect($db_host,$db_username,$db_password);//连接到数据库
$db_database='testlink';

mysql_query("set names 'utf8'");//编码转化
if(!$connection)
{
	die("could not connect to the database:</br>".mysql_error());//诊断连接错误
}
	
$db_selecct=mysql_select_db($db_database);//选择数据库
if(!$db_selecct)
{
	die("could not to the database</br>".mysql_error());
}
$query1="select testerinfo.name tname,testerinfo.status as tstatus,testerinfo.skill as tskill,testerinprojects.project as pproject,testerinprojects.starttime as pstart,testerinprojects.completetime as pcomplete,testerinprojects.status as pstatus from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid ";//构建查询语句
$result=mysql_query($query1);//执行查询
if(!$result)
{
	die("could not to the database</br>".mysql_error());
}

echo "<html>";
echo "	<head>";
echo "		<meta charset='UTF-8'>";
echo "		<title>测试资源管理</title>";
echo "	</head>";
echo "	<body>";
echo "	<h2 align='center'>测试资源管理</h2>	";
echo "<table border='1' >
	<tr>
	<th>姓名</th>
	<th>状态</th>
	<th>已计划项目</th>
	<th>开始时间</th>
	<th>结束时间</th>
	<th>技能</th>
	</tr>";
//$result_row=mysql_fetch_array(($result));
//echo "$result_row";

while($result_array=mysql_fetch_array(($result)))//取出结果并显示
{
	$tname=$result_array["tname"];
	$tstatus=$result_array["tstatus"];
	$pproject=$result_array["pproject"];
	$pstart=$result_array["pstart"];
	$pcomplete=$result_array["pcomplete"];
	$tskill=$result_array["tskill"];
	echo "<tr>";
	echo "<td>$tname</td>";
	echo "<td>$tstatus</td>";
	echo "<td>$pproject</td>";
	echo "<td>$pstart</td>";
	echo "<td>$pcomplete</td>";
	echo "<td>$tskill</td>";	
	echo "</tr>";
}

echo "</table>
	</body>
	</html>";
?>