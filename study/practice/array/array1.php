<?php
$age=array(array("Peter"=>"35","Ben"=>"37","Joe"=>"43"));
$age[]=array("hha"=>"22");

foreach ($age as $arr) {
	foreach ($arr as $key => $value) {
		echo "Key=" . $key . ", Value=" . $value;
		echo "<br />";
	}
}

//$age2=array(array("Peter"=>"35","Ben"=>"37","Joe"=>"43"));
//foreach($age2 as $x=>$x_value)
// {
// echo "Key=" . $x . ", Value=" . $x_value;
// echo "<br />";
// }
?>