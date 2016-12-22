<?php
class Jiraconn
{
		public function conToJira()
	{
		$servername="10.32.135.62";
		$username="read_only";
		$password="read_only";
		$database="jira";
		$port="3306";
		$conjira = new mysqli($servername, $username, $password, $database);
		$conjira->set_charset("utf8");
		if ($conjira->connect_error) {
	    	die("连接失败: " . $conjira->connect_error);
		}
		return $conjira;
	}
}
	
?>