<?php

class Autoload
{
    function __construct()
    {
        /*
         * Mỗi khi một class được sử dụng trong file, và intepreter thất bại trong việc tìm thấy định nghĩa của class,
         * nó sẽ gọi cái spl_autoload_register này, để thử thêm một lần nữa.
         * (ví dụ :  nếu không tìm thấy class ABC,
         * thì hãy thử require file có tên là tên của class ABC cộng với hậu tố .class.php, relative với file hiện tại.)
         */
        spl_autoload_register([$this, '_autoload']);

    }

    private function _autoload($class)
    {
        $array = explode('\\', $class);  //namespace
        $class_name = end($array);
        $class_path = str_replace($class_name, '', $class);
        $file_path = ROOT_PATH . '\\' . $class_path . $class_name . '.php';
        if (file_exists($file_path)) {
            require_once($file_path);
        }
    }
}