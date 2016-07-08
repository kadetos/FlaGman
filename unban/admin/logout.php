<?
include("../conf.php");
$t = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
mysql_query("UPDATE adminka SET auth='".$t."', last_active='".$_SERVER['REMOTE_ADDR']."' WHERE id='1'");

session_start();
$_SESSION["admin_mode"]=0;
header("Location: /adm/");
exit;

?>