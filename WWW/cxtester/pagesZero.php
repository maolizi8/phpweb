<?php
@include_once('conToMysql.php');

	$pagesize=10;
	$url=$_SERVER["REQUEST_URI"];//解析当前地址
	$url=parse_url($url);
	$url=$url["path"];

	$numq=mysql_query("select * from testerinprojects" );

	$num=mysql_num_rows($numq);//获取数据库的条数

	if($_GET["page"]){
		$pageval=$_GET["page"];
		$page=($pageval-1)*$pagesize;
		$page.=',';
	}


	$int=ceil($num/$pagesize);
	if( $pageval>=$int){
		echo $int;
		$pageval=$int-1;
	};
	$SQL="SELECT * FROM testerinprojects limit $page $pagesize ";
	$query=mysql_query($SQL);
	while($row=mysql_fetch_array($query)){

		echo "<div id='wen'><span id='id'>".$row['project']."</span><div class='neirong'><span>".$row['status']."</span></div><div class='time'>".$row['starttime']."</div></div>";

	}
	if($num > $pagesize){
	if($pageval<=1)$pageval=1;

	echo "共 $num 条".
		" <a href=$url?page=".($pageval-1).">上一页</a> <a href=$url?page=".($pageval+1).">下一页</a>";
	}

?>