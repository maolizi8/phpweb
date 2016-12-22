<?php
@include_once('conToJira.php');
	$action=$_GET['action'];
	$date=date("Y-m-d");
	$datestr=explode("-",$date);
	$year=$datestr[0];
	$month=$datestr[1];
	$day=$datestr[2];
	
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
	}else{
		$bugs="";
	}
	
	$result=$conjira->query($bugs);
	while($result_array=$result->fetch_assoc())
	{
		$list[] = $result_array;
	}	

	echo json_encode($list);
			
	$conjira->close();
?>