<?PHP
@include_once('conToMysql.php');
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

	if($status==1){
		$mysqli = new mysqli("localhost:3306", "root", "root", "testlink");
		mysqli_set_charset($mysqli, "utf8");
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		$tstatus=1;//The project inserted is inprogress.So the tester's status should be occupied.
		$query="insert into testerinprojects (testerid,project,starttime,completetime,projmanager,status,department) values('$testerid','$project','$starttime','$completetime','$projmanager','$status','$department');";//构建插入语句
		$query .="update testerinfo set status='$tstatus' where testerid='$testerid'";

		/* execute multi query */
		if ($mysqli->multi_query($query)) {
			do {
			/* store first result set */
				if ($result = $mysqli->store_result()) {
					while ($row = $result->fetch_row()) {
						printf("%s\n", $row[0]);
					}
					$result->free();
				}
				/* print divider */
				if ($mysqli->more_results()) {
					printf("-----------------\n");
				}
			} while ($mysqli->next_result());
		}
	/* close connection */

	$mysqli->close();
	}else{
		//$tstatus=0;
		$insertProj="insert into testerinprojects (testerid,project,starttime,completetime,projmanager,status,department) values('$testerid','$project','$starttime','$completetime','$projmanager','$status','$department')";//构建插入语句
		//$insertProj="insert into testerinprojects (testerid,project,starttime,completetime,status) values('2','泊车','2016-06-12','2016-07-12','2')";
		//$query=mysql_query($insertProj);

		if (!mysql_query($insertProj,$connection)){
			die('Error: ' . mysql_error());
		}

	}



	mysql_close($connection);

?>
