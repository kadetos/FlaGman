<?php
    if (!defined('SVV'))  exit ("Hacking Attempt");
    
    /*Настрйока пунктов меню в шапке*/
    $menu = array(
        array('title' => 'главная', 'url' => '/'),
        array('title' => 'Вконтакте', 'url' => 'http://vk.com/servachocnet'),
        array('title' => 'Инструкция', 'url' => 'https://www.youtube.com/watch?v=3RvuqloHKkg&feature=youtu.be')
        );
    
    
    /*Настройка Заголовка*/
    $title = "Игровые сервера Servachoc.NET";
    
    /*Настройка подключения к БД бан систем*/
    /* Пример для нескольких бан систем
        $bansystem = array(
        array('id' => '0', 'host' => 'localhost', 'user' => 'bans_iplaycs', 'password' => 'gbMhhbHXxc', 'database' => 'bans_iplaycs'),
                );
     
     */
    $bansystem = array(
        array('id' => '0', 'host' => 'localhost', 'user' => 'pass', 'password' => 's56g56', 'opopopop' => '56ghr567')
        );
    
    /*Настройка запрещенных имен при регистрации*/
    $black_list_names = array('cs16', 'cs 1.6', 'boost.ua');
    
    /*Включить регистрацию ника?*/
    $allow_nick_reg = TRUE; // TRUE - да, FALSE - нет
    
    /*Сколько раз за все время администрирования можно сменить имя*/
    $numbers_of_names = 5;
    
    /*Какой флаг выдавать при регистрации ника*/
    $access_f = "m";
    
    /*Показывать зарегистрированных в списке админов?*/
    $ashow = "0"; // 1 - да, 0 - нет