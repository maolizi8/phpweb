
<?php
$ds=ldap_connect("ldap://180.168.41.175");
$basedn = "CN=LDAP,CN=Users,DC=dds,DC=com";
$justthese = array("ou");

$sr = ldap_list($ds, $basedn, "ou=*", $justthese);

$info = ldap_get_entries($ds, $sr);

for ($i=0; $i < $info["count"]; $i++) {
    echo $info[$i]["ou"][0];
}
?>
