<?php
@include_once('conToJira.php');
	$bugPRD="SELECT pid,COUNT(*) as product from 
(SELECT jiraissue.ID as issueid,jiraissue.PROJECT as pid from jiraissue
	where jiraissue.issuetype=1) a 
LEFT JOIN
(SELECT customfieldvalue.ISSUE,customfieldvalue.customfield,customfieldvalue.stringvalue as prdphase from customfieldvalue 
WHERE customfieldvalue.CUSTOMFIELD =13116 AND customfieldvalue.STRINGVALUE=10804 ) b
ON a.issueid=b.issue
LEFT JOIN
(SELECT customfieldvalue.ISSUE,customfieldvalue.customfield,customfieldvalue.stringvalue as prdenv from customfieldvalue 
WHERE customfieldvalue.CUSTOMFIELD =10124 AND customfieldvalue.STRINGVALUE=10123 ) c
ON a.issueid=c.issue
WHERE prdphase=10804 AND prdenv=10123
GROUP BY pid"
?>