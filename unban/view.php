<? include("./conf.php"); ?>

<html>
	<head>
	<script type='text/javascript' src='js/jquery.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/bootstrap.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/ajax.js'></script>
	<link rel='stylesheet' type='text/css' href='http://bootswatch.com/slate/bootstrap.min.css'>
	<title><?=SITE_NAME; ?> | Список Заявок</title>
	</head>
	
	<body>
	
	<div class="navbar navbar-default">
	<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">Главная</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li><a href="unban">Разбан</a></li>
      <li class="active"><a href="view">Список</a></li>
	  <li><a data-toggle="modal" data-target="#faq" style="cursor: pointer;">FAQ</a></li>
	  <li><a data-toggle="modal" data-target="#news" style="cursor: pointer;">Новости</a></li>
    </ul>
  </div>
</div>
	
	<div class="container">
	<div  style=" <? if(!isset($_GET['id'])){ echo 'width: 700px;';} else{echo 'width: 400px;';} ?> margin: auto; margin-top: 50px;">
		<div class="panel" style="margin-bottom: 5px;">
		
	<div class="panel-body">
	<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div class="form-group"> 
  
  <form class="form-horizontal">
  <fieldset>
	
	
	
	
	
	
<?
if(!isset($_GET["id"])) { ?>

<center><legend>Список заявок</legend></center>
   <table class="table table-striped table-hover "><thead><th width="200">Steam ID / IP / Ник</th><th width="100">Причина</th><th width="200">Статус</th><th>Действие</th></thead><tbody>
<?php
$result = mysql_query("SELECT * FROM unban ORDER BY id DESC");
$myrow = mysql_fetch_array($result);

do{
if($myrow["ban"] === "0") {$b = "Не расмотрена"; $b1 = "class='active'";} if($myrow["ban"] === "1") {$b = "Рассмотрена (<font color='Firebrick'>не разбанен</font>)"; $b1 = "class='danger'";} if($myrow["ban"] === "2") {$b = "Рассмотрена (<font color='green'>разбанен</font>)"; $b1 = "class='success'";}
printf ("<tr ".$b1.">
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td><a href='./view?id=%s'>Просмотр</a></td></tr>", $myrow["nick"],$myrow["prichina"],$b,$myrow["id"]);
}
while($myrow = mysql_fetch_array($result))
             ?>
			
		</table>

<?
}
else {
$id = $_GET["id"];



$result = mysql_query("SELECT * FROM unban WHERE id='$id'");
$myrow = mysql_fetch_array($result);
if($myrow["ban"] === "0") {$b = "Не расмотрена"; $b1 = "class='active'";} if($myrow["ban"] === "1") {$b = "Рассмотрена (<font color='Firebrick'>не разбанен</font>)"; $b1 = "class='danger'";} if($myrow["ban"] === "2") {$b = "Рассмотрена (<font color='green'>разбанен</font>)"; $b1 = "class='success'";}
?>

<center><legend>Заявка на разбан №<? echo $myrow["id"];?> </legend></center>

<ul class="pager">
  <li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">← Назад</a></li>
</ul>
<table class="table table-striped table-hover ">

			<tr class="info"><td>Ваш ник:</td><td><? echo $myrow["nick"];?></td></tr>
			<tr class="info"><td>Контакты:</td><td><? echo $myrow["contacts"];?></td></tr>
			<tr class="info"><td>Причина бана:</td><td><? echo $myrow["prichina"];?></td></tr>
			<tr class="info"><td>Доказательства:</td><td><? echo $myrow["dok"];?></td></tr>
			<tr class="info"><td>Заявка создана:</td><td><? echo $myrow["date"];?></td></tr>
            <tr <?=$b1; ?>><td>Статус заявки:</td><td><?=$b; ?></td></tr></table>
			<? } ?>
  </fieldset>
</form>
</div>
&copy; 2014-2015 <a href="http://vk.com/matrizza_fox">MaTRiZZa</a>
		</div>
		</div>
		</div>
		</div>
		
		<div class="modal fade" id="faq">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">FAQ: Часто задаваемые вопросы</h4>
      </div>
      <div class="modal-body">
		<p><p><h4>Где узнать IP?</h4></p>
<p>IP узнать можно на сайте <a href="http://2ip.ru">2ip.ru</a></p> 
<p><h4>Как узнать STEAM_ID?</h4></p>
<p>Заходите на любой сервер и в консоле пишете: <i>status</i></p>
<p>Ищите в списке свой ник и возле него будет написан steam id</p>
<p><h4>Пример заполнения формы</h4></p>
<p><img src="images/FAQ.png"></p>
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