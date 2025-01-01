<?php 
require_once __DIR__ . '/../DataAccessLayer/dbconfig.php';

    class MessageDAL{
        private $db;

        public function __construct() {
            $this->db = new dbconfig();
        }
        
        public function MessageChat($userId) {
            $sql = "SELECT DISTINCT u.iduser, u.username, u.fullname, u.email
                    FROM messages s
                    JOIN users u ON u.iduser = s.idusersender OR u.iduser = s.iduserreceiver
                    WHERE (idusersender = ? OR iduserreceiver = ?) AND u.iduser != ?
                    ORDER BY timestampmessage DESC";
    
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bind_param("iii", $userId, $userId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
    
            $stmt->close();
            return $users;
        }

        public function __destruct(){
            $this->db->close();
        }
    }

?>