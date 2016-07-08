<form action="" method="post">                
				<?php 
					
				$resultat = mysql_query("SELECT id,news FROM news GROUP BY id DESC");
				$content = mysql_fetch_assoc($resultat);
?>
<center><h2>Удалить Новость</h2></center>
<? if (isset($_POST['id1'])) {$id = $_POST['id1'];}
	if (isset($_POST['del2'])) {
	
	if(isset($id))
				{
				if (mysql_query("DELETE FROM news WHERE id='$id'"))
                    	echo '<div class="alert alert-dismissable alert-success">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  Новость удалена! 
							</div>
							<script>
							function GoNah(){ 
						location="./?go=news_delete"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>';
                	else
                    	echo '<div class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>Новость НЕ удалена!</strong> Что-то не работает.
							</div>';
				}
				else
				{
				echo '<div class="alert alert-dismissable alert-danger">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  Для начала выберите новость!
					</div>';
				}
	
	} ?>

<table class="table table-striped table-hover">
		<thead>
    <tr>
      <th>Выбрать</th>
      <th>Новости</th>
    </tr>
  </thead>
  <tbody>

<?				
				do
				{
				printf ("<tr><td><input name='id1' type='radio' value='%s' /></td><td><span class='text-primary'> %s</span></td></tr>",$content['id'],$content['news']);
				}
				while ($content = mysql_fetch_assoc($resultat));	
				?>
				</tbody>
				</table>
                <center><input name="del2" type="submit" class="btn btn-default" value="Удалить " /></center>
                </form>
				<?
?>