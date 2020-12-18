<?php

class Database
{
    public $DB_NAME         = 'test';
    public $USER            = 'root';
    public $PASSWORD        = '';

    public function dbConnect()
    {
        try
        {
            $db = new PDO("mysql:host=localhost;dbname=$this->DB_NAME","$this->USER","$this->PASSWORD");
            return $db;            
        }
        catch(PDOException $e)
        {
            print $e->getMessage();
        }
    }
}

$dbObject = new Database();
$dbObject->dbConnect();