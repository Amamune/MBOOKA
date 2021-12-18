<?php
session_start();
class dbConnect
    {
        public $connection;

        public function __construct()
        {
            $this->db_connect();
        }
       
        public function db_connect()
        {
            $this->connection = new mysqli('localhost','root','','movieDB'    );
            if ($this->connection->connect_error) {
                die("Database Connection Error: " + $this->connection->connect_error);
            }
        }

        public function clean($a)
        {
            $return = mysqli_real_escape_string($this->connection,$a);
            return $return;
        }


    }
?>