<?php
    if (!defined('SVV'))  exit ("Hacking Attempt");
    include_once 'configs.php';
    
    /* От греха подальше  */
    function convert($string = '') 
    {   if(!empty($string))
        {   
            $convert = htmlspecialchars(trim($string));            
            return $convert ;                 
        }
    } 
    /* От греха подальше  */
    
    
    /* Логирование */
    function add_log($db, $action, $remarks) 
    {   
        $stmt = $db->prepare("INSERT INTO amx_logs (timestamp, ip, username, action, remarks) VALUES (:timestamp, :ip, :username, :action, :remarks)");
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':remarks', $remarks);
        $username = "Change System";
        $ip = $_SERVER['REMOTE_ADDR'];
        $timestamp = date('U');
        $stmt->execute();
    } 
    /* Логирование */
    
    
    /************************************/
    /*********** Смена пароля ***********/
    /************************************/
    
    if(isset($_POST['change_pass'])) {
        $name = convert($_POST['username']);
        $password = convert($_POST['password']);
        $new_password = convert($_POST['new_password']);
        $new_password_re = convert($_POST['new_password_re']);
        $server = explode('(|)', convert($_POST['server']));
        
        $access = TRUE;
        $message = array();
        $message[1] = NULL;
        if(!isset($name) || !isset($password) || !isset($new_password) || !isset($new_password_re) || !isset($server[0]) || !isset($server[1])) {
            $message[1] .= "- Заполните все поля<br/>"; 
            $access = FALSE;
        }
        
        if (!preg_match("#^[a-z0-9_\-/\s]+$#i", $name) || !preg_match("#^[a-z0-9_\-/\s]+$#i", $new_password) || !preg_match("#^[a-z0-9_\-/\s]+$#i", $password)){
            $message[1] .= "- Вводить разрешено только символы a-z и цифры<br/>"; 
            $access = FALSE;
        }
        
        if(mb_strlen($name, 'UTF-8') > 20 || mb_strlen($password, 'UTF-8') > 20) {
            $message[1] .= "- Превышена максимальная длина строки<br/>"; 
            $access = FALSE;
        }

        if($new_password != $new_password_re) {
            $message[1] .= "- Новый пароль и подтверждение  не совпадают<br/>"; 
            $access = FALSE;
        }
        
        if(mb_strlen($password, 'UTF-8') < 6 || mb_strlen($new_password, 'UTF-8') < 6) {
            $message[1] .= "- Пароль должен состоять минимум с 6 символов<br/>"; 
            $access = FALSE;
        }
        
        if(!is_numeric($server[0]) || $server[0] > count($bansystem)) {
            $message[1] .= "- Попытка подмены id сервера<br/>"; 
            $access = FALSE;
        }
        
        if($access == TRUE) {
            $db = new PDO("mysql:host={$bansystem[$server[0]]['host']};dbname={$bansystem[$server[0]]['database']}", $bansystem[$server[0]]['user'], $bansystem[$server[0]]['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("set names utf8");

            $stmt = $db->prepare("SELECT * FROM amx_amxadmins WHERE nickname=?");
            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            
            if($row != NULL) {
               if($row['password'] == md5($password)){
                    $password = md5($password);
                    $stmt = $db->prepare("UPDATE amx_amxadmins SET password = :password WHERE nickname=:nickname");
                    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                    $stmt->bindParam(':nickname', $name, PDO::PARAM_STR);
                    $stmt->execute();

                    add_log($db, "Change Password", "Пользователь $name сменил свой пароль");
                    $message[1] = "Вы успешно изменили свой пароль";

                    header("Refresh: 3; URL= index.php"); 
               } else {
                    $message[1] = "- Введен неверный пароль";
                    $access = FALSE;
                }
            } else {
                $message[1] = "- Пользователя не обнаружено<br/>"; 
                $access = FALSE;
            }
        }
      
        if($access == FALSE) {
            $message[0] = "danger";
            $message[2] = "Исправьте следующие ошибки:";
        } else {
            $message[0] = "success";
            $message[2] = "Поздравляем:";
        }
 
        $alert = TRUE;
    }
    
    /************************************/
    /*********** Смена пароля ***********/
    /************************************/
    
    
    

    /************************************/
    /************ Смена ника ************/
    /************************************/
    
    if(isset($_POST['change_name'])) {
        $name = convert($_POST['username']);
        $new_name = convert($_POST['new_username']);
        $password = convert($_POST['password']);
        $server = explode('(|)', convert($_POST['server']));
        
        $access = TRUE;
        $message = array();
        $message[1] = NULL;
        if(!isset($name) || !isset($password) || !isset($new_name) || !isset($server[0]) || !isset($server[1])) {
            $message[1] .= "- Заполните все поля<br/>"; 
            $access = FALSE;
        }
        
        if(mb_strlen($password, 'UTF-8') < 6) {
            $message[1] .= "- Пароль должен состоять минимум с 6 символов<br/>"; 
            $access = FALSE;
        }
        
        if(mb_strlen($name, 'UTF-8') > 20 || mb_strlen($new_name, 'UTF-8') > 20) {
            $message[1] .= "- Превышена максимальная длина строки<br/>"; 
            $access = FALSE;
        }
        
        if (!preg_match("#^[a-z0-9_\-/\s]+$#i", $name) || !preg_match("#^[a-z0-9_\-/\s]+$#i", $new_name) || !preg_match("#^[a-z0-9_\-/\s]+$#i", $password)){
            $message[1] .= "- Вводить разрешено только символы a-z и цифры<br/>"; 
            $access = FALSE;
        }
        
        if(!is_numeric($server[0]) || $server[0] > count($bansystem)) {
            $message[1] .= "- Попытка подмены id сервера<br/>"; 
            $access = FALSE;
        }
        
        if($access == TRUE) {
            $db = new PDO("mysql:host={$bansystem[$server[0]]['host']};dbname={$bansystem[$server[0]]['database']}", $bansystem[$server[0]]['user'], $bansystem[$server[0]]['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("set names utf8");

            $stmt = $db->prepare("SELECT * FROM amx_amxadmins WHERE nickname=?");
            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            
            
            if($row != NULL) {
                if($row['password'] != md5($password)) {
                    $message[1] = "- Введен неверный пароль";
                    $access = FALSE;
                }
                if($access == TRUE) {
                    $stmt = $db->prepare("SELECT * FROM amx_admins_servers WHERE admin_id=?");
                    $stmt->bindValue(1, $row['id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $stmt->fetch();

                    if($row != NULL) {
                        $stmt = $db->query('SELECT * FROM amx_amxadmins');
            
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            if(strtolower($new_name) == strtolower($row['nickname'])) {
                                $message[1] = "- Данное имя уже занято";
                                $access = FALSE;
                                break;
                            }
                        }
                        
                        $stmt = $db->prepare("SELECT * FROM amx_amxadmins WHERE nickname=?");
                        $stmt->bindValue(1, $name, PDO::PARAM_STR);
                        $stmt->execute();
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $stmt->fetch();
                        
                        if($row['numbers_of_names'] > $numbers_of_names) {
                            $access = FALSE;
                            $message[1] = "- Возможности смены ника исчерпаны";
                        }
                           
                        
                        if($access == TRUE) {
                            $db->exec("UPDATE amx_amxadmins SET numbers_of_names = numbers_of_names + 1 WHERE nickname = '".$name."'");   
                            $stmt = $db->prepare("UPDATE amx_amxadmins SET nickname = :nickname WHERE nickname=:nickname_old");
                            $stmt->bindParam(':nickname', $new_name, PDO::PARAM_STR);
                            $stmt->bindParam(':nickname_old', $name, PDO::PARAM_STR);
                            $stmt->execute();
                            
                            add_log($db, "Change Name", "Пользователь $name сменил имя на $new_name");
                            $message[1] = "Вы успешно изменили свой ник";
                                   
                            header("Refresh: 3; URL= index.php"); 
                        }
                    }else {
                        $message[1] = "- Срок администрирования окончен";
                    }  
                } 
                
            } else {
                $message[1] = "- Пользователь не обнаружен";
            }
            $db = NULL;
        } 
        
        if($access == FALSE) {
            $message[0] = "danger";
            $message[2] = "Исправьте следующие ошибки:";
        } else {
            $message[0] = "success";
            $message[2] = "Поздравляем:";
        }
 
        $alert = TRUE;
        
    }
    
    /************************************/
    /************ Смена ника ************/
    /************************************/
    
    
    
    
    
    
    /************************************/
    /********* Регистрация ника *********/
    /************************************/
    
    if(isset($_POST['reg']) && $allow_nick_reg == TRUE){
        
        $name = convert($_POST['username']);
        $password = convert($_POST['password']);
        $password_re = convert($_POST['password_re']);
        $server = explode('(|)', convert($_POST['server']));
         
        $access = TRUE;
        $message = array();
        $message[1] = NULL;
        
        if(!isset($name) || !isset($password) || !isset($password_re) || !isset($server[0]) || !isset($server[1])) {
            $message[1] .= "- Заполните все поля<br/>"; 
            $access = FALSE;
        }
        
        foreach ($black_list_names as $bad_name) {
            if(strtolower($name) == $bad_name) {
                $message[1] .= "- Данный ник использовать запрещено<br/>"; 
                $access = FALSE;
                break;
            }
        }
        
        if(mb_strlen($name, 'UTF-8') > 20 || mb_strlen($password, 'UTF-8') > 20) {
            $message[1] .= "- Превышена максимальная длина строки<br/>"; 
            $access = FALSE;
        }
        
        if(mb_strlen($password, 'UTF-8') < 6) {
            $message[1] .= "- Пароль должен состоять минимум с 6 символов<br/>"; 
            $access = FALSE;
        }
        
        if($password != $password_re) {
            $message[1] .= "- Введенные пароли не совпадают<br/>"; 
            $access = FALSE;
        }

        if (!preg_match("#^[a-z0-9_\-/\s]+$#i", $name) || !preg_match("#^[a-z0-9_\-/\s]+$#i", $password)){
            $message[1] .= "- Вводить разрешено только символы a-z и цифры<br/>"; 
            $access = FALSE;
        }
        
        if(!is_numeric($server[0]) || !is_numeric($server[1]) || $server[0] > count($bansystem)) {
            $message[1] .= "- Попытка подмены id сервера<br/>"; 
            $access = FALSE;
        }
        
        if($access == TRUE) {
            
            $db = new PDO("mysql:host={$bansystem[$server[0]]['host']};dbname={$bansystem[$server[0]]['database']}", $bansystem[$server[0]]['user'], $bansystem[$server[0]]['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("set names utf8");

            $stmt = $db->prepare("SELECT * FROM amx_serverinfo WHERE id=?");
            $stmt->bindValue(1, $server[1], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $server_id = $row['id'];
            if($row != NULL) {
                $stmt = $db->query('SELECT * FROM amx_amxadmins');
            
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if(strtolower($name) == strtolower($row['nickname'])) {
                        $message[1] = "- Данное имя уже занято";
                        $access = FALSE;
                        break;
                    }
                }
                
                if($access == TRUE) {
                    
                    $stmt = $db->prepare("INSERT INTO amx_amxadmins (password, access, flags, steamid, nickname, ashow, created, expired, days, icq) "
                                    ."VALUES (:password, :access, :flags, :steamid, :nickname, :ashow, :created, :expired, :days, :icq)");
                    $stmt->bindParam(':password', $pass);
                    $stmt->bindParam(':access', $access_f);
                    $stmt->bindParam(':flags', $flags);
                    $stmt->bindParam(':steamid', $name);
                    $stmt->bindParam(':nickname', $name);
                    $stmt->bindParam(':ashow', $ashow);
                    $stmt->bindParam(':created', $created);
                    $stmt->bindParam(':expired', $expired);
                    $stmt->bindParam(':days', $days);
                    $stmt->bindParam(':icq', $icq);
                    $flags = "a";
                    $pass = md5($password);
                    $days = 0;
                    $created = date("U");
                    $expired = 0;
                    $stmt->execute();
                    $admin_id=$db->lastInsertId();

                    $stmt = $db->prepare("INSERT INTO amx_admins_servers (admin_id, server_id) VALUES (:admin_id, :server_id)");
                    $stmt->bindParam(':admin_id', $admin_id);
                    $stmt->bindParam(':server_id', $server_id);
                    $stmt->execute();
                    
                    add_log($db, "New User", "Регистрация нового пользователя с ником $name");
                    $message[1] = "Вы успешно зарегистрировали свой ник";

                    header("Refresh: 3; URL= index.php"); 
                    
                }
                
            } else {
                $message[1] = "Попытка подмены id сервера";
            }
            $db = NULL;

        } 
        
        if($access == FALSE) {
            $message[0] = "danger";
            $message[2] = "Исправьте следующие ошибки:";
        } else {
            $message[0] = "success";
            $message[2] = "Поздравляем:";
        }
        
        $alert = TRUE;
    }
    
    /************************************/
    /********* Регистрация ника *********/
    /************************************/
    
    
    
    
    
    $servers = array();
    
    foreach ($bansystem as $system) {
        try {
            $db = new PDO("mysql:host={$system['host']};dbname={$system['database']}", $system['user'], $system['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("set names utf8");
            
            $stmt = $db->query('SELECT * FROM amx_serverinfo');
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $servers[] = array('s_id' => $row['id'], 'name' => $row['hostname'], 'bd_id' => $system['id']);
            }
            
            $rs = $db->query('SELECT * FROM amx_amxadmins LIMIT 0'); 
            $create = TRUE;
            for ($i = 0; $i < $rs->columnCount(); $i++) {
                $col = $rs->getColumnMeta($i);
                if($col['name'] == 'numbers_of_names') {
                    $create = FALSE;
                    break;
                } 
            }
            if($create == TRUE) {
                $db->query('ALTER TABLE `amx_amxadmins` ADD `numbers_of_names` INT NOT NULL ;');
            }
            
            $db = NULL;
            
        }
        catch(PDOException $error) {
            echo $error->getMessage();
            exit();
        }
        
            
    }
    
 