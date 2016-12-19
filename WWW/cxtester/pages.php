<?php
@include_once('conToMysql.php');

	$pagesize=10;	//每页显示10条
	$url=$_SERVER["REQUEST_URI"];//解析当前地址
	$url=parse_url($url);
	$url=$url["path"];
	
	$sqlAll="select * from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid";
	$queryAll=mysql_query($sqlAll);

	$num=mysql_num_rows($queryAll);//获取数据库的条数
	//echo $num;
	
	if(!$_GET["page"]){
		$pagevalue=1;
		//$pagevalue=$_GET["page"];
		$page=($pagevalue-1)*$pagesize;
		$page.=',';
	}else{
		
		$pagevalue=$_GET["page"];
		$page=($pagevalue-1)*$pagesize;
		$page.=',';
	}


	$pageTotal=ceil($num/$pagesize);
	if( $pagevalue<=$pageTotal){
		//echo "page number is ".$pageTotal."<br />";
		//echo $pageTotal;
		$pagevalue=$pageTotal-1;
	}else{
		//echo "page number is wrong!"
	};
	//$SQL="SELECT * FROM testerinprojects limit $page $pagesize ";
	$SQL="select  testerinfo.testerid as tid,testerinfo.name as tname,testerinfo.status as tstatus,testerinfo.skill as tskill,testerinprojects.id as pid,testerinprojects.project as pproject,testerinprojects.starttime as pstart,testerinprojects.completetime as pcomplete,testerinprojects.status as pstatus,testerinprojects.projmanager as pmanager,testerinprojects.department as pdepartm  from testerinfo left join testerinprojects on testerinfo.testerid=testerinprojects.testerid order by testerinfo.testerid limit $page $pagesize ";//查询出所有用户所有项目
	
	$query=mysql_query($SQL);
	
	while($result_array=mysql_fetch_assoc($query))
	{
		$list[] = $result_array;
	}
	
	$obj= array("pageTotal" => strval($pageTotal),"numTotal"=>strval($num));
	//echo $list[0]["tid"];
	
	array_push($list,$obj);
	$jsonOut=json_encode($list);
	echo $jsonOut;

	mysql_close($connection);
?>