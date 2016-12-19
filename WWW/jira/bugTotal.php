<?php
@include_once('conToJira.php');
	//总数
	//$bugTotal="select PROJECT,count(*) from jiraissue where issuetype=1 group by PROJECT";
	$bugTotal="select project.ID as ID,project.pname as pname,COUNT(*) as total from project 
	left join jiraissue on project.ID=jiraissue.PROJECT  
	WHERE jiraissue.issuetype=1 
	GROUP BY project.ID,project.pname 
	order by project.ID DESC";
	
	$result=$conjira->query($bugTotal);
	if(!$result)
	{
		die("could not to the database</br>".$conjira->error());
	}

	while($result_array=$result->fetch_assoc())
	{
		$list[] = $result_array;
	}	

	echo json_encode($list);
		
	
	$conjira->close();
?>