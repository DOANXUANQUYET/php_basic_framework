<?php
    require('./config/config.php');
    //chạy file app vào hệ thống
    require_once(dirname(__FILE__) . '/core/App.php');

    $app = new App();
    $app->run();

/**
create database
$databaseDriverName = $config['database']['driver'].'Driver';
require ('libraries/database_drivers/'.$databaseDriverName.'.php');
$database = new $databaseDriverName($config['database']);

//create controller
require ('controllers/'.$controllerName.'.php');
$controller = new $controllerName($database);
**/


