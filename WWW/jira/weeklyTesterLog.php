<?php
@include_once('conToJira.php');
	$projCategory="select ID,cname from projectcategory";
	
	$sql="select YEARWEEK(w.STARTDATE) as weekflg,sum(w.timeworked) as sumwork,DATE(w.STARTDATE) as day,
	subdate(DATE(w.STARTDATE),weekday(DATE(w.STARTDATE))) as monday,
	subdate(DATE(w.STARTDATE),weekday(DATE(w.STARTDATE))-6) as sunday	
from worklog w
where  
DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')>='2016-09-28'
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')<=NOW()
AND w.issueid in 
(SELECT id from jiraissue 
	where PROJECT in 
	(select nodeassociation.SOURCE_NODE_ID from nodeassociation 
		where nodeassociation.ASSOCIATION_TYPE='ProjectCategory'
		AND nodeassociation.SINK_NODE_ID=10202)
)
GROUP BY weekflg";
	$result=$conjira->query($sql);
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