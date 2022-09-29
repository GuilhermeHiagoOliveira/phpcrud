<?php

class Database
{
    public $db;
    public function getConnection()
    {
        $this->db = null;
        try {
            $db_name = 'crud';
            $db_host = 'localhost';
            $db_user = 'root';
            $db_pass = '';
            $db_port = 3306;
            $this->db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
        } catch (\Exception $e) {
            echo "Database could not be connected: " . $e->getMessage();
        }
        return $this->db;
    }
}
