<? include("./conf.php"); ?>

<html>
	<head>
	<script type='text/javascript' src='js/jquery.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/bootstrap.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/ajax.js'></script>
	<link rel='stylesheet' type='text/css' href='http://bootswatch.com/slate/bootstrap.min.css'>
	<title><?=SITE_NAME ?> | Разбан</title>
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
      <li class="active"><a href="unban">Разбан</a></li>
      <li><a href="view">Список</a></li>
	  <li><a data-toggle="modal" data-target="#faq" style="cursor: pointer;">FAQ</a></li>
	  <li><a data-toggle="modal" data-target="#news" style="cursor: pointer;">Новости</a></li>
    </ul>
  </div>
</div>
	
	
	<div class="container">
	<div style="width: 400px; margin: auto;">
		<div class="panel" style="margin-bottom: 5px;">
		
	<div class="panel-body">
	<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div class="form-group"> 
  
  <form class="form-horizontal">
  <fieldset>
    <center><legend>Подача заявки на разбан</legend></center>
    <div class="form-group">
      <div class="col-lg-10">
        <input type="text" class="form-control" name="nick" id="nick" placeholder="Steam ID / IP / Ник(в момент бана)">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10">
        <input type="text" class="form-control" name="prichina" id="prichina" placeholder="Причина бана">
      </div>
    </div><br>
	<div class="form-group">
      <div class="col-lg-10">
        <textarea type="text" class="form-control" name="contacts" id="contacts" placeholder="Ваши контакты"></textarea>
      </div>
    </div>
	<div class="form-group">
      <div class="col-lg-10">
        <textarea type="text" class="form-control" name="dok" id="dok" placeholder="Доказательства (ссылка на демку или скрин)"></textarea>
      </div>
    </div>
	<input name="date" id="date" type="hidden" value="<? echo date("Y-m-d");?>">
	<div class="form-group">
      <div class="col-lg-10">
			<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Введите код с картинки"><br>
			<span class="form-control input-lg" style="background-color: #6E7B8B;"><center><img src="captcha.php" id="cpt" width="60" height="20" style="cursor: pointer" onclick="generate();"/></center></span>
      </div>
    </div>
	<input type="hidden" value="<?=$_SERVER['REMOTE_ADDR']; ?>" id="ip" name="ip">
    
        <center><input type="button" onclick="send();" value="Подать Заявку" class="btn btn-primary"></center>
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