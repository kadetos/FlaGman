<?
/*--Редактирование заявок--*/
if (!isset($_GET['act'])) {
if (!isset($_GET['edit'])){

if(isset($_POST['del_all']))
    {
    mysql_query("DELETE FROM `access_token`");    
    }

if(isset($_POST['del']))
    {
    $id=$_POST['u'];
    mysql_query("DELETE FROM `unban` WHERE `id` = '$id'");    
    }
	
	$req=mysql_query("SELECT * FROM unban ORDER BY ban");
if(mysql_num_rows($req)>0) { 
  $result = mysql_query("SELECT * FROM unban ORDER BY ban");
$myrow = mysql_fetch_array($result);
?>
<h2><center>Редактирование заявок</h2></center>
<center> <table class="table table-striped"> <thead><th>Ник игрока</th><th>Причина</th><th>Статус</th><th>IP</th><th>Действие</th></thead><tbody>

<?

do{
if($myrow["ban"] === "0") {$b = "Не расмотрена"; $b1 = "class='active'";} if($myrow["ban"] === "1") {$b = "Рассмотрена (<font color='Firebrick'>не разбанен</font>)"; $b1 = "class='danger'";} if($myrow["ban"] === "2") {$b = "Рассмотрена (<font color='green'>разбанен</font>)"; $b1 = "class='success'";}
printf ("<tr $b1 >
		 <form action='' method='post'>
		 <input type='hidden' name='u' value='".$myrow[id]."'>
		 <td>%s</td>
		 <td>%s</td>
		 <td>%s</td>
		 <td>%s</td>
		 <td><div class='btn-group'>
			 <a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>Действие  <span class='caret'></span></a>
			 <ul class='dropdown-menu'>
			 <li><a href='/view?id=%s'>Просмотр</a></li>
			 <li><a href='./?edit=%s'> Редактировать</a></li>
			 <li>&nbsp;&nbsp;<input type='submit' value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Удалить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' name='del' class='btn btn-default'></li>
			 </ul>
			 </div></td>
		 </form></tr>", $myrow["nick"],$myrow["prichina"],$b,$myrow["ip"],$myrow["id"],$myrow["id"]);
}
while($myrow = mysql_fetch_array($result));
	
  echo "</tbody>
</table>";
  }
else {
	echo '<br><br><div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-info">Внимание!</h3>
  </div>
  <div class="panel-body">
    В базе данных пока нету никаких записей!
  </div>
</div>';
}
}
                                       
	  else {
	  $id = $_GET["edit"];
?>
<h2><center>Редактирование заявки №<?=$id; ?></h2></center>
<?
	if(isset($_POST["set1"])) {
$nick = $_POST["nick"];
$prichina = $_POST["prichina"];
$dok = $_POST["dok"];
$contacts = $_POST["contacts"];
$ban = $_POST["ban"];
$result = mysql_query ("UPDATE unban SET nick='$nick', prichina='$prichina', dok='$dok', contacts='$contacts', ban='$ban' WHERE id='$id'");
			  
			  if($result == 'true')  {
			  echo '<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					Отредактировано!
					</div>
					<script>
							function GoNah(){ 
						location="./"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>'; 
			  }
			  else {echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Не отредактировано!</strong> Вы где-то ошиблись.
						  </div>';}
	  }

	  $result2 = mysql_query("SELECT * FROM unban WHERE id='$id'");
$myrow2 = mysql_fetch_array($result2);
	 ?> 
	  <center><form action="" method="post" name="edit">
	  <br><div class="form-group">
          <label class="control-label" for="inputLarge">Ник: </label>
          <input class="form-control input-lg" type="text" name="nick" value="<?=$myrow2["nick"]; ?>" maxlength="15">
		  </div>
		  <br><div class="form-group">
          <label class="control-label" for="inputLarge">Причина: </label>
          <textarea class="form-control input-lg" type="text" name="prichina" rows=""><?=$myrow2["prichina"]; ?></textarea>
		  </div>
		  <br><div class="form-group">
          <label class="control-label" for="inputLarge">Доказательство: </label>
          <textarea class="form-control input-lg" type="text" name="dok" rows=""><?=$myrow2["dok"]; ?></textarea>
		  </div>
	  <br><div class="form-group">
	  <label class="control-label" for="inputLarge">Статус: </label>
	  <select name="ban" class="form-control">
	  <option value="0" <? if ($myrow2["ban"] == 0) {echo 'selected';} ?>><font color="grey">Не расмотрена</font></option>
	  <option value="1" <? if ($myrow2["ban"] == 1) {echo 'selected';} ?>>Рассмотрена (<font color="red">не разбанен</font>)</option>
	  <option value="2" <? if ($myrow2["ban"] == 2) {echo 'selected';} ?>>Рассмотрена (<font color="green">разбанен</font>)</option>
	   </select></div><br>
	   <div class="form-group">
          <label class="control-label" for="inputLarge">Контакты: </label>
          <input class="form-control input-lg" type="text" name="contacts" value="<?=$myrow2["contacts"]; ?>" maxlength="15">
		  </div><br>
	   <input class="btn btn-primary" name="set1" type="submit" value="Редактировать" />
	  </form></center>
	  <?
	  }
	  }
	  else {
		$req=mysql_query("SELECT * FROM unban WHERE ban='0'");
if(mysql_num_rows($req)>0) { 
  $result = mysql_query("SELECT * FROM unban WHERE ban='0'");
$myrow = mysql_fetch_array($result);
?>
<h2><center>Новые заявки</h2></center>
<center> <table class="table table-striped"> <thead><th>Ник игрока</th><th>Причина</th><th>Статус</th><th>IP</th><th>Действие</th></thead><tbody>

<?

do{
if($myrow["ban"] === "0") {$b = "Не расмотрена"; $b1 = "class='active'";} 
printf ("<tr $b1 >
		 <form action='' method='post'>
		 <input type='hidden' name='u' value='".$myrow[id]."'>
		 <td>%s</td>
		 <td>%s</td>
		 <td>%s</td>
		 <td>%s</td>
		 <td><div class='btn-group'>
			 <a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>Действие  <span class='caret'></span></a>
			 <ul class='dropdown-menu'>
			 <li><a href='/view?id=%s'>Просмотр</a></li>
			 <li><a href='./?edit=%s'> Редактировать</a></li>
			 <li>&nbsp;&nbsp;<input type='submit' value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Удалить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' name='del' class='btn btn-default'></li>
			 </ul>
			 </div></td>
		 </form></tr>", $myrow["nick"],$myrow["prichina"],$b,$myrow["ip"],$myrow["id"],$myrow["id"]);
}
while($myrow = mysql_fetch_array($result));
	
  echo "</tbody>
</table>";
  }
else {
	echo '<br><br><div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-info">Внимание!</h3>
  </div>
  <div class="panel-body">
    Новых заявок не поступало!
  </div>
</div>';
}
	  }
/*--Конец Редактирование заявок--*/
?>