<?php namespace App\Models;

class UserAddress extends AbstractModel{
    public $user_id;
    public $address_id;

    public function __construct($dbType = null){
        static::$dbtype = is_null($dbType) ? $this->getDbType() : $dbType;       
        $this->conn();
    }
    
    public function fetchAll(){
        $sql = 'SELECT * FROM user_address';
        return $this->execute($sql);
    }
    
    public function fetchByUserId(int $user_id){
        $sql = 'SELECT * FROM user_address WHERE user_id = :user_id';
        return $this->execute($sql, array('user_id' => $user_id));
    }
    
    public function insert(array $params){
        $sql = 'INSERT INTO user_address(user_id, address_id) VALUES(:user_id, :address_id)';
        $stmt = $this->db->prepare($sql);
        foreach($params as $key=>$val){
            if(property_exists($this, $key)){
                $stmt->bindValue($key, $val);
            }      
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}