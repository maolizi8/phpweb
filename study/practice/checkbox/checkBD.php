<?PHP  
    	if(!empty($_POST["t1"])){  
    		$array = $_POST["t1"];  
    		echo "前端提交的是array is ".$array;
    		$size = count($array);
    		echo "长度是 ".$size."</br>";
    		
    		for($i=0; $i< $size; $i++){  
    			echo $array[$i]."</br>"; 
    			
    		} 
    		echo "<hr>";
    		echo json_encode($array); 
    		echo "<hr>";
    		$str=implode(",",$array);
    		echo $str;
    	}  
?>