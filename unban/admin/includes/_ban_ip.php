<? 
if(!isset($_GET['add'])){
if(!isset($_GET['u'])) {

if(isset($_POST['del_all']))
    {
    mysql_query("DELETE FROM `ip_ban`");    
    }

if(isset($_POST['del']))
    {
    $id=$_POST['u'];
    mysql_query("DELETE FROM `ip_ban` WHERE `id` = '$id'");    
    }
	?>
	<ul class="pager">
  <li class="previous"><a href="./?go=ban_ip&add">Добавить</a></li>
</ul>
	<?
	$req=mysql_query("SELECT * FROM ip_ban ORDER BY date");
if(mysql_num_rows($req)>0) { 
  $result = mysql_query("SELECT * FROM ip_ban ORDER BY date DESC");
$myrow = mysql_fetch_array($result);
?>
<h2><center>Редактирование IP банов</h2></center>
<center> <table class="table table-striped"> <thead><th>IP</th><th>Причина</th><th>Дата</th><th>Действие</th><th><form action="" method="post"><input type='submit' value='Удалить все' name='del_all' class='btn btn-primary'></form></th></thead><tbody>

<?

do{
printf ("<tr class='danger'>
		 <form action='' method='post'>
		 <input type='hidden' name='u' value='".$myrow[id]."'>
		 <td>%s</td>
		 <td>%s</td>
		 <td>%s</td>
		 <td><div class='btn-group'>
			 <a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>Действие  <span class='caret'></span></a>
			 <ul class='dropdown-menu'>
			 <li><a href='./?go=ban_ip&u=%s'> Редактировать</a></li>
			 </ul>
			 </div></td>
		 <td><input type='submit' value='Удалить' name='del' class='btn btn-primary'></td>
		 </form></tr>", $myrow["ip"],$myrow["prichina"],$myrow["date"],$myrow["id"]);
}
while($myrow = mysql_fetch_array($result));
	
  echo "</tbody>
</table>";
  }
else {
	echo '<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-info">Внимание!</h3>
  </div>
  <div class="panel-body">
    В БД нету забаненых IP!
  </div>
</div>';
}
}
                                       
	  else {
	  $id = $_GET["u"];
?>
<h2><center>Редактирование бана №<?=$id; ?></h2></center>
<?
	if(isset($_POST["set1"])) {
$ip= $_POST["ip"];
$date = $_POST["date"];
$prichina = $_POST["prichina"];
$result = mysql_query ("UPDATE ip_ban SET ip='$ip', date='$date', prichina='$prichina' WHERE id='$id'");
			  
			  if($result == 'true')  {
			  echo '<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					Отредактировано!
					</div>
					<script>
							function GoNah(){ 
						location="./?go=ban_ip"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>'; 
			  }
			  else {echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Не отредактировано!</strong> Вы где-то ошиблись.
						  </div>';}
	  }

	  $result2 = mysql_query("SELECT * FROM ip_ban WHERE id='$id'");
$myrow2 = mysql_fetch_array($result2);
	  echo '<center><form action="" method="post" name="edit">
	  <br><div class="form-group">
          <label class="control-label" for="inputLarge">IP: </label>
          <input class="form-control input-lg" type="text" name="ip" value="'.$myrow2["ip"].'" maxlength="15">
		  </div>
		  <div class="form-group">
          <label class="control-label" for="inputLarge">Причина: </label>
          <input class="form-control input-lg" type="text" name="prichina" value="'.$myrow2["prichina"].'" maxlength="100">
		  </div><br>
	   <div class="form-group">
          <label class="control-label" for="inputLarge">Дата: </label>
          <input class="form-control input-lg" type="text" name="date" value="'.$myrow2["date"].'" maxlength="15">
		  </div><br><ul class="pager">
		<li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">← Назад</a></li>
		</ul>
	   <input class="btn btn-primary" name="set1" type="submit" value="Редактировать" />
	  </form></center>';
	  
	  }
} else {
?>
<center><h2>Забанить IP</h2></center>
	<form action="" method="post">
	<div class="form-group">
      <div class="col-lg-10">
        <input type="text" class="form-control" name="ip" id="ip" placeholder="Введите IP, который нужно забанить">
      </div>
    </div>
	<div class="form-group">
      <div class="col-lg-10">
        <textarea type="text" class="form-control" name="prichina" id="prichina" placeholder="Введите причину бана"></textarea>
      </div>
    </div>
	<ul class="pager">
	<li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">← Назад</a></li>
	</ul>
	<center><input type="submit" name="new_ban" value="Добавить" class="btn btn-primary"></center></form>
	<?
		if(isset($_POST['new_ban'])) {
		if($_POST["ip"] === "") {unset($_POST["ip"]);} else {$ip = $_POST['ip'];}
		if($_POST["prichina"] === "") {unset($_POST["prichina"]);} else {$prichina = $_POST['prichina'];}
		if(isset($ip) and isset($prichina)) {
		$req2=mysql_query("SELECT * FROM ip_ban WHERE ip='$ip'");
		if(mysql_num_rows($req2)===0) { 
		$date = date("Y-m-d");
		$result3 = mysql_query ("INSERT INTO ip_ban (ip,date,prichina) VALUES ('$ip','$date','$prichina')");
		if($result3 == 'true')  {
			  echo '<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					'.$ip.' добавлен в базу данных!
					</div>
					<script>
							function GoNah(){ 
						location="./?go=ban_ip"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>'; 
			  }
			  else {echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Не добавлено!</strong> Вы где-то ошиблись.
						  </div>';}
	} else { echo '<div class="alert alert-dismissable alert-info">
					<button type="button" class="close" data-dismiss="alert">×</button>
					'.$ip.' уже находится в базе данных!
					</div>
					<script>
							function GoNah(){ 
						location="./?go=ban_ip"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>';}
	} else { echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Внимание!</strong> Вы не всё ввели.
						  </div>';}
	
	}
	}
	?>