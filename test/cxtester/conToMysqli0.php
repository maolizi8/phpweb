<?php		
		//$mysqli = new mysqli("localhost:3306", "root", "root", "trm");
		$mysqli = new mysqli("127.0.0.1", "root", "root", "trm");
		mysqli_set_charset($mysqli, "utf8");
		
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		
?>