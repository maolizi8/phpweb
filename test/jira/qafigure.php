<?php
@include_once('conToJira.php');
	$action=$_GET['action'];
	$date=date("Y-m-d");
	$datestr=explode("-",$date);
	$year=$datestr[0];
	$month=$datestr[1];
	$day=$datestr[2];
	
	function sortArrByManyField(){
        $args = func_get_args();
        if(empty($args)){
            return null;
        }
        $arr = array_shift($args);
        if(!is_array($arr)){
            throw new Exception("第一个参数不为数组");
        }
        foreach($args as $key => $field){
            if(is_string($field)){
                $temp = array();
                foreach($arr as $index=> $val){
                    $temp[$index] = $val[$field];
                }
                $args[$key] = $temp;
            }
        }
        $args[] = &$arr;//引用值
        call_user_func_array('array_multisort',$args);
        return array_pop($args);
    }
	
	if ($action=="m") {
		$bugs="SELECT * FROM 
		(
		 SELECT DATE_FORMAT(CREATED, '%Y-%m') mont, count(id) total FROM jiraissue
		  WHERE issuetype = 1 
		  AND DATE_FORMAT(CREATED, '%Y-%m') >= '2016-01' 
		  GROUP BY mont 
		  ORDER BY mont DESC
		) a 
		LEFT JOIN
		   (
		    SELECT DATE_FORMAT(t.CREATED, '%Y-%m') monp, count(t.id) prdnum FROM jiraissue t 
		    WHERE t.issuetype = 1 
		    AND t.id IN
		    (SELECT issue FROM customfieldvalue 
		      WHERE CUSTOMFIELD = 12879 
		      AND STRINGVALUE IN
		       ( 11200, 10705, 10906, 10701, 10703, 10704, 10707, 10709, 10710, 10708, 10702 )) 
		    AND t.id IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 13116 AND STRINGVALUE = 10804 ) 
		    AND t.id IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 10124 AND STRINGVALUE = 10123 ) 
		    AND DATE_FORMAT(t.CREATED, '%Y-%m') >= '2016-01' 
		    AND ( t.RESOLUTION IN (1, 10000, 2, 4, 5) OR t.RESOLUTION IS NULL ) 
		    GROUP BY monp ORDER BY monp DESC 
		   ) b ON a.mont = b.monp 
		LEFT JOIN 
		   ( 
		   SELECT DATE_FORMAT(CREATED, '%Y-%m') monv, count(*) validnum FROM jiraissue
		   WHERE issuetype = 1 
		   AND DATE_FORMAT(CREATED, '%Y-%m') >= '2016-01' 
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   GROUP BY monv ORDER BY monv DESC 
		   ) c ON a.mont = c.monv";
	} elseif ($action=="q") {
		$bugs="SELECT * FROM 
		(
		 SELECT YEAR(CREATED)*10+((MONTH(CREATED)-1) DIV 3) +1 as quart, count(id) as total FROM jiraissue
		  WHERE issuetype = 1 
		  AND  DATE_FORMAT(CREATED,'%Y-%m')>='2016-01'
			group by quart
			ORDER BY quart DESC
		) a 
		LEFT JOIN
		   (
		    SELECT YEAR(CREATED)*10+((MONTH(CREATED)-1) DIV 3) +1 as quartp, count(t.id) prdnum FROM jiraissue t 
		    WHERE t.issuetype = 1 
		    AND t.id IN
		    (SELECT issue FROM customfieldvalue 
		      WHERE CUSTOMFIELD = 12879 
		      AND STRINGVALUE IN
		       ( 11200, 10705, 10906, 10701, 10703, 10704, 10707, 10709, 10710, 10708, 10702 )) 
		    AND t.id IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 13116 AND STRINGVALUE = 10804 ) 
		    AND t.id IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 10124 AND STRINGVALUE = 10123 ) 
		    AND DATE_FORMAT(t.CREATED, '%Y-%m') >= '2016-01' 
		    AND ( t.RESOLUTION IN (1, 10000, 2, 4, 5) OR t.RESOLUTION IS NULL ) 
		    GROUP BY quartp ORDER BY quartp DESC 
		   ) b ON a.quart = b.quartp 
		LEFT JOIN 
		   ( 
		   SELECT YEAR(CREATED)*10+((MONTH(CREATED)-1) DIV 3) +1 as quartv, count(*) validnum FROM jiraissue
		   WHERE issuetype = 1 
		   AND DATE_FORMAT(CREATED, '%Y-%m') >= '2016-01' 
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   GROUP BY quartv ORDER BY quartv DESC 
		   ) c ON a.quart = c.quartv";
	}elseif ($action=="y") {
		$bugs="SELECT * FROM 
		(
		 SELECT DATE_FORMAT(CREATED,'%Y')  as years, count(id) as total FROM jiraissue
		  WHERE issuetype = 1 
		  AND  DATE_FORMAT(CREATED,'%Y-%m')>='2016-01'
			group by years
			ORDER BY years DESC
		) a 
		LEFT JOIN
		   (
		    SELECT DATE_FORMAT(CREATED,'%Y')  as yearp, count(t.id) prdnum FROM jiraissue t 
		    WHERE t.issuetype = 1 
		    AND t.id IN
		    (SELECT issue FROM customfieldvalue 
		      WHERE CUSTOMFIELD = 12879 
		      AND STRINGVALUE IN
		       ( 11200, 10705, 10906, 10701, 10703, 10704, 10707, 10709, 10710, 10708, 10702 )) 
		    AND t.id IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 13116 AND STRINGVALUE = 10804 ) 
		    AND t.id IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 10124 AND STRINGVALUE = 10123 ) 
		    AND DATE_FORMAT(t.CREATED, '%Y-%m') >= '2016-01' 
		    AND ( t.RESOLUTION IN (1, 10000, 2, 4, 5) OR t.RESOLUTION IS NULL ) 
		    GROUP BY yearp ORDER BY yearp DESC 
		   ) b ON a.years = b.yearp 
		LEFT JOIN 
		   ( 
		   SELECT DATE_FORMAT(CREATED,'%Y')  as yearv, count(*) validnum FROM jiraissue
		   WHERE issuetype = 1 
		   AND DATE_FORMAT(CREATED, '%Y-%m') >= '2016-01' 
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   GROUP BY yearv ORDER BY yearv DESC 
		   ) c ON a.years = c.yearv";
	}elseif ($action=="tester") {
		$startdate=$_POST['startdate'];
		$enddate=$_POST['enddate'];
		$start=date("Y-m-d",strtotime($startdate));
		$end=date("Y-m-d",strtotime($enddate));
		$bugs="SELECT lower_user_name,display_name,IFNULL(total,0) as total,IFNULL(validnum,0) as validnum,
IFNULL(pzero,0) as pzero,IFNULL(pone,0) as pone,
IFNULL(ptwo,0) as ptwo,IFNULL(pthree,0) as pthree from
(
	SELECT DISTINCT ak.MEMBER_KEY as usera,au.lower_user_name,cu.display_name 
	FROM ao_aefed0_team_member_v2 ak,app_user au,cwd_user cu
	WHERE TEAM_ID=43
	AND ak.MEMBER_KEY=au.user_key
	AND au.lower_user_name=cu.lower_user_name
	AND ak.id in (SELECT TEAM_MEMBER_ID from ao_aefed0_membership)
	 ) a
LEFT JOIN 
		(
		 SELECT CREATOR as userb,COUNT(*) as total
		FROM jiraissue
		WHERE issuetype = 1 
		AND DATE_FORMAT(CREATED,'%Y-%m-%d')>='".$start."'
		AND DATE_FORMAT(CREATED,'%Y-%m-%d')<='".$end."'
		GROUP BY userb
		) b on a.usera=b.userb
		LEFT JOIN 
		   ( 
		   SELECT CREATOR as userc,COUNT(*) as validnum FROM jiraissue
		   WHERE issuetype = 1 
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')>='".$start."'
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')<='".$end."'
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   GROUP BY userc 
		   ) c ON a.usera = c.userc
		   LEFT JOIN 
		   ( 
		   SELECT CREATOR as userd,COUNT(*) as pzero FROM jiraissue
		   WHERE issuetype = 1 
				AND priority=1
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')>='".$start."'
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')<='".$end."'
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 13116 AND STRINGVALUE = 10804 ) 
		    AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 10124 AND STRINGVALUE = 10123 )
		   GROUP BY userd 
		   ) d ON a.usera = d.userd
LEFT JOIN 
		   ( 
		   SELECT CREATOR as usere,COUNT(*) as pone FROM jiraissue
		   WHERE issuetype = 1 
				AND priority=2
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')>='".$start."'
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')<='".$end."'
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 13116 AND STRINGVALUE = 10804 ) 
		    AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 10124 AND STRINGVALUE = 10123 )
		   GROUP BY usere 
		   ) e ON a.usera = e.usere
LEFT JOIN 
		   ( 
		   SELECT CREATOR as userf,COUNT(*) as ptwo FROM jiraissue
		   WHERE issuetype = 1 
				AND priority=3
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')>='".$start."'
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')<='".$end."'
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 13116 AND STRINGVALUE = 10804 ) 
		    AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 10124 AND STRINGVALUE = 10123 )
		   GROUP BY userf 
		   ) f ON a.usera = f.userf
LEFT JOIN 
		   ( 
		   SELECT CREATOR as userg,COUNT(*) as pthree FROM jiraissue
		   WHERE issuetype = 1 
				AND (priority=4 or priority=5)
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')>='".$start."'
				AND DATE_FORMAT(CREATED,'%Y-%m-%d')<='".$end."'
		   AND ( RESOLUTION IN (1, 10000, 2, 4, 5) OR RESOLUTION IS NULL ) 
		   AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 13116 AND STRINGVALUE = 10804 ) 
		    AND id NOT IN ( SELECT issue FROM customfieldvalue WHERE CUSTOMFIELD = 10124 AND STRINGVALUE = 10123 )
		   GROUP BY userg 
		   ) g ON a.usera = g.userg";
	}else{
		$bugs="";
	}
	
	$result=$conjira->query($bugs);
	while($result_array=$result->fetch_assoc())
	{
		$list[] = $result_array;
	}	
	if ($action=="tester") {
		foreach ($list as $key => $value) {
			if ($list[$key]['total']==0) {
				$validpercentage=0;
			} else {
				$validpercentage=(int)$list[$key]['validnum']/(int)$list[$key]['total'];
			}
			$list[$key]['validper']=(string)$validpercentage;
			$contribute=(int)$list[$key]['pzero']*4+(int)$list[$key]['pone']*2+(int)$list[$key]['ptwo']+(int)$list[$key]['pthree']*0.8;
			$list[$key]['contribute']=(string)$contribute;
			$list[$key]['time']=$date;
		}
	}
	
	echo json_encode($list);
			
	$conjira->close();
?>