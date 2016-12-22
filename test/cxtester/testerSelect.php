<?php
	@include_once('conToMysqli.php');
	$query="select * from testerinfo order by testerid ASC";//查询所有的tester	
	$infos = array();
	$result=mysqli_query($mysqli,$query);

	$i=0;
	$array=mysqli_fetch_all($result, MYSQLI_ASSOC);	// 获取数据
	while (list($key,$row)=each($array)) {
		//echo $row['tname'];
		$i += 1;
		if ($row['status'] == 0) {
			$status = "可用";
		} else {
			$status = "锁定";
		}
				
  		$obj=array('index'=>$i, 'testerid'=>$row['testerid'], 'name'=>$row['name'], 'status'=>$status,'skill'=>$row['skill']);
    	//echo json_encode($obj);
   		array_push($infos,$obj);
   	}

	echo json_encode(array("data" => $infos));


	function fatal($msg){
    	echo json_encode(array(
        	"error" => $msg
    	));
    	exit(0);
	}
		
		
	mysqli_close($mysqli);
?>