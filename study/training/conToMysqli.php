<?php
//PO
//		$mysqli = new mysqli("localhost:3306", "root", "root", "trm");
//		$mysqli = new mysqli("127.0.0.1", "root", "root", "trm");
//		mysqli_set_charset($mysqli, "utf8");
//		
//		/* check connection */
//		if (mysqli_connect_errno()) {
//			printf("Connect failed: %s\n", mysqli_connect_error());
//			exit();
//		}
	
//OO	
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$database = "test";

// 创建连接
	$mysqli = new mysqli($servername, $username, $password, $database);
	$mysqli->set_charset("utf8");
	
// 检测连接
	if ($mysqli->connect_error) {
	    die("连接失败: " . $mysqli->connect_error);
	}
	//echo "连接成功";
?> 