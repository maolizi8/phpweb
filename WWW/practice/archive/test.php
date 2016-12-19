<?php
$con=mysql_connect("localhost","root","root") or die("could not connect".mysql_error);//连接数据库
mysql_set_charset("utf8");
mysql_select_db("testlink",$con);

$pagesize=4;

	//$SQL="SELECT * FROM testerinprojects where project like '%泊车1%'";
	$SQL="SELECT * FROM testerinprojects where id=0";
$result=mysql_query($SQL);
$num=mysql_num_rows($result);


$pageTotal=ceil($num/$pagesize);


	while($result_array=mysql_fetch_assoc($result))
		{
			$list[] = $result_array;
		}
echo "num=".$num."<br />";
echo "pageTotal=".$pageTotal."<br />";
echo $pagesize."<br />";

if(empty($list)){
	$list=array(array("pageTotal" => 0,"numTotal"=>0,"pageSize"=>4));
}else {
	$obj= array("pageTotal" => strval($pageTotal),"numTotal"=>strval($num),"pageSize"=>strval($pagesize));
	array_push($list,$obj);
}
		$jsonOut=json_encode($list);
		echo $jsonOut;
?>