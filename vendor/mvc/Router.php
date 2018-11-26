<?php namespace MVC;

class Router{
    public static function route($routes){  
        $uri = $_SERVER['REQUEST_URI'];
        
        foreach($routes as $key => $val){ 
            if(stristr($uri, '?')){
                $uriparts = self::getRequest($uri);
                if(ROOT_DIR.$key == $uriparts[0] || ROOT_DIR.$key.'/' == $uriparts[0]){
                    $uri = $uriparts[0]; 
                }                
            }
            if(ROOT_DIR.$key == $uri || ROOT_DIR.$key.'/' == $uri){
                if(is_array($val)){ 
                    require_once(APP_PATH.$val['page']);
                    $controller = new $val['controller']();
                    if(isset($val['action'])){
                        $action = $val['action'];
                        $params = $val['params'];
                        $controller->{$action}($params);
                    }
                }else{
                    require_once(APP_PATH.$val);
                }
                return;
            }
        }
        require_once(APP_PATH.'/401.html'); return;
    }
    
    public static function getRequest($uri){
        foreach($_GET as $key=>$val){
            $_GET[$key]=strip_tags($val);
        }
        return $parts = explode('?', $uri);
        
        exit;
    }
}