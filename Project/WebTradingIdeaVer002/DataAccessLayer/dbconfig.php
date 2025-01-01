<?php
class dbconfig{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public $conn;

    public function __construct($servername = "localhost", $username = "root", $password = "", $dbname = "trading_idea") {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->connect();// Kết nối với cơ sở dữ liệu
    }

    public function connect(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if($this->conn->connect_error)
            die("Kết Nối Thất Bại: " . $this->conn->connect_error);
    }

    public function close(){ // hàm đóng kết nối
        $this->conn->close();
    }
}   
?>