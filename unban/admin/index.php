<?

include("../conf.php");
include("./auth.php");



// Encodes a given number in a base 36 (0-9,a-z) format


if(isset($_POST['editor']))
    {
	$t = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
	if($_POST['login_new'] === ""){unset($_POST['login_new']);} else {$login = $_POST['login_new'];
	mysql_query("UPDATE adminka SET login_a='".$login."', auth='".$t."' WHERE id='1'"); 
	}
	if($_POST['pass_new'] === ""){unset($_POST['pass_new']);} else {$pass = $_POST['pass_new'];
	mysql_query("UPDATE adminka SET pass_a='".$pass."', auth='".$t."' WHERE id='1'"); 
	}   
    }
	$req=mysql_query("SELECT * FROM adminka WHERE id ='1'");
	$r=mysql_fetch_assoc($req);
?>
<html><head>

<title>Админ Панель | <?=SITE_NAME; ?></title>
<script type='text/javascript' src='../js/jquery.min.js' type='text/javascript'></script>
<script type='text/javascript' src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel='stylesheet' type='text/css' href='http://bootswatch.com/slate/bootstrap.min.css'>
<link rel='shortcut icon' href='../icon.png' type='image/x-icon'>
</head>
<body>

<div class="navbar navbar-default">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="./">Главная</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
	  <li><a href="/" target="_blank">Главная сайта</a></li>
    </ul>
	<form class="navbar-form navbar-left">
	<span class="text-muted">Последний вход: <b><?=date("d-m-Y H:i",$r[auth]); ?></b></span><br>
	<span class="text-muted">Последний IP: <b><?=$r[last_active]; ?></b></span>
	</form>
	<ul class="nav navbar-nav navbar-right">
	
	<? $result = mysql_query("SELECT ban FROM unban");
	$myrow = mysql_fetch_array($result); 
	$kol = 0;
	do{
	if($myrow['ban'] === '0') {$kol += 1;}
	}
	while($myrow = mysql_fetch_array($result));
	if($kol > 0){
	?>	
	
	
	<li><a href="./?act=new">Новые <span class="badge"><?=$kol; ?></span></a></li>
<? } ?>
	  <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Функции <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="./">Редактирование заявок</a></li>
		  <li class="divider"></li>
          <li><a href="./?go=news">Добавить новость</a></li>
          <li><a href="./?go=news_edit">Редактировать новость</a></li>
          <li><a href="./?go=news_delete">Удалить новость</a></li>
		  <li class="divider"></li>
		  <li><a href="./?go=ban_ip">Управление IP Банов</a></li>
        </ul>
      </li>
	  <li><a data-toggle="modal" data-target="#donate" style="cursor: pointer;">Изменить логин или пароль</a></li>
      <li><a href="/logout/">Выход</a></li>
    </ul>
  </div>
</div>

<div class="container">
<div style=" <? if(!isset($_GET['go']))
 {if(!isset($_GET['edit'])){echo 'width: 900px;';} 
 else {echo 'width: 400px;';}}
 if($_GET['go'] === 'news') {echo 'width: 500px;';}
 if($_GET['go'] === 'news_edit') {if(isset($_GET['id'])) {echo 'width: 500px;';}}
 if($_GET['go'] === 'ban_ip') {echo 'width: 700px;';}
?> margin: auto; margin-top: 50px;">
	
	<div class="panel" style="margin-bottom: 5px;">
	<div class="panel-body">
	<div class="form-group has-warning">


<?
  if (!isset($_GET['go'])) {
  include('includes/_stat.php');
  }
  if ($_GET['go'] === "news") {
  include('includes/_news.php');
  }
  if ($_GET['go'] === "news_edit") {
  include('includes/_news_edit.php');
  }
  if ($_GET['go'] === "news_delete") {
  include('includes/_news_delete.php');
  }
  if ($_GET['go'] === "ban_ip") {
  include('includes/_ban_ip.php');
  }
?>
</div>
&copy; 2014-2015 <a href="http://vk.com/matrizza_fox">MaTRiZZa</a>
</div>
</div>
</div>
</div>
<div class="modal fade" id="donate">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
<?
$req=mysql_query("SELECT * FROM adminka WHERE id ='1'");
$r=mysql_fetch_assoc($req);
echo '<form action="" method="post" name="form1">
<input type="hidden" name="editor" value="editing">
<div class="form-group">
  <label class="control-label" for="inputSmall">Логин</label>
  <input class="form-control input-sm" type="text" name="login_new" placeholder="'.$r[login_a].'">
</div><br>
<div class="form-group">
  <label class="control-label" for="inputSmall">Пароль</label>
  <input class="form-control input-sm" type="text" name="pass_new" placeholder="'.$r[pass_a].'">
</div><br><center><a href="#" onclick="document.form1.submit(); return false;" class="btn btn-info">Изменить</a></center></form>';
?>
      </div>
    </div>
  </div>
</div>

</body>
</html>