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
$query1="select * from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid ";//构建查询语句
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

while($result_row=mysql_fetch_row(($result)))//取出结果并显示
{
	$name=$result_row[1];
	$status=$result_row[2];
	$project=$result_row[6];
	$starttime=$result_row[7];
	$completetime=$result_row[8];
	$skill=$result_row[3];
	echo "<tr>";
	echo "<td>$name</td>";
	echo "<td>$status</td>";
	echo "<td>$project</td>";
	echo "<td>$starttime</td>";
	echo "<td>$completetime</td>";
	echo "<td>$skill</td>";	
	echo "</tr>";
}

echo "</table>
	</body>
	</html>";
?>