<?php
	@include_once('conToMysql.php');
	$query="select testerinfo.name tname,testerinfo.status as tstatus,testerinfo.skill as tskill,testerinprojects.project as pproject,testerinprojects.starttime as pstart,testerinprojects.completetime as pcomplete,testerinprojects.status as pstatus from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid ";//构建查询语句
	$result=mysql_query($query);//执行查询
	if(!$result)
	{
		die("could not to the database</br>".mysql_error());
	}

//$result_array=mysql_fetch_array($result);

//		echo "
//		<html>
//		";
//		echo "
//		<head>
//		";
//		echo "
//		<meta charset='UTF-8'>
//		";
//		echo "
//		<title>
//		测试资源管理
//		</title>";
//		echo "
//		</head>";
//		echo "
//		<body>
//		";
//		echo "
//		<h2 align='center'>
//		测试资源管理
//		</h2>	"
//	;
//		echo "
//		<table border='1' >
//		<tr>
//		<th>姓名</th>
//		<th>状态</th>
//		<th>已计划项目</th>
//		<th>开始时间</th>
//		<th>结束时间</th>
//		<th>技能</th>
//		</tr>";

while($result_array=mysql_fetch_assoc($result))//取出结果并显示
{
	$list[] = $result_array;
	
//	$tname=$result_array["tname"];
//	$tstatus=$result_array["tstatus"];
//	$pproject=$result_array["pproject"];
//	$pstart=$result_array["pstart"];
//	$pcomplete=$result_array["pcomplete"];
//	$tskill=$result_array["tskill"];
//	echo "<tr>";
//	echo "<td>$tname</td>";
//	echo "<td>$tstatus</td>";
//	echo "<td>$pproject</td>";
//	echo "<td>$pstart</td>";
//	echo "<td>$pcomplete</td>";
//	echo "<td>$tskill</td>";	
//	echo "</tr>";
}

echo json_encode($list);

//echo "</table>
//	</body>
//	</html>";

mysql_close($connection);
?>