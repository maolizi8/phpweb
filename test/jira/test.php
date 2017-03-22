<?php
@include_once('conToJira.php');
$sql="select id,lead,pkey,pcounter from project limit 10";
$result=$conjira->query($sql);
	while($result_array=$result->fetch_assoc())
	{
		$list[] = $result_array;
	}	
	
//foreach ($list as $key => $value) {
//	$list[$key]['test']=(int)$list[$key]['id']*4+(int)$list[$key]['pcounter']*0.8;
//}
	//print_r($list);
function sortArrByManyField(){
        $args = func_get_args();
        if(empty($args)){
            return null;
        }
        $arr = array_shift($args);
        if(!is_array($arr)){
            throw new Exception("第一个参数不为数组");
        }
        foreach($args as $key => $field){
            if(is_string($field)){
                $temp = array();
                foreach($arr as $index=> $val){
                    $temp[$index] = $val[$field];
                }
                $args[$key] = $temp;
            }
        }
        $args[] = $arr;//引用值
        call_user_func_array('array_multisort',$args);
        return array_pop($args);
    }
    $arr = sortArrByManyField($list,'id',SORT_DESC);
    print_r($arr);

	//echo json_encode($list);
			
	$conjira->close();
?>