<? include("./conf.php"); ?>

<html>
	<head>
	<script type='text/javascript' src='js/jquery.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/bootstrap.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/ajax.js'></script>
	<link rel='stylesheet' type='text/css' href='http://bootswatch.com/slate/bootstrap.min.css'>
	<title><?=SITE_NAME ?></title>
	</head>
	
	<body>
	
	
	<div class="container">
	<div style="width: 400px; margin: auto; margin-top: 300px;">
	<center><img src="/images/logo.png" width="400"></center>
		<div class="panel" style=" margin-bottom: 5px;">
		
	<div class="panel-body">
		<div class="btn-group btn-group-justified">
  <a href="unban" class="btn btn-default">Разбан</a>
  <a href="view" class="btn btn-default">Список</a>
  <a data-toggle="modal" data-target="#news" style="cursor: pointer;" class="btn btn-default">Новости</a>
</div>
		</div>
		</div>
		</div>
		</div>
		<div class="modal fade" id="news">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">Новости</h4>
      </div>
      <div class="modal-body">
		<table class="table">
		<th>Дата</th>
		<th>Информация</th>
<?

		$result = mysql_query("SELECT * FROM news ORDER BY id DESC");
		$myrow = mysql_fetch_array($result);
		do{
?>
		<tr>
			<td><span class="label label-primary"><?=$myrow[date]; ?></span></td>
			<td><?=$myrow[news]; ?></td>
		</tr>
<? } while($myrow = mysql_fetch_array($result)); ?>	
		</table>
      </div>
    </div>
  </div>
</div>
	</body>
</html>