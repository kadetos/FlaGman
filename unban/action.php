<?php

session_start();

include("./conf.php");

$kapcha = mb_strtolower($_POST['captcha']);

if($kapcha != $_SESSION['rand_code']){ 
echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
  Капча введена неверно, попробуйте снова.
</div>';
} 
else { 


if($_POST["nick"] === ""){unset($_POST["nick"]);} else {$nick = $_POST["nick"];}
if($_POST["prichina"] === "") {unset($_POST["prichina"]);} else {$prichina = $_POST["prichina"];}
if($_POST["dok"] === "") {unset($_POST["dok"]);} else {$dok = $_POST["dok"];}
if($_POST["contacts"] === "") {unset($_POST["contacts"]);} else {$contacts = $_POST["contacts"];}
if($_POST["date"] === "") {unset($_POST["date"]);} else {$date = $_POST["date"];}
if($_POST["ip"] === "") {unset($_POST["ip"]);} else {$ip = $_POST["ip"];}

if(isset($nick) and isset($prichina) and isset($dok) and isset($contacts) and isset($date) and isset($ip)) {

$strSQL = "INSERT INTO unban (nick,contacts,prichina,dok,ip,date) VALUES ('$nick','$contacts','$prichina','$dok','$ip','$date')"; 

mysql_query($strSQL) or die(mysql_error());


echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  Заявка на разбан успешно отправлена!
</div>';
} else {

	echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Внимание!</strong> Вы не всё ввели.
</div>';

}
}
?>