<?PHP

	$starttimie="2016-09-06";
	$completetime="2016-09-17";
	$day=date("Y-m-d");
	$start=date("Y-m-d",strtotime($starttimie));
	$complete=date("Y-m-d",strtotime($completetime));
	if($start>$day){
		$status=0;
	}else if($start<=$day && $complete>=$day){
		$status=1;
	}else{
		$status=2;
	}
	
	if($status==0){
		$statu="未开始";
		
	}else if($status==1){
		$statu="进行中";
			
	}else{
		$statu="已结束";
	}
	
	echo "状态为：".$statu;
	

?>