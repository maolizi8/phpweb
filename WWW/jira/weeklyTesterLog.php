<?php
@include_once('conToJira.php');
	
	$sql="SELECT weekflg,CONCAT(monday,'---',sunday) as duriation,easum,cssum,ucsum,cxjsum,ythsum,bpsum,fpsum,otsum  FROM
(
select YEARWEEK(w.STARTDATE) as weekflg,DATE(w.STARTDATE) as day,
	subdate(DATE(w.STARTDATE),weekday(DATE(w.STARTDATE))) as monday,
	subdate(DATE(w.STARTDATE),weekday(DATE(w.STARTDATE))-6) as sunday
from worklog w
where DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(w.STARTDATE,'%Y-%m-%d')<=NOW()
GROUP BY weekflg
) a 
LEFT JOIN
(
select YEARWEEK(STARTDATE) as eaweek,sum(timeworked) as easum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=51)
GROUP BY eaweek
) ea on a.weekflg=ea.eaweek
LEFT JOIN
(
select YEARWEEK(STARTDATE) as csweek,sum(timeworked) as cssum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=52)
GROUP BY csweek
) cs on a.weekflg=cs.csweek
LEFT JOIN
(
select YEARWEEK(STARTDATE) as ucweek,sum(timeworked) as ucsum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=53)
GROUP BY ucweek
) uc on a.weekflg=uc.ucweek
LEFT JOIN
(
select YEARWEEK(STARTDATE) as cxjweek,sum(timeworked) as cxjsum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=54)
GROUP BY cxjweek
) cxj on a.weekflg=cxj.cxjweek
LEFT JOIN
(
select YEARWEEK(STARTDATE) as ythweek,sum(timeworked) as ythsum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=55)
GROUP BY ythweek
) yth on a.weekflg=yth.ythweek
LEFT JOIN
(
select YEARWEEK(STARTDATE) as bpweek,sum(timeworked) as bpsum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=56)
GROUP BY bpweek
) bp on a.weekflg=bp.bpweek
LEFT JOIN
(
select YEARWEEK(STARTDATE) as fpweek,sum(timeworked) as fpsum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=57)
GROUP BY fpweek
) fp on a.weekflg=fp.fpweek
LEFT JOIN
(
select YEARWEEK(STARTDATE) as otweek,sum(timeworked) as otsum
from worklog
where DATE_FORMAT(STARTDATE,'%Y-%m-%d')>='2016-12-04'
AND DATE_FORMAT(STARTDATE,'%Y-%m-%d')<=NOW()
AND UPDATEAUTHOR in
(SELECT MEMBER_KEY from ao_aefed0_team_member_v2 where TEAM_ID=34)
GROUP BY otweek
) ot on a.weekflg=ot.otweek";

	$result=$conjira->query($sql);
	while($result_array=$result->fetch_assoc())
	{
		$list[] = $result_array;
	}	
	//echo json_encode($list);

	$users="SELECT a.MEMBER_KEY,b.TEAM_ID from (
SELECT MEMBER_KEY,COUNT(TEAM_ID) as num from ao_aefed0_team_member_v2
WHERE TEAM_ID in (51,52,53,54,55,56,57,34)
GROUP BY MEMBER_KEY) a 
LEFT JOIN
(
SELECT MEMBER_KEY,TEAM_ID 
from ao_aefed0_team_member_v2
WHERE TEAM_ID in (51,52,53,54,55,56,57,34)
) b on a.MEMBER_KEY=b.MEMBER_KEY
where a.num>1";
	$userResult=$conjira->query($users);
	while($userArray=$userResult->fetch_assoc())
	{
		$userList[] = $userArray;
	}
	
	
	//echo $userArray['MEMBER_KEY'];
	//echo sizeof($list);
	foreach ($userList as $key => $value) {
		foreach ($value as $k => $v) {
			echo $k."=>".$v."<br />";
		}
		echo "<hr />";
	}

			
	$conjira->close();
?>