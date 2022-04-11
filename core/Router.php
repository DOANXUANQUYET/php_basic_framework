<?php
// lấy router đã định nghĩa
require_once ('config/router.php');

class Router
{
    private static $routes = [];

    public function run()
    {

        $this->map_router();
    }

    private function get_request_url()
    {
        //lấy url request
        $url = ($_SERVER['REQUEST_URI']) ?? '/';

        // bỏ phần phía domain phía trước public
        $url = str_replace(BASE_URL, '', $url);
        if ($url == '' || empty($url)) {
            $url = '/';
        }
        return $url;
    }

    private function get_request_method()
    {
        return ($_SERVER['REQUEST_METHOD']) ?? 'GET';
    }

    private static function add_router($method, $url, $action)
    {
        self::$routes[] = [$method, $url, $action];
    }

    private function map_router()
    {
        //lấy url và method từ request gửi đến
        $request_url = $this->get_request_url();
        $request_method = $this->get_request_method();

        //lấy cái router đã được định nghĩa trong hệ thống
        $routers = self::$routes;

        $check_router = false;
        $params = array();

        //tìm router trùng với request để thực hiện hành động đã định nghĩa
        foreach ($routers as $router) {

            list($method, $url, $action) = $router;
            //search request_method có trong method đã định nghĩa
            if (strpos($request_method, $method) === FALSE) {
                continue;
            }

            //check mapping url
            if (strcmp($request_url, $url) == 0) {
                $check_router = true;
            }else{
                //Nếu không mapping với url đã define thì check xem có param hay k
                if (strpos($url, '{') === FALSE ){
                    continue;
                }
                if (strpos($url, '}') === FALSE ){
                    continue;
                }

                $request_router_param = explode('/', $request_url);
                $define_router_param = explode('/', $url);
                //nếu số param k mapping với số param đã định nghĩa
                if(count($request_router_param) !== count($define_router_param)){
                    continue;
                }

                //so sánh phần url không phải param (bỏ phần chứa param)
                $define_router_not_param = array_filter($define_router_param,function ($arr){
                     $check1 = (strpos($arr, '{') === false);
                     $check2 = (strpos($arr, '}') === false);
                     return $check1 && $check2;
                });

                $is_mapping = true;
                //so sánh phần k chứa param của router với url_request
                foreach ($define_router_not_param as $index => $value){
                    if(strcmp($value, $request_router_param[$index]) != 0 ){
                        $is_mapping = false;
                        break;
                    }
                }

                //nếu không mapping dừng
                if(!$is_mapping){
                    continue;
                }

                // array /url/{123}/{abc}/def...
                foreach ($define_router_param as $index => $value){
                    //nếu mapping regex {123456789abc...}
                    if(preg_match('/^{\w+}$/',$value)){
                        $params[] = $request_router_param[$index];
                    }
                }
                $check_router = true;
            }

            //check xem có phải hàm k?
            if ($params != null && is_callable($action)) {
                //gọi hàm với param
                call_user_func_array($action, $params);
                return;
            }else if(is_callable($action)){
                $action();
                return;
            }else{
                //trường hợp không phải function mà là chuỗi controller@function
                $check_router = $this->call_controller($action, $params);
                if($check_router){
                    return;
                }
            }
        }

        //nếu không mapping với route nào
        if(!$check_router){
            show404Error();
        }

    }

    private function call_controller($action, $param)
    {
        //controllerName@functionName
        $controller_string = explode('@',$action);

        //trường hợp sai định dạng controllerName@functionName@abc...
        if(count($controller_string) != 2){
            return false;
        }

        $controller_name = $controller_string[0];


        //nếu không tồn tại controller
        if(!file_exists('./controllers/'.$controller_name.'.php')){
            return false;
        }
        require_once ('./controllers/'.$controller_name.'.php');

        //đổi namespace để dùng autoload
        $controller_namespace = 'controllers\\'.$controller_name;
        if(!class_exists($controller_namespace)){
            return false;
        }

        Class_control::instance()->$controller_name = new $controller_namespace();

        $method_name = $controller_string[1];

        //Nếu không tồn tại method
        if(!method_exists($controller_namespace,$method_name)){
            return false;
        }

        if($param == null){
            Class_control::instance()->$controller_name->{$method_name}();
        }else{
            Class_control::instance()->$controller_name->{$method_name}($param);
        }
        return true;
    }

    public static function get($url, $action)
    {
        self::add_router('GET', $url, $action);
    }

    public static function post($url, $action)
    {
        self::add_router('POST', $url, $action);
    }

    public static function any($url, $action)
    {
        self::add_router('GET|POST', $url, $action);
    }
}