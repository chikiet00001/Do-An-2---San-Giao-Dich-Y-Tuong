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
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND visibilitypost != 'private'
            ORDER BY $orderpost DESC
            LIMIT 3");
        return $this->SelectALLPost($sql);
    }

    public function PostsTopTimeAnonymous($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND visibilitypost = 'public'
            ORDER BY $orderpost DESC
            LIMIT 3");
        return $this->SelectALLPost($sql);
    }

    public function PostIdeas($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND ideapost = 'idea' AND visibilitypost != 'private'
            ORDER BY $orderpost DESC");
        return $this->SelectALLPost($sql);
    }

    public function PostIdeasAnonymous($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND ideapost = 'idea' AND visibilitypost = 'public'
            ORDER BY $orderpost DESC");
        return $this->SelectALLPost($sql);
    }

    public function PostSolutions($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND ideapost = 'solution' AND visibilitypost != 'private'
            ORDER BY $orderpost DESC");
        return $this->SelectALLPost($sql);
    }

    public function PostSolutionsAnonymous($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND ideapost = 'solution' AND visibilitypost = 'public'
            ORDER BY $orderpost DESC");
        return $this->SelectALLPost($sql);
    }

    public function PostAll($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND visibilitypost != 'private'
            ORDER BY $orderpost DESC");
        return $this->SelectALLPost($sql);
    }

    public function PostAllAnonymous($orderpost){
        $sql = ("SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.$orderpost, p.descriptionpost
            FROM posts p 
            JOIN users u ON u.iduser = p.iduser
            WHERE statuspost = 'Approved' AND visibilitypost = 'public'
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
        $sql = "SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.createatpost, p.descriptionpost
                FROM posts p 
                JOIN users u ON u.iduser = p.iduser
                WHERE statuspost = 'Pending' 
                AND (titlepost LIKE ? OR contentpost LIKE ?) AND visibilitypost != 'private'";
        
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

    public function SearchPostsAnonymous($searchKeyword) {
        // Phòng tránh SQL Injection bằng cách sử dụng Prepared Statements
        $sql = "SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.createatpost, p.descriptionpost
                FROM posts p 
                JOIN users u ON u.iduser = p.iduser
                WHERE statuspost = 'Pending' 
                AND (titlepost LIKE ? OR contentpost LIKE ?) AND visibilitypost = 'public'";
        
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

    public function updatePost($idpost, $titlepost, $imagepost, $contentpost, $ideapost, $description, $visibility) {
        $sql = "UPDATE posts 
                SET titlepost = ?, imagepost = ?, contentpost = ?, ideapost = ?, descriptionpost = ?, visibilitypost = ? 
                WHERE idpost = ?";
        $stmt = $this->db->conn->prepare($sql);
    
        // Đảm bảo đúng thứ tự và kiểu dữ liệu
        $stmt->bind_param("ssssssi", $titlepost, $imagepost, $contentpost, $ideapost, $description, $visibility, $idpost);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertPost($titlepost, $imagepost, $contentpost, $ideapost, $iduser, $description, $visibility) {
        $sql = "INSERT INTO posts (titlepost, imagepost, contentpost, ideapost, iduser, descriptionpost, visibilitypost) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param("ssssiss", $titlepost, $imagepost, $contentpost, $ideapost, $iduser, $description, $visibility);
        
        if ($stmt->execute()) {
            return true; // Thêm thành công
        } else {
            return false; // Thêm thất bại
        }
    }

    public function PendingPosts() {
        $sql = "SELECT idpost, titlepost, imagepost, contentpost, ideapost, statuspost, createatpost, updatedatpost, iduser
                FROM posts 
                WHERE statuspost = 'Pending' AND visibilitypost != 'private'";

        $result = $this->db->conn->query($sql);

        if ($result === false) {
            // Log lỗi nếu cần
            error_log("Database query failed: " . $this->db->conn->error);
            return null; // Trả về null nếu truy vấn thất bại
        }

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        return $posts; // Trả về danh sách bài viết
    }

    public function approvePost($idpost, $newStatus) {
        // Chuẩn bị câu truy vấn
        $stmt = $this->db->conn->prepare("UPDATE posts SET statuspost = ? WHERE idpost = ?");
        
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->db->conn->error);
            return false;
        }

        // Gán giá trị cho câu truy vấn
        $stmt->bind_param("si", $newStatus, $idpost);

        // Thực thi câu truy vấn
        $result = $stmt->execute();

        // Kiểm tra kết quả
        if ($result === false) {
            error_log("Execute failed: " . $stmt->error);
        }

        // Đóng statement
        $stmt->close();

        return $result;
    }

    public function ignorePost($idpost, $newStatus) {
        // Chuẩn bị câu truy vấn
        $stmt = $this->db->conn->prepare("UPDATE posts SET statuspost = ? WHERE idpost = ?");
        
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->db->conn->error);
            return false;
        }

        // Gán giá trị cho câu truy vấn
        $stmt->bind_param("si", $newStatus, $idpost);

        // Thực thi câu truy vấn
        $result = $stmt->execute();

        // Kiểm tra kết quả
        if ($result === false) {
            error_log("Execute failed: " . $stmt->error);
        }

        // Đóng statement
        $stmt->close();

        return $result;
    }

    public function UserLikedPost($username, $postId) {
        $stmt = $this->db->conn->prepare("
            SELECT COUNT(l.idlike) AS like_count
            FROM likes l
            JOIN users u ON u.iduser = l.iduser
            JOIN posts p ON p.idpost = l.idpost
            WHERE u.username = ? AND p.idpost = ?
        ");
        $stmt->bind_param("si", $username, $postId); // "si" -> string, integer
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['like_count'] > 0;
    }

    public function deleteLike($postId, $userId) {
        $stmt = $this->db->conn->prepare("DELETE FROM likes WHERE idpost = ? AND iduser = ?");
        $stmt->bind_param("ii", $postId, $userId); // "ii" -> cả hai tham số đều là integer
        $result = $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true; // Xóa thành công
        } else {
            return false; // Không có dòng nào bị xóa
        }
    }

    public function addLike($userId, $postId) {
        $stmt = $this->db->conn->prepare("INSERT INTO likes (iduser, idpost) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $postId); // "ii" -> cả hai tham số đều là integer
        $result = $stmt->execute();

        if ($result) {
            return true; // Thêm thành công
        } else {
            return false; // Thêm thất bại (có thể do vi phạm khóa chính hoặc lỗi khác)
        }
    }

    public function __destruct(){
        $this->db->close();
    }
}
?>