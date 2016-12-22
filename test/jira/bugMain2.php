<?php
@include_once('conToJira.php');
	
	if(!empty($_POST["projCheck"])){  
		$array=$_POST['projCheck'];
		$str=implode(",",$array);
			$bugMain="select * from
(select project.ID as PID,project.pname as pname,project.LEAD as leader,project.pkey as pkey,COUNT(*) as total from project 
	left join jiraissue on project.ID=jiraissue.PROJECT  
	WHERE jiraissue.issuetype=1 AND project.pname not LIKE '%关闭%' AND project.pname not LIKE '%未立项%' and  project.ID in ($str) 
	GROUP BY project.ID,project.pname ) aa
LEFT JOIN 
(SELECT pidx,COUNT(*) as sumprd from 
	(SELECT jiraissue.ID as issueid,jiraissue.PROJECT as pidx from jiraissue
		where jiraissue.issuetype=1) x 
	LEFT JOIN
	(SELECT customfieldvalue.ISSUE,customfieldvalue.customfield,customfieldvalue.stringvalue as prdphase from customfieldvalue 
	WHERE customfieldvalue.CUSTOMFIELD =13116 AND customfieldvalue.STRINGVALUE=10804 ) y
	ON x.issueid=y.issue
	LEFT JOIN
	(SELECT customfieldvalue.ISSUE,customfieldvalue.customfield,customfieldvalue.stringvalue as prdenv from customfieldvalue 
	WHERE customfieldvalue.CUSTOMFIELD =10124 AND customfieldvalue.STRINGVALUE=10123 ) z
	ON x.issueid=z.issue
	WHERE prdphase=10804 AND prdenv=10123
	GROUP BY pidx) bb on aa.PID=bb.pidx
LEFT JOIN 
(SELECT jiraissue.PROJECT as pidc,customfieldvalue.STRINGVALUE as pre,COUNT(*) as sumpre from jiraissue
	LEFT JOIN customfieldvalue on jiraissue.ID=customfieldvalue.ISSUE
	where jiraissue.issuetype=1 AND customfieldvalue.CUSTOMFIELD =10124 AND customfieldvalue.STRINGVALUE in (10121,10300)
	GROUP BY jiraissue.PROJECT) cc on aa.PID=cc.pidc
LEFT JOIN
(select jiraissue.PROJECT as pidd,count(*) as valid from jiraissue
	WHERE jiraissue.issuetype=1 AND (jiraissue.RESOLUTION not in (10100,3) OR jiraissue.RESOLUTION IS NULL)
	GROUP BY jiraissue.PROJECT) dd on aa.PID=dd.pidd
LEFT JOIN
(select jiraissue.PROJECT as pide,count(*) as notclosed from jiraissue
	WHERE jiraissue.issuetype=1 AND jiraissue.issuestatus <> 6
	GROUP BY jiraissue.PROJECT) ee on aa.PID=ee.pide
LEFT JOIN
(select jiraissue.PROJECT as pidf,count(*) as resolved from jiraissue
	WHERE jiraissue.issuetype=1 AND jiraissue.issuestatus =5
	GROUP BY jiraissue.PROJECT) ff on aa.PID=ff.pidf
LEFT JOIN
(select app_user.user_key,cwd_user.display_name as uname from app_user
	LEFT JOIN
	cwd_user on app_user.lower_user_name=cwd_user.lower_user_name) gg on aa.leader=gg.user_key
LEFT JOIN
(select nodeassociation.SOURCE_NODE_ID,nodeassociation.SINK_NODE_ID,projectcategory.cname from nodeassociation 
	LEFT JOIN projectcategory on nodeassociation.SINK_NODE_ID=projectcategory.ID
	where nodeassociation.ASSOCIATION_TYPE='ProjectCategory') hh on aa.PID=hh.SOURCE_NODE_ID
order by aa.PID DESC";
	}else {
			$bugMain="select * from
(select project.ID as PID,project.pname as pname,project.LEAD as leader,project.pkey as pkey,COUNT(*) as total from project 
	left join jiraissue on project.ID=jiraissue.PROJECT  
	WHERE jiraissue.issuetype=1 AND project.pname not LIKE '%关闭%' AND project.pname not LIKE '%未立项%' 
	GROUP BY project.ID,project.pname ) aa
LEFT JOIN 
(SELECT pidx,COUNT(*) as sumprd from 
	(SELECT jiraissue.ID as issueid,jiraissue.PROJECT as pidx from jiraissue
		where jiraissue.issuetype=1) x 
	LEFT JOIN
	(SELECT customfieldvalue.ISSUE,customfieldvalue.customfield,customfieldvalue.stringvalue as prdphase from customfieldvalue 
	WHERE customfieldvalue.CUSTOMFIELD =13116 AND customfieldvalue.STRINGVALUE=10804 ) y
	ON x.issueid=y.issue
	LEFT JOIN
	(SELECT customfieldvalue.ISSUE,customfieldvalue.customfield,customfieldvalue.stringvalue as prdenv from customfieldvalue 
	WHERE customfieldvalue.CUSTOMFIELD =10124 AND customfieldvalue.STRINGVALUE=10123 ) z
	ON x.issueid=z.issue
	WHERE prdphase=10804 AND prdenv=10123
	GROUP BY pidx) bb on aa.PID=bb.pidx
LEFT JOIN 
(SELECT jiraissue.PROJECT as pidc,customfieldvalue.STRINGVALUE as pre,COUNT(*) as sumpre from jiraissue
	LEFT JOIN customfieldvalue on jiraissue.ID=customfieldvalue.ISSUE
	where jiraissue.issuetype=1 AND customfieldvalue.CUSTOMFIELD =10124 AND customfieldvalue.STRINGVALUE in (10121,10300)
	GROUP BY jiraissue.PROJECT) cc on aa.PID=cc.pidc
LEFT JOIN
(select jiraissue.PROJECT as pidd,count(*) as valid from jiraissue
	WHERE jiraissue.issuetype=1 AND (jiraissue.RESOLUTION not in (10100,3) OR jiraissue.RESOLUTION IS NULL)
	GROUP BY jiraissue.PROJECT) dd on aa.PID=dd.pidd
LEFT JOIN
(select jiraissue.PROJECT as pide,count(*) as notclosed from jiraissue
	WHERE jiraissue.issuetype=1 AND jiraissue.issuestatus <> 6
	GROUP BY jiraissue.PROJECT) ee on aa.PID=ee.pide
LEFT JOIN
(select jiraissue.PROJECT as pidf,count(*) as resolved from jiraissue
	WHERE jiraissue.issuetype=1 AND jiraissue.issuestatus =5
	GROUP BY jiraissue.PROJECT) ff on aa.PID=ff.pidf
LEFT JOIN
(select app_user.user_key,cwd_user.display_name as uname from app_user
	LEFT JOIN
	cwd_user on app_user.lower_user_name=cwd_user.lower_user_name) gg on aa.leader=gg.user_key
LEFT JOIN
(select nodeassociation.SOURCE_NODE_ID,nodeassociation.SINK_NODE_ID,projectcategory.cname from nodeassociation 
	LEFT JOIN projectcategory on nodeassociation.SINK_NODE_ID=projectcategory.ID
	where nodeassociation.ASSOCIATION_TYPE='ProjectCategory') hh on aa.PID=hh.SOURCE_NODE_ID
order by aa.PID DESC";
	}
	



	$result=$conjira->query($bugMain);
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