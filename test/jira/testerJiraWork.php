<?php
	@include_once('conJira.php');
	$action=$_GET['action'];
	
	$startdate=$_POST['startdate'];
	$enddate=$_POST['enddate'];
	$start=date("Y-m-d",strtotime($startdate));
	$end=date("Y-m-d",strtotime($enddate));
	//$timenow=$_POST['timenow'];
	//$now=date("Y-m-d H:i:s",strtotime($timenow));
	//$duriation=strval($start).'---'.strval($end);
		$conn=new Jiraconn();
		$conjira=$conn->conToJira();
		if ($action=='d') {
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
	WHERE TEAM_ID=43
	AND id in (SELECT TEAM_MEMBER_ID from ao_aefed0_membership)
	)) a 
LEFT JOIN
(
select n.SOURCE_NODE_ID,n.SINK_NODE_ID,c.cname
from nodeassociation n,projectcategory c
where n.SINK_NODE_ID=c.id
AND n.ASSOCIATION_TYPE='ProjectCategory'
) b ON a.PROJECT=b.SOURCE_NODE_ID
GROUP BY b.SINK_NODE_ID,a.UPDATEAUTHOR
ORDER BY b.cname";
		}elseif ($action=='c') {
			$sql="SELECT b.SINK_NODE_ID,b.cname,SUM(a.timeworked) as sum FROM
(SELECT j.PROJECT,w.UPDATEAUTHOR,w.timeworked,w.STARTDATE
FROM worklog w,jiraissue j
WHERE w.issueid=j.ID
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')>='".$start."'
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')<='".$end."'
AND w.UPDATEAUTHOR in
 (SELECT DISTINCT MEMBER_KEY FROM ao_aefed0_team_member_v2
	WHERE TEAM_ID=43
	AND id in (SELECT TEAM_MEMBER_ID from ao_aefed0_membership)
	)) a 
LEFT JOIN
(
select n.SOURCE_NODE_ID,n.SINK_NODE_ID,c.cname
from nodeassociation n,projectcategory c
where n.SINK_NODE_ID=c.id
AND n.ASSOCIATION_TYPE='ProjectCategory'
) b ON a.PROJECT=b.SOURCE_NODE_ID
GROUP BY b.SINK_NODE_ID
ORDER BY b.cname";
	}elseif ($action=='t') {
		$sql="SELECT * from
(SELECT DISTINCT u.MEMBER_KEY,cu.display_name,au.lower_user_name
 FROM ao_aefed0_team_member_v2 u,app_user au,cwd_user cu
	WHERE u.TEAM_ID=43
	AND u.MEMBER_KEY=au.user_key
	AND au.lower_user_name=cu.lower_user_name
	AND u.id in (SELECT TEAM_MEMBER_ID from ao_aefed0_membership)
) a
LEFT JOIN
(
SELECT w.UPDATEAUTHOR,sum(w.timeworked) as sumwork
FROM worklog w
WHERE 
DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')<='2016-12-10'
AND w.UPDATEAUTHOR in
(SELECT DISTINCT MEMBER_KEY FROM ao_aefed0_team_member_v2
	WHERE TEAM_ID=43)
GROUP BY w.UPDATEAUTHOR
) b on a.MEMBER_KEY=b.UPDATEAUTHOR";
	}else {
			$sql="";
		}
			
	
	$result=$conjira->query($sql);
		
	$conjira->close();
		while($result_array=$result->fetch_assoc())
		{
			$list[] = $result_array;
		}
		echo json_encode($list);
				
	//$conjira->close();							
?>