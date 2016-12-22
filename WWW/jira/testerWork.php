<?php
		
	function calWorkByTeamid($tid,$start,$end)
	{
		@include_once('conJira.php');
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
		$conjira->close();
		return $result_array['sumwork']; 		
	}
	
	function testerGroups($tid,$start,$end)
	{
		@include_once('conJira.php');
		$conn=new Jiraconn();
		$conjira=$conn->conToJira();
		$sql="SELECT a.MEMBER_KEY,b.TEAM_ID,c.sum from (
SELECT MEMBER_KEY,COUNT(TEAM_ID) as num from ao_aefed0_team_member_v2
WHERE TEAM_ID in (51,52,53,54,55,56,57,34)
GROUP BY MEMBER_KEY) a 
LEFT JOIN
(
SELECT MEMBER_KEY,TEAM_ID 
from ao_aefed0_team_member_v2
WHERE TEAM_ID in (51,52,53,54,55,56,57,34)
) b on a.MEMBER_KEY=b.MEMBER_KEY
LEFT JOIN
(
SELECT SUM(worklog.timeworked)as sum,worklog.UPDATEAUTHOR from worklog
WHERE UPDATEAUTHOR in 
	(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 WHERE TEAM_ID in (51,52,53,54,55,56,57,34) )
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='".$start."'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<='".$end."'
GROUP BY UPDATEAUTHOR
) c on a.MEMBER_KEY=c.UPDATEAUTHOR
where a.num>1";
		$result=$conjira->query($sql);
		while($userArray=$result->fetch_assoc())
		{
			$userList[] = $userArray;
		}
		$conjira->close();
		$reduce=0;
		foreach ($userList as $key => $value) {
			if ($tid==$value['TEAM_ID']) {
				$reduce+=$value['sum']/2;
			}else {
				$reduce+=0;
			}			
		} 
		return $reduce;
	}
	$startdate=$_POST['startdate'];
	$enddate=$_POST['enddate'];
	$timenow=$_POST['timenow'];
	$start=date("Y-m-d",strtotime($startdate));
	$end=date("Y-m-d",strtotime($enddate));
	$now=date("Y-m-d H:i:s",strtotime($timenow));
	$duriation=strval($start).'---'.strval($end);
	
//	$start=date("Y-m-d",strtotime("2016-12-04"));
//	$end=date("Y-m-d",strtotime("2016-12-24"));
	$easum=calWorkByTeamid(51,$start,$end)-testerGroups(51,$start,$end);
	$cssum=calWorkByTeamid(52,$start,$end)-testerGroups(52,$start,$end);
	$ucsum=calWorkByTeamid(53,$start,$end)-testerGroups(53,$start,$end);
	$cxjsum=calWorkByTeamid(54,$start,$end)-testerGroups(54,$start,$end);
	$ythsum=calWorkByTeamid(55,$start,$end)-testerGroups(55,$start,$end);
	$bpsum=calWorkByTeamid(56,$start,$end)-testerGroups(56,$start,$end);
	$fpsum=calWorkByTeamid(57,$start,$end)-testerGroups(57,$start,$end);
	$otsum=calWorkByTeamid(34,$start,$end)-testerGroups(34,$start,$end);	
		
	$list[]=array('duriation'=>$duriation,'easum' => $easum/3600,'cssum' =>  $cssum/3600,'ucsum' =>  $ucsum/3600,'cxjsum' =>  $cxjsum/3600,'ythsum' =>  $ythsum/3600,'bpsum' =>  $bpsum/3600,'fpsum' =>  $fpsum/3600,'otsum' =>  $otsum/3600,'created' =>$now );
	echo json_encode($list);
					
?>