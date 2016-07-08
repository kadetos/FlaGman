<?

include("../conf.php");
session_start();

if(get_magic_quotes_gpc()){
  $_POST[password]=stripslashes($_POST[password]);
}

if(($_POST[login]==ADMIN_LOGIN) && ($_POST[password]==ADMIN_PASS)) {
  $_SESSION["admin_mode"]=1;
  $req=mysql_query("SELECT * FROM unban WHERE ban='0'");
  if(mysql_num_rows($req)>0) {header("Location: /adm/?act=new");} 
  else {header("Location: /adm/");}
} else {
  $_SESSION["admin_mode"]=0;
  sleep(1);
  header("Location: /login/");
  exit;
}


?>