<?php 
require_once __DIR__ . '/../DataAccessLayer/UserDAL.php';

class UserBLL{
    private $userDAL;

    public function __construct() {
        $this->userDAL = new UserDAL();
    }

    public function UserLogin($username, $password) {
        $userCount = $this->userDAL->UserLogin($username, $password);

        if ($userCount > 0) {
            return true; // Đăng nhập thành công
        } else {
            return false; // Đăng nhập thất bại
        }
    }

    public function Userregister($username, $password, $email, $fullname) {
        // Kiểm tra tính hợp lệ của dữ liệu đầu vào
        if (empty($username) || empty($password) || empty($email) || empty($fullname)) {
            return "Tất cả các trường đều là bắt buộc.";
        }

        // Kiểm tra định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Địa chỉ email không hợp lệ.";
        }
        if($this->userDAL->checkEmailExists($email)){
            return "Email đã tồn tại trong hệ thống!";
        }else if ($this->userDAL->checkUsernameExists($username)){
            return "Username đã tồn tại trong hệ thống!";
        }
        if ($this->userDAL->UserRegister($username, $password, $email, $fullname)) {
            return "Đăng ký thành công!";
        } else {
            return "Đăng ký thất bại. Vui lòng thử lại.";
        }
    }

    public function UserDetails($username) {
        // Kiểm tra tính hợp lệ của tên đăng nhập
        if (empty($username)) {
            return "Tên đăng nhập không được để trống.";
        }

        // Gọi phương thức DAL để lấy thông tin người dùng
        $userDetails = $this->userDAL->UserDetails($username);

        if ($userDetails) {
            return $userDetails; // Trả về mảng chi tiết người dùng
        } else {
            return "Người dùng không tồn tại.";
        }
    }

    public function getUserIdByUsername($username) {
        if (empty($username)) {
            throw new Exception("Username không được để trống");
        }

        return $this->userDAL->getUserIdByUsername($username);
    }

    public function insertComment($commentpost, $iduser, $idpost) {
        // Kiểm tra đầu vào
        if (empty($commentpost) || empty($iduser) || empty($idpost)) {
            throw new InvalidArgumentException("Tất cả các trường phải được điền đầy đủ.");
        }

        // Gọi phương thức DAL để chèn comment
        $lastId = $this->userDAL->insertComment($commentpost, $iduser, $idpost);

        if ($lastId) {
            return $lastId; // Trả về ID của comment vừa được chèn
        } else {
            throw new Exception("Không thể chèn comment vào cơ sở dữ liệu.");
        }
    }

    public function ProfileMe($username) {
        // Kiểm tra nếu username không trống
        if (empty($username)) {
            throw new InvalidArgumentException("Username không được để trống.");
        }

        // Gọi DAL để lấy thông tin người dùng
        $user = $this->userDAL->ProfileMe($username);

        if ($user) {
            return $user; // Trả về thông tin người dùng
        } else {
            throw new Exception("Không tìm thấy người dùng với username '$username'.");
        }
    }

    public function updatePassword($username, $newPassword) {
        return $this->userDAL->updatePassword($username, $newPassword);
    }

    public function __destruct() {
        unset($this->userDAL); // Dọn dẹp đối tượng
    }
}
?>