<center><h2>Добавить Новость</h2></center>
	<form action="" method="post">
	<div class="form-group">
      <div class="col-lg-10">
        <textarea type="text" class="form-control" name="text" id="text" placeholder="" style="margin: 0px -1px 0px 0px; height: 205px; width: 425px;"></textarea>
      </div>
    </div>
	<center><input type="submit" name="new" value="Добавить" class="btn btn-primary"></center></form>
	<?
		if(isset($_POST['new'])) {
		if($_POST["text"] === "") {unset($_POST["text"]);} else {$text = $_POST['text'];}
		if(isset($text)) {
		$date = date("Y-m-d");
		$result3 = mysql_query ("INSERT INTO news (news,date) VALUES ('$text','$date')");
		if($result3 == 'true')  {
			  echo '<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					Добавлено!
					</div>'; 
			  }
			  else {echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Не отредактировано!</strong> Вы где-то ошиблись.
						  </div>';}
	} else { echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Внимание!</strong> Вы не всё ввели.
						  </div>';}
	
	}
	?>