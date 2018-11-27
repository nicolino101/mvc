<?php
namespace App\Models;
 
class User extends AbstractModel
{ 
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $addresses = [];
    
    public function __construct($dbType = null){
        static::$dbtype = is_null($dbType) ? $this->getDbType() : $dbType;
        $this->conn();
    }
    
    public function fetchAll(){
        $sql = 'SELECT * FROM user';
        return $this->execute($sql);
    }
    
    public function fetchWithAddress(){
        $rows = $this->fetchAll();
        foreach($rows as $row){
            $ua = new UserAddress();
            $result = $ua->fetchByUserId($row->user_id);
            foreach($result as $r){
                $a = new Address();
                foreach($a->fetchById($r->address_id) as $address){
                    $row->addresses[] = $address;
                }
            }
        }
        return $rows;
    }
    
    public function fetchJoin(){
        $sql = 'SELECT user_id, name, email, password, street, city, state, zip, phone, type FROM user
                JOIN user_address USING(user_id)
                JOIN address USING(address_id)
                ';
        return $this->execute($sql);
    }
    
    public function fetchById(int $id){
        $sql = 'SELECT * FROM user WHERE user_id = :user_id';
        return $this->execute($sql, array('user_id' => $user_id));
    }
    
    public function fetchByName(string $name){
        $sql = 'SELECT * FROM user WHERE name LIKE("%:name%")';
        return $this->execute($sql, array('name' => $name));
    }
    
    public function insert(array $params){
        $sql = 'INSERT INTO user(name, email, password) VALUES(:name, :email, :password)';
        $stmt = $this->db->prepare($sql);
        foreach($params as $key=>$val){
            if($key == 'password'){
                $val = sha1($val);
            }
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    
    public function update(array $params, $where){
        $sql = 'UPDATE user set name=:name, email=:email, password=:password WHERE '.$where;
        $stmt = $this->db->prepare($sql);
        foreach($params as $key=>$val){
            if($key == 'password'){
                $val = sha1($val);
            }
            //$sql .= $key.'=:'.$key;
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    
    public function delete(int $id){
        $sql = 'DELETE FROM user WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue('id', $id);
        
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}
