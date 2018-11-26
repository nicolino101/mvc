<?php
spl_autoload_register(function ($name) {
    //var_dump($name);
    $p =__DIR__.'/'.str_replace("\\", "/", $name);
    
    require_once $p.'.php';
});


?>