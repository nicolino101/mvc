<?php namespace MVC;

class Router{
    protected static $uri;
    protected static $queryStr;
    public static function route($routes): void { 
        self::setUri();
        self::routeFile();
        foreach($routes as $key => $val){ 
            if(ROOT_DIR.$key == self::$uri || ROOT_DIR.$key.'/' == self::$uri){
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
                exit;
            }
        }
        self::page401();
    }
    
    protected static function setUri() {
        self::$uri = $_SERVER['REQUEST_URI'];
        if(stristr(self::$uri, '?')){
            self::getRequest();
        }
        return;
    }
    
    private static function getRequest() { 
        foreach($_GET as $key=>$val){
            $_GET[$key]=strip_tags($val);
        }
        $parts = explode('?', self::$uri);
        self::$queryStr = $parts[1];  
        self::$uri = $parts[0];
        
    }
    
    protected static function routeFile() {
        if(!is_dir(APP_PATH.str_replace(ROOT_DIR, '', self::$uri)) && file_exists(APP_PATH.str_replace(ROOT_DIR, '', self::$uri))){
            require_once(APP_PATH.str_replace(ROOT_DIR, '', self::$uri));
            exit;
        }
        
    }
    
    protected static function page401() { 
        require_once(APP_PATH.'/401.html'); 
        exit;
    }
}
