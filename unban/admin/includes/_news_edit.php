<?  
if(isset($_POST['addto'])){
						if (isset($_POST['text'])) {$text = $_POST['text']; if ($text == '') {unset($text);}}
						if (isset($_POST['id'])) {$id = $_POST['id'];}
						if (isset($_POST['date'])) {$date = $_POST['date']; if ($date == '') {unset($date);}}
						
						if(isset($text) and isset($date))
					{
					if(mysql_query("UPDATE news SET news='$text',date='$date' WHERE id='$id'"))
                     	echo '<div class="alert alert-dismissable alert-success">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  Новость обновлена!
							</div>
							<script>
							function GoNah(){ 
						location="./?go=news_edit"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>';
                	else
                     	echo '<div class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>Новость НЕ обновлена!</strong>Что-то не работает.
							</div>';
					}
				else
					{
					echo	'<div class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  Содержание новости не введено. Нету данных для обновления!
							</div>';
					}
					}


if (isset($_GET['id'])) {$id = $_GET['id'];}
	if (!isset($id))
					{
				$resultat = mysql_query("SELECT * FROM news GROUP BY id DESC");
				$content = mysql_fetch_array($resultat);
?>
		<center><h2>Редактировать Новость</h2></center>
		<table class="table table-striped table-hover">
		<thead>
    <tr>
      <th>Новость</th>
      <th>Дата</th>
    </tr>
  </thead>
  <tbody>
<?
				do
				{
				printf ("<tr class='active'><td><a href='./?go=news_edit&id=%s'>%s</a></td><td><span class='label label-primary'>(%s)</span></td></tr>",$content['id'],$content['news'],$content['date']);
				}
				while ($content = mysql_fetch_assoc($resultat));
?>
</tbody>
</table>
<?
					}
					else 
					{
				$resultat = mysql_query("SELECT * FROM news WHERE id=$id");
				$content = mysql_fetch_assoc($resultat);
print <<<FORM
						<center><h2>Редактировать Новость №$id</h2></center>
						<center><form id="form1" name="form1" method="post" action="">
						<div class="form-group">
						<label class="control-label" for="inputDefault">Содержание новости</label>
						<textarea name="text" class="form-control" id="inputDefault" cols="45" rows="5">$content[news]</textarea>
						</div>
              	  		<br>
						<div class="form-group">
						<label class="control-label" for="inputDefault">Дата</label>
						<input name="date" type="text" class="form-control" id="inputDefault" value="$content[date]">
						</div>
           	      		<p>
						<input name="id" type="hidden" value="$content[id]" />
           	        	<label>
           	        	&nbsp;&nbsp;&nbsp;<input type="submit" name="addto" id="addto"class="btn btn-default" value="Обновить" />
           	        	</label>
           	      		</p>
           	  			</form></center>
FORM;
					}	
						

?>