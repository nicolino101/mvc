<?php namespace App\Controllers;

use App\Models\User;

class Index{
    public function __construct(){
        var_dump(__METHOD__); 
    }
    
    public function index(){
        echo '<pre>';
        var_dump($params = $_GET);
        $user = new User();
        $user->setFirstName($params['firstname']);
        $user->setLastName($params['lastname']);
        $user->setEmail($params['email']);
        echo '<pre>';
        var_dump($user);
    }
    
    public function user($params){
        
        $user = new User();
        $user->setFirstName($params['firstName']);
        $user->setLastName($params['lastName']);
        $user->setEmail($params['email']);
        echo '<pre>';
        var_dump($user);
        return $user;
    }
}