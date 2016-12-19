<?PHP
//@include_once('conToMysql.php');	
@include_once('conToMysqli.php');		
	$testerid = $_POST['testerid'];
	$project=$_POST['project'];
	$starttime=$_POST['starttime'];
	$completetime=$_POST['completetime'];
	
	$day=date("Y-m-d");		
	$start=date("Y-m-d",strtotime($starttime));
	$complete=date("Y-m-d",strtotime($completetime));
	
	if($start>$day){
		$status=0;
	}else if($start<=$day && $complete>=$day){
		$status=1;
	}else{
		$status=2;
	}
	
	$projmanager=$_POST['projmanager'];
	$department=$_POST['department' ];
	
	$insertProj="insert into testerinprojects (testerid,project,starttime,completetime,projmanager,status,department) values('$testerid','$project','$starttime','$completetime','$projmanager','$status','$department');";//构建插入语句	
		
	if(mysqli_query($mysqli,$insertProj)){
		if($status==1){
			$queryUpdT="update testerinfo set status=1 where testerid='$testerid'";	//更新用户状态为锁定
			mysqli_query($mysqli, $queryUpdT);	//执行更新语句
		}
		
/*		$querySelT="select * from testerinprojects where testerid='$testerid' and status=1;";//查询用户所有的进行中的项目
		$result=mysqli_query($mysqli, $querySelT);//执行查询语句
		$numProj= mysqli_num_rows($result);	//获取用户的进行中项目的个数
	
		if($numProj==0){
			$queryUpdT="update testerinfo set status=0 where testerid='$testerid'";	//更新用户状态为可用
			mysqli_query($mysqli, $queryUpdT);	//执行更新语句
		}else{
			$queryUpdT="update testerinfo set status=1 where testerid='$testerid'";	//更新用户状态为锁定
			mysqli_query($mysqli, $queryUpdT);	//执行更新语句
		}
	*/
	}else{
		echo "update fail";
	}
	
//	
//	if($status==1){
//		$tstatus=1;//The project inserted is inprogress.So the tester's status should be occupied.
//		$query="insert into testerinprojects (testerid,project,starttime,completetime,projmanager,status,department) values('$testerid','$project','$starttime','$completetime','$projmanager','$status','$department');";//构建插入语句	
//		$query .="update testerinfo set status='$tstatus' where testerid='$testerid'";
//			
//		/* execute multi query */
//		if ($mysqli->multi_query($query)) {
//			do {
//			/* store first result set */
//				if ($result = $mysqli->store_result()) {
//					while ($row = $result->fetch_row()) {
//						printf("%s\n", $row[0]);
//					}
//					$result->free();
//				}
//				/* print divider */
//				if ($mysqli->more_results()) {
//					printf("-----------------\n");
//				}
//			} while ($mysqli->next_result());
//		}
//		
//	}else{
//		$insertProj="insert into testerinprojects (testerid,project,starttime,completetime,projmanager,status,department) values('$testerid','$project','$starttime','$completetime','$projmanager','$status','$department')";//构建插入语句	
//		mysqli_query($mysqli,$insertProj);
//	}
//	


	/* close connection */		
	mysqli_close($mysqli);			
	//$mysqli->close();	

	//mysql_close($connection);

?>