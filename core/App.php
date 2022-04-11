<?php

class App
{
    private $router;

    public function __construct()
    {
        //load file hệ thống
        $this->system_load();
        $this->connectDatabase();

        //chạy router
        $this->router = new Router();
    }

    public function run()
    {
        $this->setting_env();
        //chạy router đầu tiên
        $this->router->run();
    }

    private function system_load()
    {
        $autoloads = [
            'Autoload',
            'Functions',
            'Router',
            'Class_control',
            'Request',
            'Controller',
            'Model',
            'Database'
        ];

        //load file hệ thống
        foreach ($autoloads as $file) {
            require_once('./core/' . $file . '.php');
        }

        new Autoload();

        //load thư viện ngoài
        if(file_exists(dirname(__FILE__).'/../vendor/autoload.php')){
            require_once(dirname(__FILE__).'/../vendor/autoload.php');
        }

    }

    private function setting_env(){

        if(ENV == 'development'){
            //seting xuất all log
            error_reporting(E_ALL);
            //setting ini.php hiện lỗi
            ini_set('display_errors',1);
            //setting error function
            set_error_handler('showError');
        }
    }

    private function connectDatabase()
    {
        include_once ('./config/database.php');
        $databaseDriverName = DATABASE['database_default']['driver'].'Driver';
        require ('./libraries/database/database_drivers/'.$databaseDriverName.'.php');
    }
}
