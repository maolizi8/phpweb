<?php
	@include_once('conJira.php');
	
	$projid=$_POST['projid'];
	$startdate=$_POST['startdate'];
	$enddate=$_POST['enddate'];
	$start=date("Y-m-d",strtotime($startdate));
	$end=date("Y-m-d",strtotime($enddate));
	//$timenow=$_POST['timenow'];
	//$now=date("Y-m-d H:i:s",strtotime($timenow));
	//$duriation=strval($start).'---'.strval($end);
	
	$conn=new Jiraconn();
	$conjira=$conn->conToJira();
		
	$sql="SELECT j.PROJECT,p.pname,sum(w.timeworked) as sumproj
FROM worklog w,jiraissue j,project p
WHERE w.issueid=j.ID
AND j.project=p.id
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')>='".$start."'
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')<='".$end."'
	AND j.project=$projid
AND w.UPDATEAUTHOR in
 (SELECT DISTINCT MEMBER_KEY FROM ao_aefed0_team_member_v2
	WHERE TEAM_ID=43)";
						
	$result=$conjira->query($sql);
		
	$conjira->close();
		while($result_array=$result->fetch_assoc())
		{
			$list[] = $result_array;
		}
		echo json_encode($list);											
?>