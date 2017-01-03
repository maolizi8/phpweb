<?php

try {
    //连接数据库
    //$db = new SQLite3('datatables.sqlite3');
 		$mysqli = new mysqli("localhost:3306", "root", "root", "testlink");
		mysqli_set_charset($mysqli, "utf8");
		
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
} catch (PDOException $e) {
	fatal(
        "数据库连接出错" . $e->getMessage()
    );
}

//获取Datatables发送的参数 必要
//$draw = $_GET['draw'];//这个值作者会直接返回给前台
//query data

$query="select  testerinfo.testerid as tid,testerinfo.name as tname,testerinfo.status as tstatus,testerinfo.skill as tskill,testerinprojects.id as pid,testerinprojects.project as pproject,testerinprojects.starttime as pstart,testerinprojects.completetime as pcomplete,testerinprojects.status as pstatus,testerinprojects.projmanager as pmanager,testerinprojects.department as pdepartm  from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid order by testerinfo.testerid";//查询出所有用户所有项目
		

$infos = array();
$result=  mysqli_query($mysqli,$query);

$i=0;
$array=mysqli_fetch_all($result, MYSQLI_ASSOC);	// 获取数据
while (list($key,$row)=each($array)) {
	//echo $row['tname'];
	$i+=1;
	if($row['tstatus']==0){
		$tstatus="可用";
	}else{
		$tstatus="锁定";
	}
	
	if($row['pstatus']==0){
		$pstatus="未开始";
	}else if($row['pstatus']==1){
		$pstatus="进行中";
	}else{
		$pstatus="已结束";
	}
	
  	//$obj=array('index'=>$i, 'tid'=>$row['tid'], 'tname'=>$row['tname'], 'tstatus'=>$row['tstatus'],'pstatus'=> $row['pstatus'],'pproject'=> $row['pproject'], 'pstart'=>$row['pstart'],'pcomplete'=>$row['pcomplete'],'pmanager'=>$row['pmanager'],'pdepartm'=>$row['pdepartm'],'tskill'=>$row['tskill']);
    $obj=array('index'=>$i, 'tid'=>$row['tid'], 'tname'=>$row['tname'], 'tstatus'=>$tstatus,'pstatus'=> $pstatus,'pproject'=> $row['pproject'], 'pstart'=>$row['pstart'],'pcomplete'=>$row['pcomplete'],'pmanager'=>$row['pmanager'],'pdepartm'=>$row['pdepartm'],'tskill'=>$row['tskill']);
    //echo json_encode($obj);
   	array_push($infos,$obj);
   	
}


/*
 * Output 包含的是必要的
*/
echo json_encode(array("data" => $infos));


function fatal($msg)
{
    echo json_encode(array(
        "error" => $msg
    ));
    exit(0);
}


?>