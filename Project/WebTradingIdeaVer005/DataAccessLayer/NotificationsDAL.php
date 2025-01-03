<?php 
require_once __DIR__ . '/../DataAccessLayer/dbconfig.php';

class NotificationsDAL{
    private $db;
    
    public function __construct() {
        $this->db = new dbconfig();
    }

    public function insertNotification($contentNotification, $idUser, $statusNotification) {
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->conn->prepare("INSERT INTO notifications (contentnotification, iduser, statusnotification) VALUES (?, ?, ?)");
        
        // Ràng buộc các tham số: "si?" có nghĩa là: s - chuỗi, i - số nguyên, ? là kiểu dữ liệu của cột tương ứng
        $stmt->bind_param("sis", $contentNotification, $idUser, $statusNotification);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function countUnreadNotificationsByUsername($username) {
        $query = "SELECT COUNT(*) AS unread_count 
                  FROM notifications n 
                  JOIN users u ON u.iduser = n.iduser 
                  WHERE n.statusnotification = FALSE AND u.username = ?";
        
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['unread_count'];
    }

    public function getUserNotifications($username) {
        $query = "SELECT n.contentnotification AS content, n.timestampnotification AS times 
                  FROM notifications n 
                  JOIN users u ON u.iduser = n.iduser 
                  WHERE u.username = ? ORDER BY n.timestampnotification DESC";

        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row; // Lưu mỗi thông báo vào mảng
        }

        return $notifications;
    }

    public function updateNotificationStatus($iduser) {
        // Câu lệnh SQL để cập nhật trạng thái thông báo
        $query = "UPDATE notifications SET statusnotification = 
        TRUE WHERE iduser = ?";

        // Chuẩn bị câu truy vấn
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $iduser); // 'i' là kiểu dữ liệu integer
        $stmt->execute();

        // Kiểm tra xem câu lệnh có thành công không
        if ($stmt->affected_rows > 0) {
            return true;  // Cập nhật thành công
        }
        
        return false; // Cập nhật không thành công
    }

    public function __destruct(){
        $this->db->close();
    }
}
?>