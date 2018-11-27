<?php namespace App\Models;

class MysqlSchema extends AbstractModel{
    public static function migrate(bool $rebuild = false){
        $commands = null;
        if($rebuild){
            $commands .= 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;';
            $commands .= 'DROP TABLE IF EXISTS user;';
            $commands .= 'DROP TABLE IF EXISTS address;';
            $commands .= 'DROP TABLE IF EXISTS user_address;';
        } 
        $commands .= 
            'CREATE TABLE IF NOT EXISTS user (
                user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL
            );';
        $commands .= 
            'CREATE TABLE IF NOT EXISTS address (
                address_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                street VARCHAR(250) NOT NULL,
                city VARCHAR(25) NOT NULL,
                state VARCHAR(2) NOT NULL,
                zip INT(5) UNSIGNED NOT NULL,
                phone BIGINT(20) UNSIGNED NOT NULL,
                type VARCHAR(10) NOT NULL DEFAULT "Mailing",
                INDEX phone (phone),
	            INDEX type (type)
            );';
        $commands .= 
            'CREATE TABLE IF NOT EXISTS user_address (
                user_id INT(11) UNSIGNED NOT NULL,
                address_id INT(11) UNSIGNED NOT NULL,
                CONSTRAINT FK_user_address_user 
                FOREIGN KEY (user_id) 
                REFERENCES user (user_id) 
                ON DELETE CASCADE,
	            CONSTRAINT FK_address_user_address 
                FOREIGN KEY (address_id) 
                REFERENCES address (address_id) 
                ON DELETE CASCADE,
                PRIMARY KEY (user_id, address_id)
            );';
        
        $u = new User('mysql'); 
        $u->db->exec($commands);
        return $commands;
    }
    
    public function getTableList() {
        
        $stmt = $this->db->query("SHOW TABLES");
        var_dump($stmt); exit;
        $tables = [];
        while ($row = $stmt->fetchObject('models\MysqlSchema')) {
            $tables[] = $row;
        }
        
        return $tables;
    }
}