<?php

class MySQLDA
{
    private $_connection;

    public function __construct()
    {
        $this->_connection = MySQLConnectivity::getInstance()->getConnection();
    }

    public function select($table, $attr, $condition)
    {
        if ($condition == "") 
        {
            $sql = "SELECT " . $attr . " FROM " . $table;
        } 
        else 
        {
            $sql = "SELECT " . $attr . " FROM " . $table . " WHERE " . $condition;
        }
        return $this->_connection->query($sql);
    }

    public function insert($table, $data)
    {
        $fieldList = "";
        $valueList = "";

        foreach ($data as $key => $value) 
        {
            $fieldList .= $key . ",";
            $valueList .= "'" . $value . "',";
        }

        $fieldList = trim($fieldList, ",");
        $valueList = trim($valueList, ",");

        $sql = "INSERT INTO " . $table . "(" . $fieldList . ") VALUES (" . $valueList . ")";

        return $this->_connection->query($sql);
    }

    public function update($table, $data, $condition)
    {
        //Todo
        // Build query update
        // Thục thi query
        // Tra lại kết qủa sau khi update

        // Init empty update list
        $updateList = "";

        // Append new data to update list
        foreach ($data as $key => $value) 
        {
            $updateList .= $key . " = '" . $value . "',";
        }

        // Remove last "," 
        $updateList = trim($updateList, ",");

        // update query
        $sql = "UPDATE " . $table . " SET " . $updateList . " WHERE " . $condition;
    //    var_dump ($sql);
        return $this->_connection->query($sql);
    }

    public function delete($table, $condition)
    {
        $sql = "DELETE FROM " . $table . " WHERE " . $condition;
        return $this->_connection->query($sql);
    }

    public function lastId()
    {
        return $this->_connection->insert_id;
    }
}
