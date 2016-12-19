<?php
@include_once('conToJira.php');
	
	$issuefilter=" ";
	
	if ($_GET['startdate']!=null) {
		$startdate=date("Y-m-d",strtotime($_GET['startdate']));
		echo $startdate."<br />";
		$issuefilter.=" AND DATE_FORMAT(jiraissue.CREATED,'%Y-%m-%d')>='".$startdate."' ";
	}
	
	$bugMain="SELECT * FROM jiraissue 
	WHERE jiraissue.issuetype=1 and jiraissue.project=12600 ".$issuefilter." ";
	$result=$conjira->query($bugMain);
	if(!$result)
	{
		die("could not to the database</br>".$conjira->error());
	}

	while($result_array=$result->fetch_assoc())
	{
		$list[] = $result_array;
	}	
	
	echo "num=".mysqli_num_rows($result)."<br />";
	echo json_encode($list);
		
	
	$conjira->close();
?>