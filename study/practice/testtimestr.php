<?php

	
	$start=date("Y-m-d",strtotime("2016-12-04"));
	$end=date("Y-m-d",strtotime("2016-12-24"));
	$duriation=strval($start).'---'.strval($end);
	$now=date("Y-m-d h:i:s",strtotime('Thu Dec 22 2016 10:47:39 GMT+0800'));
	$now1=strtotime('2016-12-21 21:50:33');
	$now2=date("Y-m-d h:i:s",strtotime('Thu Dec 22 2016 10:54:45 GMT 0800 (中国标准时间)'));
	$now3=date("Y-m-d h:i:s",strtotime('Thu, 22 Dec 2016 02:58:46 GMT'));
	
	echo $now;
	echo "<br />";
	echo $now3;
?>