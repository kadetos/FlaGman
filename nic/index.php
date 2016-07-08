<?php
define('SVV', true);
include_once './core.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Система регистрации ника, смены пароля и имени</title>

        <link rel="stylesheet" href="./themes/css/header-style.css"  type="text/css" />
        <link rel="stylesheet" href="./themes/css/font-awesome.css" type="text/css" />
        <link rel="stylesheet" href="./themes/css/tabs.css" type="text/css" />
        <link rel="stylesheet" href="./themes/css/bootstrap.css">
        <link rel="stylesheet" href="./themes/css/utility.css">
        <link rel="stylesheet" href="./themes/css/static.css">
        <link rel="stylesheet" href="./themes/css/theme.css" >
  
        <script src="./themes/js/jquery.min.js" type="text/javascript"></script>
        <script src="./themes/js/jquery-noconflict.js" type="text/javascript"></script>
        <script src="./themes/js/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="./themes/js/bootstrap.min.js" type="text/javascript"></script>

        

        <style >
            .expanded-top-wrapper { background-image: url(./themes/img/tp-bg.png) !important;}
            body { background-image: url(./themes/img/01.jpg)
        </style>
    </head>

<body class="tm-noblog  header-default layout-full headertype-default">

	<div class="layout-full-wrapper">
	
			
	
            <div class="header-top-wrapper">
                <div class="header-wrapper header-animated">
                    
                        <div class="tm-headerbar uk-clearfix uk-hidden-small">
                            <div class="tm-top-block tm-grid-block">
                                <nav class="tm-navbar uk-navbar" id="tmMainMenu">
                                    <ul class="uk-navbar-nav uk-hidden-small">
                                        <?php foreach ($menu as $li) echo "<li class=\"uk-parent\"><a href=\"{$li['url']}\">{$li['title']}</a></li>"; ?>  
                                    </ul>                                        

                                </nav>
                            </div>
                        </div>
                    
                </div>
            </div>


	
	
                <div class="heading-wrapper uk-container uk-container-center" id="tmHeading">
                    <section class="tm-heading uk-grid" >
					
                            <div class="uk-width-1-1">
                                <div class="">
                                    <div class="panel-content">
                                        <div class="mainheading-wrapper"  style="">
                                            <div class="heading-content heading-align-center" style="padding-bottom: 30px;">
                                                    <div class="heading-text-wrapper">
                                                            <div class="header_text uk-panel">
                                                                    <h1 style="font-size: 48px; color: #ffffff; font-weight: bold; text-transform: uppercase; "><?php echo $title; ?></h1>								<div class="clearfix"></div>
                                                            </div>
                                                    </div>
                                                                    <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="uk-width-1-1">
                            <div class="breadcrumbs-wrapper">
                                    <div class="breadcrumbs-container">
                                            <ul class="uk-breadcrumb"><li class="uk-active"><span>Система регистрации ника, смены пароля и имени</span></li></ul>
                                    </div>
                            </div>
                        </div>
                    </section>
		</div>
		

			<div class="mainbody-wrapper" id="tmMainBody">
			<div class="uk-container uk-container-center">
				<div class="tm-middle uk-grid" data-uk-grid-match data-uk-grid-margin>

										<div class="tm-main uk-width-medium-1-1">

						
                                                                                    



                                                                                                    
                        
    <div class="panel-content" style="text-align:center;">
        <div class="accordion bdt-content-tabs" id="bdtShowcase368">
                
                
        <ul class="nav nav-tabs">
            <?php if(isset($allow_nick_reg) && $allow_nick_reg == TRUE): ?>
            <li <?php if(!isset($_POST['change_name']) && !isset($_POST['change_pass'])) echo "class=\"active\""; ?>><a href="#reg" data-toggle="tab">Зарегистрировать ник</a></li>
            <?php endif; ?>
            <li <?php if(!isset($_POST['change_name']) && !isset($_POST['change_pass']) && $allow_nick_reg == FALSE || isset($_POST['change_name'])) echo "class=\"active\""; ?>><a href="#name" data-toggle="tab">Сменить ник</a></li>	
            <li <?php if(isset($_POST['change_pass'])) echo "class=\"active\""; ?>><a href="#pass" data-toggle="tab">Сменить пароль</a></li>	
        </ul>
                
	<div class="tab-content">
            <?php if(isset($alert) && $alert == TRUE): ?>                                                                                                   
                                <div class="uk-alert uk-alert-large uk-alert-<?php if(isset($message[0])) echo $message[0];?>" data-uk-alert="">
                                <h2><?php if(isset($message[2])) echo $message[2];?></h2>
                                <p><?php if(isset($message[1])) echo $message[1];?></p>
                                </div>   
            <?php endif; ?>
            <?php if(isset($allow_nick_reg) && $allow_nick_reg == TRUE): ?>
            <div class="tab-pane <?php if(!isset($_POST['change_name']) && !isset($_POST['change_pass'])) echo "active"; ?>" id="reg">
                            <div class="content">
                                
                                    <div class="login ">
                                        <form method="post" class="form-horizontal">

                                            <fieldset class="well">
                                                    <div class="login-wrapper">
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="username" class="required">
                                                                Введите ник:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                    <input type="text" name="username" id="username" value="" class="validate-username required" /></div>
                                                        </div>
                                                        <div class="control-group">
                                                        <div class="control-label">
                                                                <label id="password-lbl" for="password1" class="required">
                                                                 Введите пароль:</label>
                                                        </div>
                                                                 
                                                                    <div class="controls">
                                                                        <input type="password" name="password" id="password1" value="" class="validate-password required"  /></div>
                                                                    </div>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="password2" class="required">
                                                                Повторите пароль:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                    <input type="password" name="password_re" id="password2" value="" class="validate-username required"  />	</div>
                                                        </div>
                                                        
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="select" class="required">
                                                                Выберите сервер:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                        
                                                                        <select id="select" name="server">
                                                                            <?php foreach ($servers as $server)  echo "<option value=\"{$server['bd_id']}(|){$server['s_id']}\">{$server['name']}</option>"; ?> 
                                                                        </select>
                                                                    </div>
                                                        </div>
                                                        </div>
                                                        
                                                        <div class="controls bdt-button">
                                                            <button type="submit" name="reg" class="btn btn-primary" <?php if(isset($message) && $message[0]=='success') echo "disabled"; ?>>Зарегистрировать ник</button>
                                                        </div>

                                                </fieldset>
                                        </form>
                                    </div>
                            </div>
                        </div>
            <?php endif; ?>
                        <div class="tab-pane <?php if(isset($_POST['change_pass'])) echo "active"; ?>" id="pass">
                            <div class="content">
                                    <div class="login ">
                                        <form method="post" class="form-horizontal">

                                            <fieldset class="well">
                                                    <div class="login-wrapper">
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="username1" class="required">
                                                                Введите ник:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                    <input type="text" name="username" id="username1" value="" class="validate-username required"  /></div>
                                                        </div>
                                                        <div class="control-group">
                                                        <div class="control-label">
                                                                <label id="password-lbl" for="password3" class="required">
                                                                 Введите старый пароль:</label>
                                                        </div>
                                                                 
                                                                    <div class="controls">
                                                                        <input type="password" name="password" id="password3" value="" class="validate-password required"  /></div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="password4" class="required">
                                                                Введите новый пароль:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                    <input type="password" name="new_password" id="password4" value="" class="validate-username required" />	</div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="password5" class="required">
                                                                Повторите пароль:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                    <input type="password" name="new_password_re" id="password5" value="" class="validate-username required"  /></div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="select" class="required">
                                                                Выберите сервер:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                        
                                                                        <select id="select" name="server">
                                                                            <?php foreach ($servers as $server)  echo "<option value=\"{$server['bd_id']}(|){$server['name']}\">{$server['name']}</option>"; ?> 
                                                                        </select>
                                                                    </div>
                                                        </div>
                                                        </div>

                                                         <div class="controls bdt-button">
                                                            <button type="submit" name="change_pass" class="btn btn-primary" <?php if(isset($message) && $message[0]=='success') echo "disabled"; ?>>Сменить пароль</button>
                                                        </div>

                                                </fieldset>
                                        </form>
                                    </div>
                            </div>
                        </div>
			<div class="tab-pane <?php if(!isset($_POST['change_name']) && !isset($_POST['change_pass']) && $allow_nick_reg == FALSE || isset($_POST['change_name'])) echo "active"; ?>" id="name">
			<div class="content">
                                    <div class="login ">
                                        <form method="post" class="form-horizontal">

                                            <fieldset class="well">
                                                    <div class="login-wrapper">
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="username3" class="required">
                                                                Введите свой ник:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                    <input type="text" name="username" id="username3" class="validate-username required"  />  </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="username4" class="required">
                                                                Введите новый ник:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                    <input type="text" name="new_username" id="username4" value="" class="validate-username required" /></div>
                                                        </div>
                                                    <div class="control-group">
                                                        <div class="control-label">
                                                                <label id="password-lbl" for="password6" class="required">
                                                                 Введите свой пароль:</label>
                                                        </div>
                                                                 
                                                                    <div class="controls">
                                                                        <input type="password" name="password" id="password6" value="" class="validate-password required" /></div>
                                                                    </div>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label id="username-lbl" for="select" class="required">
                                                                Выберите сервер:</label>							
                                                            </div>
                                                                    <div class="controls">
                                                                        
                                                                        <select id="select" name="server">
                                                                            <?php foreach ($servers as $server)  echo "<option value=\"{$server['bd_id']}(|){$server['name']}\">{$server['name']}</option>"; ?> 
                                                                        </select>
                                                                    </div>
                                                        </div>
                                                        </div>

                                                         <div class="controls bdt-button">
                                                            <button type="submit" name="change_name" class="btn btn-primary" <?php if(isset($message) && $message[0]=='success') echo "disabled"; ?>>Сменить ник</button>
                                                        </div>

                                                </fieldset>
                                        </form>
                                    </div>
			</div>
		</div>	
        </div>
                
                
        </div>
    
    </div>

						
					</div>
					
		            		            		            
				</div>
			</div>
		</div>
	

			
		</div>		


	
			<div class="footer-wrapper" id="tmFooter">
                            <div class="uk-container uk-container-center">
                                <footer class="tm-footer" style="text-align: center;">
                                        | Powered by Vitaliy | Version 0.1 | &copy; 2014 | <a href="www.svv.name"> <b>www.SVV.name</b></a> |     
                                    </footer>
                            </div>
                        </div>
	

</body>
</html> 