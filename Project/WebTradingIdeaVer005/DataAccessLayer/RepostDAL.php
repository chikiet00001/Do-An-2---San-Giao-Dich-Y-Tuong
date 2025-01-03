<?php 
require_once __DIR__ . '/../DataAccessLayer/dbconfig.php';

class RepostDAL{
    private $db;

    public function __construct() {
        $this->db = new dbconfig();
    }

    public function addRepost($contenttype, $reason, $idreportinguser, $idreporteduser) {
        $query = "INSERT INTO reposts (contenttype, reason, idreportinguser, idreporteduser) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("ssii", $contenttype, $reason, $idreportinguser, $idreporteduser);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function getReposts() {
        $query = "SELECT r.idrepost, r.contenttype, r.reason, r.statusrepost, r.createatrepost, 
                         r.idreportinguser, r.idreporteduser, u1.username AS reporting_user, u2.username AS reported_user, r.idpost
                  FROM reposts r 
                  JOIN users u1 ON u1.iduser = r.idreportinguser
                  JOIN users u2 ON u2.iduser = r.idreporteduser
                  WHERE r.contenttype = 'post' AND r.statusrepost = 'pending'";
        
        $result = $this->db->conn->query($query);
        $reposts = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reposts[] = $row;
            }
        }
        
        return $reposts;
    }

    public function updateStatus($idRepost, $statusRepost) {
        $stmt = $this->db->conn->prepare("UPDATE reposts SET statusrepost = ? WHERE idrepost = ?");
        $stmt->bind_param("si", $statusRepost, $idRepost);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function __destruct(){
        $this->db->close();
    }
}
?>