<?php namespace App\Models;

class Sqlite3Schema extends AbstractModel{
    public static function migrate(bool $rebuild = false){
        $commands = null;
        if($rebuild){
            $commands .= 'DROP TABLE IF EXISTS user;';
            $commands .= 'DROP TABLE IF EXISTS address;';
            $commands .= 'DROP TABLE IF EXISTS user_address;';
        }
        $commands .=     
            'CREATE TABLE IF NOT EXISTS user (
                user_id INTEGER PRIMARY KEY,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL
            );      
            CREATE TABLE IF NOT EXISTS address (
                address_id INTEGER NOT NULL PRIMARY KEY,
                street TEXT NOT NULL,
                city TEXT NOT NULL,
                state TEXT NOT NULL,
                zip INTEGER NOT NULL,
                phone INTEGER NOT NULL,
                type TEXT NOT NULL DEFAULT "Mailing"
            );
            CREATE TABLE IF NOT EXISTS user_address (
                user_id INTEGER NOT NULL,
                address_id INTEGER NOT NULL,
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
        $u = new User('sqlite3');
        $u->db->exec($commands);
        return $commands;
    }
    
    public static function getTableList() {
        $u = new User('sqlite3');
        $stmt = $u->db->query("select * from sqlite_master where type='table'
                                  ");
        $tables = [];
        while ($row = $stmt->fetchObject('models\Sqlite3Schema')) {
            $tables[] = $row;
        }
        
        return $tables;
    }
}