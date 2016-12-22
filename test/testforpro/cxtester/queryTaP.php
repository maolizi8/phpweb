<?php
	@include_once('conToMysql.php');
	
	$tname=$_POST['tname'];
	$tskill=$_POST['tskill'];
	$tstatus=$_POST['tstatus'];
	$pproject=$_POST['pproject'];
	$pmanager=$_POST['pmanager'];
	$pdepartm=$_POST['pdepartm'];
	$pstatus=$_POST['pstatus'];
	$pagevalue=$_GET["page"];
	$pagesize=$_GET['pageSize'];
	
	//$pagesize=10;	//每页显示多少条
	$url=$_SERVER["REQUEST_URI"];//解析当前地址
	$url=parse_url($url);
	$url=$url["path"];
		
	$query="create temporary table temp select testerinfo.testerid as tid,testerinfo.name as tname,testerinfo.status as tstatus,testerinfo.skill as tskill,testerinprojects.id as pid,testerinprojects.project as pproject,testerinprojects.starttime as pstart,testerinprojects.completetime as pcomplete,testerinprojects.status as pstatus,testerinprojects.projmanager as pmanager,testerinprojects.department as pdepartm from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid order by testerinfo.testerid";//查询出所有用户所有项目
	
	if(mysql_query($query)) {								
		$search="select * from temp where tname like '%$tname%' ";  //数据库中tname字段肯定有值；				
		if ($tskill!="") {
			$search.=" and tskill like '%".$tskill."%'";
		}
		if ($tstatus!="") {
			$search.=" and tstatus=".$tstatus;
		}
		if($pproject!=""){
			$search.=" and pproject like '%".$pproject."%'";
		}
		if ($pmanager!="") {
			$search.=" and pmanager like '%".$pmanager."%'";
		}
		if ($pdepartm!="") {
			$search.=" and pdepartm like '%".$pdepartm."%'";
		}
		if ($pstatus!="") {
			$search.="	and pstatus='".$pstatus."'";
		}
		//$sqlAll="select * from temp";
		$queryAll=mysql_query($search);
		
		$num=mysql_num_rows($queryAll);//获取数据库的条数
		$page=($pagevalue-1)*$pagesize;
		$page.=',';
		
		$pageTotal=ceil($num/$pagesize);
		//echo "总页数：".$pageTotal;
		if( $pagevalue<=$pageTotal){			
			$pagevalue=$pageTotal-1;
			//echo $pagevalue;
		};
		
		
		$search.=" order by pid DESC limit ".$page.$pagesize;  //分页
		
		$result=mysql_query($search);
		
		if(!$result)
		{
			die("error 1: </br>".mysql_error());
		}
		
		while($result_array=mysql_fetch_assoc($result))
		{
			$list[] = $result_array;
		}
		
		if(empty($list)){
			$list=array(array("pageTotal" => 0,"numTotal"=>0,"pageSize"=>strval($pagesize)));
		}else {
			$obj= array("pageTotal" => strval($pageTotal),"numTotal"=>strval($num),"pageSize"=>strval($pagesize));
			array_push($list,$obj);
		}
				
		$jsonOut=json_encode($list);
		echo $jsonOut;
		
	}else{
		die("error 2: </br>".mysql_error());
	};
	
	
	
//	$droptemp="drop table #temp";
//	mysql_query($droptemp);
	
	mysql_close($connection);
?>