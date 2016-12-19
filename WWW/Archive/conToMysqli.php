<?php		
		$mysqli = new mysqli("localhost:3306", "root", "", "testlink");
		
		mysqli_set_charset($mysqli, "utf8");
		
		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
?>