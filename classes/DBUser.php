<?php

class DBUser
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct()
    {
        $configFile = 'config.json';
        $configData = file_get_contents($configFile);
        $config = json_decode($configData, true);
        $databaseConfig = $config['database'];
        $this->conn = new mysqli($databaseConfig['host'], $databaseConfig['username'], $databaseConfig['password'], $databaseConfig['database_name'], $databaseConfig['port']);
        
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function GetConnection()
    {
        return $this->conn;
    }

    public function ExecuteQuery($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->affected_rows; // Return the ID of the inserted user
    }

    public function InsertFetchLastID($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function QueryScalar($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            return reset($row);
        }
        return null;
    }


    function Delete($table, $name)
    {
        $statement = $this->conn->prepare("DELETE FROM `$table` WHERE `name` = ?");
        $statement->bind_param("ss", $name);
        $statement->execute();
        return $statement->affected_rows;
    }
}
