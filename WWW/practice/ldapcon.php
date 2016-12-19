<?php
$ds=ldap_connect("ad.dds.com:389");
if ($ds) {
	echo "ds is".$ds;
} else {
	echo "failed";
}

//首先连接上服务器
$justthese = array("cn","userpassword","location");
//搜索函数中的一个参数，要求返回哪些信息，
//以上传回cn,userpassword,location,这些都要求小写

//echo json_encode($justthese);


$sr=ldap_search($ds,"CN=LDAP,CN=Users,DC=dds,DC=com", "cn=g*",$justthese);
////第一个参数开启LDAP的代号
////第二个参数最基本的 dn 条件值 , 例：”o=jite,c=cn”
////第三个参数 filter 为布林条件，它的语法可以在 Netscape 站上找一份 dirsdkpg.pdf 档案.
//// ’o’为组织名，’cn’ 为用户名,用户名可用通配符 ’*’
//echo "ge姓氏有".ldap_count_entries($ds,$sr)." 个";
////ldap_count_entries($ds,$sr)传回记录总数

$info = ldap_get_entries($ds, $sr);
//LDAP的全部传回资料
echo "资料传回 ".$info["count"]."笔:";
//for ($i=0; $i<$info["count"]; $i++) {
//echo "dn为：". $info[$i]["dn"] ."
//";
//echo "cn为：". $info[$i]["cn"][0] ."
//"; //显示用户名
//echo "email为：". $info[$i]["mail"][0] ."
//
//"; //显示mail
//echo "email为：". $info[$i]["userpassword"][0] ."
//
//"; //显示加密后的密码
//}
?>
