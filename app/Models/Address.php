<?php namespace App\Models;

class Address extends AbstractModel{
    public $address_id;
    public $street;
    public $city;
    public $state;
    public $zip;
    public $phone;
    public $type;

    public function __construct($dbType = null){
        static::$dbtype = is_null($dbType) ? $this->getDbType() : $dbType;
        $this->conn();
    }
    
    public function fetchAll(){
        $sql = 'SELECT * FROM address';
        return $this->execute($sql);
    }
    
    public function fetchById(int $address_id){
        $sql = 'SELECT * FROM address WHERE address_id = :address_id';
        return $this->execute($sql, array('address_id' => $address_id));
    }
    
    public function insert(array $params){
        $sql = 'INSERT INTO address(street, city, state, zip, phone, type) VALUES(:street, :city, :state, :zip, :phone, :type)';
        $stmt = $this->db->prepare($sql);
        foreach($params as $key=>$val){
            if(property_exists($this, $key)){
                $stmt->bindValue($key, $val);
            }      
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    
    public function update(array $params, $where){
        $sql = 'UPDATE address set street=:street, city=:city, state=:state, zip=:zip, phone=:phone, type=:type WHERE '.$where;
        $stmt = $this->db->prepare($sql);
        foreach($params as $key=>$val){
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}