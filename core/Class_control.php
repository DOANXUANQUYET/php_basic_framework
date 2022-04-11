<?php

/*
 * Singleton
 * Design pattern
 * Chỉ cho phép tạo một đối tượng duy nhất, tránh việc tạo nhiều đối tượng tốn bộ nhớ
*/

class Class_control
{
    private static $instance;
    private $storage = array();

    //để private tránh việc tạo đối tượng trực tiếp mà phải qua hàm control
    private function __construct()
    {
    }

    public static function instance()
    {
        if( !isset(self::$instance)){
            self::$instance = new Class_control;
        }
        return self::$instance;
    }

    /*
     * Registry
     * Design pattern
     * Quản lý các biến
     * */

    // dấu __function nó là một Magic methods
    public function __set($name, $value){
        if( !isset($this->storage[$name])){
            $this->storage[$name] = $value;
        }
    }

    // dấu __function nó là một Magic methods
    public function __get($name){
        if(isset($this->storage[$name])){
            return $this->storage[$name];
        }
        return null;
    }
}
