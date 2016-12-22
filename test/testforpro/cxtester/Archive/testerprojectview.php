<?php

echo "<html>
	<head>
		<meta charset="UTF-8">
		<title>测试资源管理</title>
	</head>
	<body>
	<h2 align="center">测试资源管理</h2>	";
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
	$project=$result_row[3];
	$starttime=$result_row[4];
	$completetime=$result_row[5];
	$skill=$result_row[6];
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