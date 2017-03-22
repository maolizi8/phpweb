<?php
	
$array1 = array(
                0=>array('id'=>8,'name'=>'Apple','age'=> 18),
                1=>array('id'=>8,'name'=>'Bed','age'=>17),
                2=>array('id'=>5,'name'=>'Cos','age'=>16),
                3=>array('id'=>5,'name'=>'Cos','age'=>14)
    );
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
        $args[] = &$arr;//引用值
        call_user_func_array('array_multisort',$args);
        return array_pop($args);
    }
    $arr = sortArrByManyField($array1,'id',SORT_DESC);
      print_r($arr);
?>