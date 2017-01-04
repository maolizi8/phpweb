<?php
@include_once('conToJira.php');
	
	$users="SELECT m.MEMBER_KEY,m.TEAM_ID,t.NAME,t.LEAD 
from ao_aefed0_team_member_v2 m,ao_aefed0_team_v2 t
WHERE m.TEAM_ID=t.ID
and TEAM_ID in (51,52,53,54,55,56,57,34)
AND id in (SELECT TEAM_MEMBER_ID from ao_aefed0_membership)
ORDER BY t.name ASC";

	$result=$conjira->query($users);
	while($result_array=$result->fetch_assoc())
	{
		$list[] = $result_array;
	}	
	
	echo json_encode($list);
			
	$conjira->close();
?>