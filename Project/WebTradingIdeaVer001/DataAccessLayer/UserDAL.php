
<?php 
require_once __DIR__ . '/../DataAccessLayer/dbconfig.php';

class UserDAL{
    private $db;

    public function __construct() {
        $this->db = new dbconfig();
    }

    public function UserLogin($username, $password){
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS user_count FROM users WHERE username = ? AND passwd = ?");
        $stmt->bind_param("ss", $username, $password); // Bảo vệ khỏi SQL injection
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); // Lấy kết quả truy vấn dưới dạng mảng

        $stmt->close();

        // Kiểm tra nếu cột 'user_count' tồn tại trong mảng
        return isset($row['user_count']) ? $row['user_count'] : 0; // Trả về số lượng người dùng tìm thấy
    }

    public function UserRegister($username, $password, $email, $fullname) {
        // Truy vấn SQL để chèn người dùng mới vào cơ sở dữ liệu
        $stmt = $this->db->conn->prepare("INSERT INTO users (username, passwd, email, fullname) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $fullname); // Bind tham số vào câu truy vấn SQL

        $isInserted = $stmt->execute(); // Thực thi câu lệnh

        $stmt->close();

        return $isInserted; // Trả về true nếu thêm thành công, false nếu thất bại
    }

    public function checkEmailExists($email) {
        // Câu lệnh SQL kiểm tra email
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS email_count FROM users WHERE email = ?");
        $stmt->bind_param("s", $email); // Bind email để tránh SQL Injection
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        // Trả về true nếu email tồn tại, false nếu không
        return $row['email_count'] > 0;
    }

    public function checkUsernameExists($username) {
        // Câu lệnh SQL kiểm tra username
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS username_count FROM users WHERE username = ?");
        $stmt->bind_param("s", $username); // Bind usernmae để tránh SQL Injection
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        // Trả về true nếu username tồn tại, false nếu không
        return $row['username_count'] > 0;
    }

    public function UserDetails($username) {
        $stmt = $this->db->conn->prepare("
            SELECT iduser, username, passwd, email, fullname, dod, organize, 
                   phonenumber, address, createdat, updatedat, status, role
            FROM users WHERE username = ?
        ");
        $stmt->bind_param("s", $username); // Bind tham số username
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        // Trả về mảng chứa thông tin người dùng hoặc null nếu không tìm thấy
        return $row ? $row : null;
    }

    public function getUserIdByUsername($username) {
        $stmt = $this->db->conn->prepare("SELECT iduser FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
    
        $result = $stmt->get_result(); // Lấy kết quả trả về dưới dạng ResultSet
        $row = $result->fetch_assoc(); // Lấy dòng đầu tiên
    
        $stmt->close();
    
        return $row ? (int)$row['iduser'] : null; // Trả về null nếu không có kết quả
    }

    public function insertComment($commentpost, $iduser, $idpost) {
        // Chuẩn bị câu lệnh SQL để chèn dữ liệu
        $stmt = $this->db->conn->prepare("INSERT INTO comments (commentpost, iduser, idpost) VALUES (?, ?, ?)");
        
        // Liên kết tham số với câu lệnh SQL
        $stmt->bind_param("sii", $commentpost, $iduser, $idpost); // "s" cho string, "i" cho integer

        // Thực thi câu lệnh
        $stmt->execute();

        // Kiểm tra nếu việc chèn thành công
        if ($stmt->affected_rows > 0) {
            // Trả về ID của bản ghi vừa chèn (nếu cần)
            $lastId = $this->db->conn->insert_id;
            $stmt->close();
            return $lastId; // Trả về ID mới của comment vừa được thêm
        } else {
            $stmt->close();
            return false; // Trả về false nếu không có bản ghi nào được chèn
        }
    }

    public function ProfileMe($username) {
        // Chuẩn bị câu lệnh SQL để lấy thông tin người dùng theo username
        $stmt = $this->db->conn->prepare("SELECT iduser, username, passwd, email, fullname, dod, organize, phonenumber, address, createdat, updatedat, status, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username); // "s" cho kiểu chuỗi

        // Thực thi câu lệnh
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra và trả về kết quả
        if ($result->num_rows > 0) {
            // Trả về dữ liệu người dùng dưới dạng mảng
            return $result->fetch_assoc();
        } else {
            return null; // Không tìm thấy người dùng
        }

        $stmt->close();
    }

    public function updatePassword($username, $newPassword) {
        $stmt = $this->db->conn->prepare("UPDATE users SET passwd = ? WHERE username = ?");
        $stmt->bind_param("ss", $newPassword, $username);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function __destruct(){
        $this->db->close();
    }
}
?>
