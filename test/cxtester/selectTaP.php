<?php
	@include_once('conToMysql.php');
	//$query="select testerinfo.name tname,testerinfo.status as tstatus,testerinfo.skill as tskill,testerinprojects.project as pproject,testerinprojects.starttime as pstart,testerinprojects.completetime as pcomplete,testerinprojects.status as pstatus from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid ";//构建查询语句
	$query="select  testerinfo.testerid as tid,testerinfo.name as tname,testerinfo.status as tstatus,testerinfo.skill as tskill,testerinprojects.id as pid,testerinprojects.project as pproject,testerinprojects.starttime as pstart,testerinprojects.completetime as pcomplete,testerinprojects.status as pstatus,testerinprojects.projmanager as pmanager,testerinprojects.department as pdepartm  from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid order by testerinfo.testerid";//查询出所有用户所有项目
	//$query="select * from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid order by testerinfo.testerid;";
	
	$result=mysql_query($query);//执行查询
	if(!$result)
	{
		die("could not to the database</br>".mysql_error());
	}

	//$result_array=mysql_fetch_array($result);
	while($result_array=mysql_fetch_assoc($result))//取出结果并显示
	{
		$list[] = $result_array;
	}

	echo json_encode($list);

	mysql_close($connection);
?>