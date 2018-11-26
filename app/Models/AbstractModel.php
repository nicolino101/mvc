<?php
namespace App\Models;

class AbstractModel {
    public function __call($method, $args){
        if(preg_match('/set/', $method)){
            $m = lcfirst(str_replace('set', '', $method));
            if(property_exists($this, $m)){
                $this->$m = $args[0];
            }
        }
        if(preg_match('/get/', $method)){
            $m = lcfirst(str_replace('get', '', $method));
            if(property_exists($this, $m)){
                return $this->$m;
            }
        }
    }
}