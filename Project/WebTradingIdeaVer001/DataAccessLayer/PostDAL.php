<?php 
require_once __DIR__ . '/../DataAccessLayer/dbconfig.php';

class PostDAL{
    private $db;

    public function __construct() {
        $this->db = new dbconfig();
    }

    public function SelectALLPost($sql) {
        // Câu lệnh SQL
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $posts = [];

        // Lấy tất cả dữ liệu và lưu vào mảng
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        $stmt->close();
        return $posts; // Trả về danh sách bài đăng
    }

    public function PostsTopTime($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Pending'
            ORDER BY $orderpost DESC
            LIMIT 3");
        return $this->SelectALLPost($sql);
    }

    public function PostIdeas($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Pending' AND ideapost = 'idea'
            ORDER BY $orderpost DESC");
        return $this->SelectALLPost($sql);
    }

    public function PostSolutions($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Pending' AND ideapost = 'solution'
            ORDER BY $orderpost DESC");
        return $this->SelectALLPost($sql);
    }

    public function PostDetail($idpost) {
        // Câu lệnh SQL
        $stmt = $this->db->conn->prepare("
            SELECT p.idpost, p.titlepost, p.imagepost, p.contentpost, 
                   p.ideapost, p.createatpost, p.updatedatpost, 
                   u.fullname, u.iduser
            FROM posts p 
            JOIN users u ON p.iduser = u.iduser 
            WHERE p.idpost = ?
        ");
        $stmt->bind_param("i", $idpost); // Bind tham số để tránh SQL Injection
        $stmt->execute();

        $result = $stmt->get_result();
        $postDetails = $result->fetch_assoc(); // Lấy kết quả đầu tiên

        $stmt->close();

        // Trả về thông tin chi tiết bài đăng
        return $postDetails;
    }

    public function LikesPost($idpost) {
        // Câu lệnh SQL
        $stmt = $this->db->conn->prepare("
            SELECT COUNT(*) AS like_count 
            FROM likes l 
            JOIN posts p ON p.idpost = l.idpost 
            WHERE p.idpost = ?
        ");
        $stmt->bind_param("i", $idpost); // Bind tham số tránh SQL Injection
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); // Lấy kết quả

        $stmt->close();

        // Trả về số lượt thích
        return $row ?? ['like_count' => 0]; // Trả về 0 nếu không có kết quả
    }

    public function CommentsPost($idpost) {
        // Câu lệnh SQL
        $stmt = $this->db->conn->prepare("
            SELECT u.fullname, c.commentpost, c.updateadcmt, u.iduser
            FROM comments c
            JOIN posts p ON p.idpost = c.idpost
            JOIN users u ON c.iduser = u.iduser
            WHERE p.idpost = ?
        ");
        $stmt->bind_param("i", $idpost); // Bind tham số để tránh SQL Injection
        $stmt->execute();

        $result = $stmt->get_result();
        $comments = [];

        // Lấy tất cả kết quả
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        $stmt->close();

        // Trả về danh sách bình luận
        return $comments;
    }

    public function SearchPosts($searchKeyword) {
        // Phòng tránh SQL Injection bằng cách sử dụng Prepared Statements
        $sql = "SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.createatpost 
                FROM posts p 
                JOIN users u ON u.iduser = p.iduser
                WHERE statuspost = 'Pending' 
                AND (titlepost LIKE ? OR contentpost LIKE ?)";
        
        $stmt = $this->db->conn->prepare($sql);
        $searchTerm = "%$searchKeyword%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm); // Bind các tham số

        $stmt->execute();
        $result = $stmt->get_result();
        $posts = [];

        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        $stmt->close();
        return $posts;
    }

    public function MyPosts($username) {
        $query = "
            SELECT p.idpost, p.titlepost, p.imagepost, p.contentpost, p.ideapost, 
                   p.statuspost, p.createatpost 
            FROM posts p
            JOIN users u ON u.iduser = p.iduser
            WHERE u.username = ? ORDER BY createatpost DESC";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $username); // Liên kết tham số tránh SQL Injection
        $stmt->execute();
        $result = $stmt->get_result();
        
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        $stmt->close();
        return $posts;
    }

    public function deletePost($idpost) {
        $query = "DELETE FROM posts WHERE idpost = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $idpost); // Sử dụng bind_param để ngăn SQL Injection
        if ($stmt->execute()) {
            return true; // Thành công
        } else {
            return false; // Thất bại
        }
    }

    public function updatePost($idpost, $titlepost, $imagepost, $contentpost, $ideapost) {
        $sql = "UPDATE posts SET titlepost = ?, imagepost = ?, contentpost = ?, ideapost = ? WHERE idpost = ?";
        $stmt = $this->db->conn->prepare($sql);

        $stmt->bind_param("ssssi", $titlepost, $imagepost, $contentpost, $ideapost, $idpost);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertPost($titlepost, $imagepost, $contentpost, $ideapost, $iduser) {
        $sql = "INSERT INTO posts (titlepost, imagepost, contentpost, ideapost, iduser) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param("ssssi", $titlepost, $imagepost, $contentpost, $ideapost, $iduser);
        
        if ($stmt->execute()) {
            return true; // Thêm thành công
        } else {
            return false; // Thêm thất bại
        }
    }
    
    public function __destruct(){
        $this->db->close();
    }
}
?>