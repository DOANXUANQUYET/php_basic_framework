<?php

class Controller
{

    public function load_view($viewName,$data = [])
    {
        $view_path = str_replace('.','/',$viewName);
        if(isset($data['page'])){
            $data['page'] = str_replace('.','/',$data['page']);
        }

        if(!file_exists('views/'.$view_path.'.php')){
            return false;
        }
        extract($data);
        require ('views/'.$view_path.'.php');
    }

    public function load_model($modelName)
    {
        $modelName .= 'Model';
        if(!file_exists('models/'.$modelName.'.php')){
            return false;
        }
        require ('models/'.$modelName.'.php');
        $this->{$modelName} = new $modelName();
    }

    public function redirect($url, $is_end = true, $resp_code = 302){
        header('Location:'.$url,true,$resp_code);
        if($is_end){
            die();
        }
    }

    public static function show404Error()
    {
        (new Controller())->load_view('layout.404');
    }

}
