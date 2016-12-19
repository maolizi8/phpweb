<?php
@include_once('conToJira.php');
	//总数
	$bugTotal="select PROJECT,count(*) from jiraissue where issuetype=1 group by PROJECT";
//	
//	$sql="
//	(select PROJECT,PRIORITY,count(*) as prio from jiraissue where issuetype=1 group by PROJECT,PRIORITY) bugprio 
//	(select PROJECT,count(*) as total from jiraissue where issuetype=1 group by PROJECT) bugall 
//	";
//	
//	$query="select project.ID as ID,project.pname as pname,COUNT(*) as total from project 
//	left join jiraissue on project.ID=jiraissue.PROJECT  
//	WHERE jiraissue.issuetype=1 
//	GROUP BY project.ID,project.pname 
//	order by project.ID DESC";
	
	//bug根源
	$bugCause="SELECT jiraissue.PROJECT,customfieldvalue.STRINGVALUE,customfieldvalue.CUSTOMFIELD,COUNT(*) from jiraissue 
	LEFT JOIN customfieldvalue on jiraissue.ID=customfieldvalue.ISSUE
	where jiraissue.issuetype=1 AND customfieldvalue.CUSTOMFIELD=12879
	GROUP BY jiraissue.PROJECT,customfieldvalue.STRINGVALUE";
	
	//bug发现阶段
	$bugPhase="SELECT jiraissue.PROJECT,customfieldvalue.STRINGVALUE,customfieldvalue.CUSTOMFIELD,COUNT(*) from jiraissue 
	LEFT JOIN customfieldvalue on jiraissue.ID=customfieldvalue.ISSUE
	where jiraissue.issuetype=1 AND customfieldvalue.CUSTOMFIELD=13116
	GROUP BY jiraissue.PROJECT,customfieldvalue.STRINGVALUE";
	
	//bug类别
	$bugCategory="SELECT jiraissue.PROJECT,customfieldvalue.STRINGVALUE,customfieldvalue.CUSTOMFIELD,COUNT(*) from jiraissue 
	LEFT JOIN customfieldvalue on jiraissue.ID=customfieldvalue.ISSUE
	where jiraissue.issuetype=1 AND customfieldvalue.CUSTOMFIELD in (13116,12879)
	GROUP BY jiraissue.PROJECT,customfieldvalue.STRINGVALUE";
	
	//显示出汉字名称
	$bug="SELECT * from 
	(SELECT jiraissue.PROJECT,project.pname,customfieldvalue.STRINGVALUE as stringval,customfieldvalue.CUSTOMFIELD AS customfieldid,COUNT(*) from jiraissue
	LEFT JOIN customfieldvalue on jiraissue.ID=customfieldvalue.ISSUE
	LEFT JOIN project on  jiraissue.PROJECT=project.ID
	where jiraissue.issuetype=1 AND customfieldvalue.CUSTOMFIELD in (13116,12879)
	GROUP BY jiraissue.PROJECT,customfieldvalue.STRINGVALUE) a
	LEFT JOIN customfieldoption on a.stringval =customfieldoption.ID
	ORDER BY PROJECT DESC";
	
	
	$result=$conjira->query($bug);
	if(!$result)
		{
			die("could not to the database</br>".$conjira->error());
		}

		while($result_array=$result->fetch_assoc())
		{
			$list[] = $result_array;
		}	

		echo json_encode($list);
		
//		$result_field=$result->fetch_fields();
//		foreach ($result_field as $val)
//	{
//		printf("字段名: %s",$val->name);
//		echo "<br>";
//		printf("数据表: %s",$val->table);
//		echo "<br>";
//		printf("最大长度: %d",$val->max_length);
//		echo "<br>";
//	}


				
		$conjira->close();

?>