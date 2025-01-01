<?php 
require_once __DIR__ . '/../DataAccessLayer/NotificationsDAL.php';

class NotificationsBLL{
    private $notificationsDAL;

    public function __construct() {
        $this->notificationsDAL = new NotificationsDAL();
    }

    public function createNotification($contentNotification, $idUser) {
        return $this->notificationsDAL->insertNotification($contentNotification, $idUser, FALSE);
    }

    public function getUnreadNotificationCount($username) {
        if (empty($username)) {
            throw new Exception("Username cannot be empty.");
        }
        return $this->notificationsDAL->countUnreadNotificationsByUsername($username);
    }

    public function getUserNotifications($username) {
        if (empty($username)) {
            throw new Exception("Username cannot be empty.");
        }

        // Lấy thông báo từ DAL
        $notifications = $this->notificationsDAL->getUserNotifications($username);

        // Xử lý logic (nếu cần, như lọc, phân trang,...)
        return $notifications;
    }

    public function updateNotificationStatus($iduser) {
        if (empty($iduser) || !is_numeric($iduser)) {
            throw new Exception("ID người dùng không hợp lệ.");
        }

        // Gọi DAL để thực hiện cập nhật trạng thái thông báo
        $this->notificationsDAL->updateNotificationStatus($iduser);
    }

    public function __destruct() {
        unset($this->notificationsDAL); // Dọn dẹp đối tượng
    }
}

?>