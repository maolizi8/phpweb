<?PHP 
	@include_once('conToJira.php');

	
	if(!empty($_POST["t1"])){  
    		
		$array = $_POST["t1"];  
    	$str=implode(",",$array);
    	
    }  
    	
	$projOngoing="
	select project.ID,project.pname,project.pkey from project 
	where project.pname not LIKE '%关闭%' AND project.pname not LIKE '%未立项%'
	and  project.ID in ($str)";
	$result=$conjira->query($projOngoing);
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