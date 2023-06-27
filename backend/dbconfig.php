<?php
    class DB
    {
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $db="after_sales";
    
        // Create connection
        public $conn;
    
        // Check connection
        function __construct()
        {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);
            if ($this->conn->connect_error) {
                die("Error Occurred Please contact site admin: " . $conn->connect_error);
            }
        }
    }

    $db = new DB;
	