<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';

session_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
 
$postCreateAtPost = $PostBLL->PostsTopTime("createatpost");
$postUpdateAtPost = $PostBLL->PostsTopTime("updatedatpost");
$id = isset($_GET['idpost']) ? intval($_GET['idpost']) : 0;
$postDetail = $PostBLL->PostDetail($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Ý Tưởng</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">Sàn Ý Tưởng</div>
        <nav>
            <ul class="menu">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="ideas.php?index=1">Ý tưởng</a></li>
                <li><a href="ideas.php?index=2">Giải pháp</a></li>
                <li><a href="about.html">Giới thiệu</a></li>
                <li><a href="contact.html">Liên hệ</a></li>
            </ul>
        </nav>
    </header>
    
    <!-- Idea Details -->
    <section class="idea-detail">   
        <h1><?= htmlspecialchars($postDetail['titlepost']) ?></h1>
        <img src="<?= htmlspecialchars($postDetail['imagepost']) ?>" alt="<?= htmlspecialchars($post['fullname']) ?>">
        <br><?php echo $postDetail['contentpost'] ?>
        <p><strong>Tác giả:</strong> <?= htmlspecialchars($postDetail['fullname']) ?></p>
        <p><strong>Thời điểm tạo:</strong> <?= htmlspecialchars($postDetail['createatpost']) ?></p>
        <p><strong>Thời Điểm cập nhật:</strong> <?= htmlspecialchars($postDetail['updatedatpost']) ?></p>
        <div class="actions">
            <a href="profile.php??iduser=<?= htmlspecialchars($postDetail['iduser']) ?>" style="color: inherit; text-decoration: none;">
                <button class="btn contact-btn">Liên hệ tác giả</button>
            </a>
        </div>
    </section>
    <section class="feedback">
        <h2>Đánh giá và phản hồi</h2>
        <div class="rating">
            <?php $likePostDetail = $PostBLL->LikesPost($id) ?>
            <p>Đánh giá ý tưởng</p>
            <p>Lượt đánh giá tốt: <?= htmlspecialchars($likePostDetail['like_count']) ?> </p>
        </div>

        <!-- gữi phản hồi -->
        <?php
        if (!isset($_SESSION['username'])) {
            echo "Bạn chưa đăng nhập! Hãy đăng nhập để gửi phản hồi.";
        }else{
            echo $_SESSION['username'] . " bạn có thể gữi phản hồi.";
        }
        $iduser = $UserBll->getUserIdByUsername($_SESSION['username']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Kiểm tra xem có phải là POST không
            if (isset($_POST['comfilm'])) {  // Kiểm tra xem nút gửi có được nhấn không
                $UserBll->insertComment(trim($_POST['feedback']), $iduser, $id);
            }
        }
        ?>
        
        <form class="feedback-form" method="post" id="feedbackForm">
            <textarea placeholder="Nhập phản hồi của bạn..." name="feedback" id="feedback" required></textarea>
            <button type="submit" class="btn submit-feedback-btn" name="comfilm">Gửi phản hồi</button>
        </form>

        <div class="feedback-list">
            <h3>Phản hồi từ cộng đồng:</h3>
            <?php 
            $CommentPostDetail = $PostBLL->CommentsPost($id);
            
            if (!empty($CommentPostDetail)) { // Kiểm tra có dữ liệu hay không
            ?>
                <ul>
                    <?php foreach ($CommentPostDetail as $comment): ?>
                        <li>
                            <strong><?= htmlspecialchars($comment['fullname']) ?>:</strong> 
                            <?= htmlspecialchars($comment['commentpost']) ?><br>
                            <h5><?= htmlspecialchars($comment['updateadcmt']) ?></h5>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php 
            } else {
                echo "<p>Chưa có bình luận nào.</p>";
            } 
            ?>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <p>© 2024 Đại học Nam Cần Thơ - Sàn Ý Tưởng. Liên hệ: lekhoa583@gmail.com</p>
        <div class="social-links">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
    </footer>
    <script>
        // Handle star rating
        const stars = document.querySelectorAll('.star');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                // Xóa lớp 'active' của tất cả các sao
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('active'); // Tô vàng các sao đến vị trí được nhấp
                    } else {
                        s.classList.remove('active'); // Bỏ tô vàng các sao sau vị trí nhấp
                    }
                });

                // Ghi lại giá trị đánh giá
                const rating = index + 1;
                console.log(`Rating selected: ${rating}`); // Xử lý rating tại đây nếu cần
            });
        });

        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            const feedback = document.getElementById('feedback').value.trim(); // Lấy nội dung và loại bỏ khoảng trắng thừa
            if (feedback.length < 10) {
                event.preventDefault(); // Ngăn biểu mẫu gửi đi
                alert('Vui lòng nhập ít nhất 10 ký tự!');
            }
        });
    </script>
    
</body>
</html>
