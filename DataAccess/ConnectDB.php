<?php
class MySQLConnectivity{

    // Database metadata
    private $_hostname = "127.0.0.1";
    private $_username = "root";
    private $_password = "mypass";
    private $_database = "intern_manager";

    private $_connection;

    private static $_instance;

    private function __construct(){
        $this->_connection = new mysqli($this->_hostname, $this->_username, $this->_password, $this->_database);
        if ($this->_connection->connect_error){
            die ($this->_connection->connect_error);
        }
    }

    public static function getInstance(){
        if (is_null(static::$_instance)){
            static::$_instance = new static();
        }
        return static::$_instance;
    }

    public function getConnection(){
        return $this->_connection;
    }
}
