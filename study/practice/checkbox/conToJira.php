<?php
//con to jira server;
$servername="10.32.135.62";
$username="read_only";
$password="read_only";
$database="jira";
$port="3306";

// 创建连接
	$conjira = new mysqli($servername, $username, $password, $database);
	$conjira->set_charset("utf8");
	
// 检测连接
	if ($conjira->connect_error) {
	    die("连接失败: " . $conjira->connect_error);
	}
	//echo "连接成功";

?>