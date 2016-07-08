<!DOCTYPE html>
<?php
/**
 * Тема default для сайта CS:Bans
 * Главный шаблон сайта
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.min.css" rel="stylesheet">

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
<body>
<div id="wrapper1">
	<div class="menu">
		<div class="b_menu">
			<ul class="btn_profile_action btn_medium">
				<?php foreach(Usermenu::getMenu() as $item):?>
				<li>
					<?php echo CHtml::link(
							CHtml::encode($item['label']),
							$item['url']
						)?>
				</li>
				<?php endforeach;?>
			</ul>
			<ul class="btn_profile_action btn_medium login">
				<li class="dropdown">
					<?php if(Yii::app()->user->isguest):?>
					<a href="javascript:;" data-toggle="dropdown">
						Войти
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<p>
								<form method="post" action="<?php echo Yii::app()->createUrl('/site/login')?>" accept-charset="UTF-8">
									<input style="margin-bottom: 15px;" type="text" placeholder="Логин" id="LoginForm_username" name="LoginForm[username]">
									<input style="margin-bottom: 15px;" type="password" placeholder="Пароль" id="LoginForm_password" name="LoginForm[password]">
									<input type="hidden" value="<?php echo Yii::app()->request->csrfToken?>" name="<?php echo Yii::app()->request->csrfTokenName?>" />
									<input class="btn btn-primary btn-block" name="yt0" type="submit" value="Войти">
								</form>
							</p>
						</li>
					</ul>
					<?php else: ?>
					<a href="javascript:;" data-toggle="dropdown">
						<?php echo Yii::app()->user->name ?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<?php echo CHtml::link(
									'<i class="icon-globe"></i> Админцентр',
									Yii::app()->createUrl('/admin/index')
								)
							?>
						</li>
						<li>
							<hr />
						</li>
						<li>
							<?php echo CHtml::link(
									'<i class="icon-off"></i> Выйти',
									Yii::app()->createUrl('/site/logout')
								)
							?>
						</li>
					</ul>
					<?php endif; ?>
				</li>
			</ul>
		</div>
	</div>
	</div>

<div id="wrapper" class="clearfix">
	
	<div id="wrap">
		<div class="container" id="page">
			<br />

			<?php echo $content; ?>

			<div class="clear"></div>
			<div id="push"></div>
		</div>
	</div>
	<br />
	<div id="copyright">
		<div class="container">
			<div class="row">
				<div id="rights" class="grid-6">
					<b>Design by</b> <a href="http://Servachoc.NET/">Servachoc.NET</a>
				</div>
				<div id="totop" class="grid-6">
					© 2014 - <?php echo date('Y') ?>
					<?php echo CHtml::link(
							'Servachoc.NET Team',
							'http://Servachoc.NET',
							array(
								'target' => '_blank'
							)
						)
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="loading">
	<h1>Загрузка</h1>
	<div class="circle"></div>
	<div class="circle1"></div>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/theme.js"></script>
</body>
</html>