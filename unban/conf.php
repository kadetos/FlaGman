<?

date_default_timezone_set ('Europe/Kiev'); //Часовой пояс

define("DB_HOST","ip");  //хост для MySQL, обычно localhost
define("DB_USER","bd"); // пользователь MySQL
define("DB_PASS","pass"); //пароль
define("DB_BASE","user"); //название базы данные
define("SITE_NAME","ServAcHoc.NET - Заякы на розбан"); //название базы данные

//------------------------------------ Не трогать ---------------------------------//
@mysql_connect(DB_HOST,DB_USER,DB_PASS)
or die("Невозможно подключиться к базе данных. Возможно движок не был установлен. Если это так, то перейдите по этой ссылке <a href='http://".$_SERVER['HTTP_HOST']."/install.php'>".$_SERVER['HTTP_HOST']."/install.php</a>");

@mysql_select_db(DB_BASE)
or die("Ошибка mysql_select_db()");

$req=mysql_query("SELECT * FROM adminka WHERE id ='1'");
$r=mysql_fetch_assoc($req);
define("ADMIN_LOGIN",$r[login_a]);
define("ADMIN_PASS",$r[pass_a]);

$ip = $_SERVER['REMOTE_ADDR'];
$res=mysql_query("SELECT * FROM ip_ban WHERE ip='$ip'");
$myrow = mysql_fetch_array($res);
if(mysql_num_rows($res) > 0) { 
die (include("ban_ip.php"));
}
?>
