<?php
namespace App\Models;

class AbstractModel {
    protected $db;
    protected static $dbtype = 'sqlite';
    
    //chown -R www-data:www-data /var/www/deploy/db
    //LIVE: sqlite:/var/www/deploy/db/db1.sq3
    protected function conn(){
        switch(static::$dbtype){
            case "sqlite3":
                $dns = "sqlite:memory";
                $this->db = new \PDO($dns);
                break;
            case "mysql":
                $host = 'localhost';
                $dbname = 'testing';
                $user = 'root';
                $pass = '';
                $this->db = new \PDO('mysql:host=localhost;dbname=testing', $user);
                break;
            default:
                $dns = "sqlite:memory";
                $this->db = new \PDO($dns);
                break;
        }
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    // sets the db on the fly mysql || sqlite3
    public function setDbType($type = 'sqlite3'){
        static::$dbtype = $type;
    }
    
    public function getDBType(){
        return static::$dbtype;
    }
    
    protected function execute(string $sql, array $params = null){
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }else{
            return false;
        }
    }
    public function __call($method, $args) {
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
