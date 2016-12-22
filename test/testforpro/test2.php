
<?php

$to = "geqiuli@chexiang.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n";
mail($to,$subject,$txt,$headers);
/*if(!mail($to,$subject,$txt,$headers)){
	echo "error";
	trigger_error("A custom error has been triggered");
	error_log("A custom error has been triggered",1,"geqiuli@chexiang.com","From: geqiuli@chexiang.com");
	error_reporting(E_ALL);
};
*/
error_reporting(E_ALL);
ini_set('display_errors', '1');
  
//将出错信息输出到一个文本文件
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
?>