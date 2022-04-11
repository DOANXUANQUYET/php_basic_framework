<?php

class Request{

    public static function post($name)
    {
        return $_POST[$name] ?? null;
    }

    public static function get($name)
    {
        return $_GET[$name] ?? null;
    }

}
