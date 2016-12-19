<?php
@include_once('conToJira.php');
	$username=$_POST['username'];
	$usersAll="
	select cwd_user.display_name,app_user.user_key from cwd_user 
left join
app_user on app_user.lower_user_name=cwd_user.lower_user_name
	where cwd_user.lower_user_name in (select lower_user_name from app_user where user_key like '%".$username."%')
		or cwd_user.lower_user_name like '%".$username."%'
		or cwd_user.display_name like '%".$username."%'
		";
	$result=$conjira->query($usersAll);
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