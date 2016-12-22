<?php
//@include('conJira.php');
@include_once('conJira.php');
	$tid=51;
	$start=date("Y-m-d",strtotime("2016-12-04"));
	$end=date("Y-m-d",strtotime("2016-12-24"));

$conn=new Jiraconn();
$conjira=$conn->conToJira();
$sql="select sum(w.timeworked) as sumwork
from worklog w
where 
DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')>='".$start."'
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')<='".$end."'
AND w.UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=$tid)";
		$result=$conjira->query($sql);
		$result_array=$result->fetch_assoc();
		echo $result_array['sumwork']; 
		$conjira->close();
?>