<?php
@include_once('conToJira.php');

	$bugEnvir="SELECT jiraissue.PROJECT,project.pname,customfieldvalue.STRINGVALUE as stringval,customfieldvalue.CUSTOMFIELD AS customfieldid,COUNT(*) as sumenv from jiraissue
	LEFT JOIN customfieldvalue on jiraissue.ID=customfieldvalue.ISSUE
	LEFT JOIN project on  jiraissue.PROJECT=project.ID
	where jiraissue.issuetype=1 AND customfieldvalue.CUSTOMFIELD =10124
	GROUP BY jiraissue.PROJECT,customfieldvalue.STRINGVALUE
	ORDER BY PROJECT DESC";

	$result=$conjira->query($bugEnvir);
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