<?php
	@include_once('conToMysql.php');
	//@require_once('conToMysql.php');
		$name=$_POST['name'];
		$status=$_POST['status'];
		$skill=$_POST['skill'];
		$pagevalue=$_GET['page'];
		$pagesize=$_GET['pageSize'];
		
		//$pagesize=10;
		
		$url=$_SERVER["REQUEST_URI"];//解析当前地址
		$url=parse_url($url);
		$url=$url["path"];
		
		$queryAll="select * from testerinfo where name like '%$name%' and skill like '%$skill%'";//查询所有的tester
		if ($status!="") {
			$queryAll.=" and status=".$status;
		}
		$resultAll=mysql_query($queryAll);
		$numTotal=mysql_num_rows($resultAll);//总共有多少
		//echo "总数：".$numTotal;	
		$page=($pagevalue-1)*$pagesize;
		$page.=',';
		
		$pageTotal=ceil($numTotal/$pagesize);
		//echo "总页数：".$pageTotal;		
		
		$queryAll.=" order by testerid ASC limit ".$page.$pagesize;  //分页
		$result=mysql_query($queryAll);
		
		if(!$result)
		{
			die("error 1: </br>".mysql_error());
		}

		while($result_array=mysql_fetch_assoc($result))//取出结果并显示//$result_array=mysql_fetch_array($result);
		{
			$list[] = $result_array;
		}	
		
		if(empty($list)){
			$list=array(array("pageTotal" => 0,"numTotal"=>0,"pageSize"=>strval($pagesize)));
		}else {
			$obj= array("pageTotal" => strval($pageTotal),"numTotal"=>strval($numTotal),"pageSize"=>strval($pagesize));
			array_push($list,$obj);
		}
				
		$jsonOut=json_encode($list);
		echo $jsonOut;		
				
		mysql_close($connection);
?>