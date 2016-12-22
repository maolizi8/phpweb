<?php
	@include_once('conJira.php');
	$startdate=$_POST['startdate'];
	$enddate=$_POST['enddate'];
	$start=date("Y-m-d",strtotime($startdate));
	$end=date("Y-m-d",strtotime($enddate));
	//$timenow=$_POST['timenow'];
	//$now=date("Y-m-d H:i:s",strtotime($timenow));
	//$duriation=strval($start).'---'.strval($end);
		$conn=new Jiraconn();
		$conjira=$conn->conToJira();	
	$sql="SELECT a.UPDATEAUTHOR,a.lower_user_name,a.display_name,b.SINK_NODE_ID,b.cname,SUM(a.timeworked) as sum FROM
(SELECT w.UPDATEAUTHOR,j.PROJECT,w.timeworked,au.lower_user_name,cu.display_name
FROM worklog w,jiraissue j,app_user au,cwd_user cu
WHERE w.issueid=j.ID
AND w.UPDATEAUTHOR=au.user_key
AND au.lower_user_name=cu.lower_user_name
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')>='".$start."'
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')<='".$end."'
AND w.UPDATEAUTHOR in
 (SELECT DISTINCT MEMBER_KEY FROM ao_aefed0_team_member_v2
	WHERE TEAM_ID in (51,52,53,54,55,56,57,34))) a 
LEFT JOIN
(
select n.SOURCE_NODE_ID,n.SINK_NODE_ID,c.cname
from nodeassociation n,projectcategory c
where n.SINK_NODE_ID=c.id
AND n.ASSOCIATION_TYPE='ProjectCategory'
) b ON a.PROJECT=b.SOURCE_NODE_ID
GROUP BY b.SINK_NODE_ID,a.UPDATEAUTHOR
ORDER BY a.UPDATEAUTHOR";
	$result=$conjira->query($sql);
		
	$conjira->close();
		while($result_array=$result->fetch_assoc())
		{
			$list[] = $result_array;
		}
		echo json_encode($list);
				
	//$conjira->close();							
?>