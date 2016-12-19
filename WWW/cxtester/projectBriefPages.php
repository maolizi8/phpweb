<?php
@include_once('conToMysql.php');

	$pagesize=5;	//每页显示多少条
	$url=$_SERVER["REQUEST_URI"];//解析当前地址
	$url=parse_url($url);
	$url=$url["path"];
	
	$sqlAll="select * from projectbrief";
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
	};
	
	$SQL="select * from testerproject order by id ASC limit ".$page.$pagesize;
	//echo $SQL;
	$query=mysql_query($SQL);
	
	while($result_array=mysql_fetch_assoc($query))
	{
		$list[] = $result_array;
	}
	
	if(empty($list)){
			$list=array(array("pageTotal" => 0,"numTotal"=>0,"pageSize"=>strval($pagesize)));
		}else {
			$obj= array("pageTotal" => strval($pageTotal),"numTotal"=>strval($num),"pageSize"=>strval($pagesize));
			//$obj= array("pageTotal" => $pageTotal,"numTotal"=>$num,"pageSize"=>$pagesize);
			array_push($list,$obj);
		}
		
	$jsonOut=json_encode($list);
	echo $jsonOut;

	
	mysql_close($connection);
?>