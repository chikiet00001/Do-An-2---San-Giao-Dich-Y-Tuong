<?php 
require_once __DIR__ . '/../DataAccessLayer/PostDAL.php';

class PostBLL{
    private $postDAL;

    public function __construct() {
        $this->postDAL = new PostDAL();
    }

    public function PostsTopTime($orderpost) {
        // Gọi phương thức DAL để lấy danh sách bài đăng
        $posts = $this->postDAL->PostsTopTime($orderpost);

        if (empty($posts)) {
            return "Không có bài đăng nào đang chờ duyệt.";
        }

        return $posts; // Trả về danh sách bài đăng
    }

    public function PostIdeas($orderpost) {
        // Gọi phương thức DAL để lấy danh sách bài đăng
        $posts = $this->postDAL->PostIdeas($orderpost);

        if (empty($posts)) {
            return "Không có bài đăng nào đang chờ duyệt.";
        }

        return $posts; // Trả về danh sách bài đăng
    }

    public function PostSolutions($orderpost) {
        // Gọi phương thức DAL để lấy danh sách bài đăng
        $posts = $this->postDAL->PostSolutions($orderpost);

        if (empty($posts)) {
            return "Không có bài đăng nào đang chờ duyệt.";
        }

        return $posts; // Trả về danh sách bài đăng
    }

    public function PostDetail($idpost) {
        // Kiểm tra giá trị idpost hợp lệ
        if (!is_int($idpost) || $idpost <= 0) {
            return "ID bài đăng phải là một số nguyên dương.";
        }

        // Gọi DAL để lấy thông tin bài đăng
        $postDetails = $this->postDAL->PostDetail($idpost);

        if (!$postDetails) {
            return "Không tìm thấy bài đăng với ID này.";
        }

        return $postDetails; // Trả về thông tin bài đăng
    }

    public function LikesPost($idpost) {
        // Kiểm tra giá trị idpost hợp lệ
        if (!is_int($idpost) || $idpost <= 0) {
            return "ID bài đăng phải là một số nguyên dương.";
        }

        // Gọi DAL để đếm số lượt thích
        $likeCount = $this->postDAL->LikesPost($idpost);

        return $likeCount; // Trả về số lượt thích
    }

    public function CommentsPost($idpost) {
        // Kiểm tra giá trị idpost hợp lệ
        if (!is_int($idpost) || $idpost <= 0) {
            return "ID bài đăng phải là một số nguyên dương.";
        }

        // Gọi DAL để lấy danh sách bình luận
        $comments = $this->postDAL->CommentsPost($idpost);

        return $comments; // Trả về danh sách bình luận
    }
    
    public function getPendingPosts($searchKeyword) {
        // Gọi phương thức của DAL và lấy dữ liệu
        $posts = $this->postDAL->SearchPosts($searchKeyword);

        // Có thể thực hiện xử lý thêm với dữ liệu tại đây
        return $posts;
    }

    public function MyPosts($username){
        $posts = $this->postDAL->MyPosts($username);
        return $posts;
    }

    public function deletePost($idpost) {
        return $result = $this->postDAL->deletePost($idpost);
    }

    public function updatePost($idpost, $titlepost, $imagepost, $contentpost, $ideapost) {
        // Có thể thêm logic nghiệp vụ ở đây (vd: kiểm tra dữ liệu trước khi gửi xuống DAL)
        if (empty($titlepost) || empty($contentpost)) {
            return "Tiêu đề và nội dung không được để trống!";
        }

        // Gọi DAL để thực hiện câu lệnh UPDATE
        $result = $this->postDAL->updatePost($idpost, $titlepost, $imagepost, $contentpost, $ideapost);

        if ($result) {
            return "Cập nhật bài viết thành công!";
        } else {
            return "Cập nhật bài viết thất bại!";
        }
    }

    public function insertPost($titlepost, $imagepost, $contentpost, $ideapost, $iduser) {
        // Logic kiểm tra dữ liệu hợp lệ (nếu cần)
        if (empty($titlepost) || empty($contentpost) || empty($ideapost) || empty($iduser)) {
            return "Dữ liệu không hợp lệ.";
        }

        // Gọi DAL để thêm bài viết
        $result = $this->postDAL->insertPost($titlepost, $imagepost, $contentpost, $ideapost, $iduser);

        return $result ? "Thêm bài viết thành công." : "Thêm bài viết thất bại.";
    }

    public function __destruct() {
        unset($this->userDAL); // Dọn dẹp đối tượng
    }
}
?>