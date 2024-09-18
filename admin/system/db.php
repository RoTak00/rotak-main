<?php

class DB
{
    private $conn;

    public function __construct($SERVERNAME, $USERNAME, $PASSWORD, $DATABASE)
    {


        $this->conn = new mysqli($SERVERNAME, $USERNAME, $PASSWORD, $DATABASE);


        // Check connection
        if ($this->conn->connect_error) {
            //AddAlert("Eroare la conectare la baza de date.", "danger");
            die("Connection failed: " . $this->conn->connect_error);
        }

        $this->conn->query('set character_set_client=utf8');
        $this->conn->query('set character_set_connection=utf8');
        $this->conn->query('set character_set_results=utf8');
        $this->conn->query('set character_set_server=utf8');
    }

    public function __destruct()
    {
        $this->conn->close();
    }


    public function query($query)
    {
        return $this->conn->query($query);
    }

    public function error()
    {
        return $this->conn->error;
    }
}