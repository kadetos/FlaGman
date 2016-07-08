<html><head>
<title>Админ Панель</title>
<link rel='stylesheet' type='text/css' href='http://bootswatch.com/slate/bootstrap.min.css'>
</head>
<body onload="document.form1.login.focus()">
<br><br><br>
<div class="container">
<div style="width: 400px; margin: auto; margin-top: 50px;">

	
	<div class="panel" style="margin-bottom: 5px;">
	<div class="panel-body">
	<div class="form-group has-warning">
<form name=form1 action="/dologin/" method=post>
<div class="form-group">
  <input class="form-control" name="login" type="text" placeholder="Введите Логин">
</div>
<div class="form-group">
  <input class="form-control" name="password" type="password" placeholder="Введите Пароль">
</div>
<center><input type=submit class="btn btn-primary" value="Войти" class=i></center>
</form>
</div>
</div>
</div>
</div>
</div>
</body>