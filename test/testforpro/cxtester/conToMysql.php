<?php
$db_host='localhost:3306';
$db_username='root';
$db_password='root';
$connection=mysql_connect($db_host,$db_username,$db_password);//连接到数据库
$db_database='test';

mysql_query("set names 'utf8'");//编码转化

if(!$connection)
{
	die("could not connect to the database:</br>".mysql_error());//诊断连接错误
}
	
$db_selecct=mysql_select_db($db_database);//选择数据库
if(!$db_selecct)
{
	die("could not to the database</br>".mysql_error());
}

?>