<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/RepostBLL.php';

session_start();
ob_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
$RepostBLL = new RepostBLL();

$id = isset($_GET['idpost']) ? intval($_GET['idpost']) : 0;
$postDetail = $PostBLL->PostDetail($id);
if(!empty($_SESSION['username'])){
    $iduser = $UserBll->getUserIdByUsername($_SESSION['username']);
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Ý Tưởng</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Lưu vị trí cuộn trước khi reload
        window.addEventListener('beforeunload', () => {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        // Khôi phục vị trí cuộn khi trang tải lại
        window.addEventListener('load', () => {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition, 10));
            }
        });
    </script>
            <style>
            .repost-btn {
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
                border-radius: 5px;
                font-size: 16px;
            }

            .repost-btn:hover {
                background-color: #45a049;
            }

            .repost-box {
                display: none;
                background-color: #f1f1f1;
                padding: 20px;
                margin-top: 20px;
                border-radius: 5px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 500px;
            }

            .repost-box textarea {
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .repost-box button {
                padding: 10px 20px;
                background-color: #008CBA;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 10px;
            }

            .repost-box button:hover {
                background-color: #007b9b;
            }

            #closeRepostBox {
                background-color: #f44336;
            }

            #closeRepostBox:hover {
                background-color: #e60000;
            }
        </style>
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
        
        <img style="max-width: 720px;" src="<?= htmlspecialchars($postDetail['imagepost']) ?>" alt="<?= htmlspecialchars($post['fullname']) ?>">
        <br>
        <div style="max-width: 960px; margin: 0 auto;">
        <?php echo $postDetail['contentpost'] ?>
        </div>
        <p><strong>Tác giả:</strong> <?= htmlspecialchars($postDetail['fullname']) ?></p>
        <p><strong>Thời điểm tạo:</strong> <?= htmlspecialchars($postDetail['createatpost']) ?></p>
        <p><strong>Thời Điểm cập nhật:</strong> <?= htmlspecialchars($postDetail['updatedatpost']) ?></p>
        <div class="actions">
            <a href="profile.php?iduser=<?= htmlspecialchars($postDetail['iduser']) ?>" style="color: inherit; text-decoration: none;">
                <button class="btn contact-btn" type="button">Thông tin tác giả</button>
            </a>
        </div>

        <?php 
        if(!empty($_SESSION['username'])){
            if (isset($_POST['submitRepost'])) {
                $RepostBLL->addRepost('post', $_POST['repostContent'], $iduser, $postDetail['iduser']);
            }
        ?>
        <button id="repostButton" class="repost-btn">🔁 Repost</button>
        <div id="repostBox" class="repost-box">
            
            <form action="" method="post">
                <label for="repostContent">Nội dung repost:</label>
                <textarea id="repostContent" name="repostContent" rows="4" cols="50" placeholder="Viết nội dung repost..."></textarea><br><br>
                <button type="submit" name="submitRepost">Repost</button>
                <button type="button" id="closeRepostBox">Hủy</button>
            </form>
        </div>
        <?php } ?>
    </section>

    <section class="feedback">
        <h2>Đánh giá và phản hồi</h2>
        <div class="rating">
            <?php $likePostDetail = $PostBLL->LikesPost($id) ?>
            <p>Đánh giá ý tưởng</p>
            <?php
                if(!empty($_SESSION['username'])){
                    $iduser = $UserBll->getUserIdByUsername($_SESSION['username']);
                    $userlike = $PostBLL->UserLikedPost($_SESSION['username'], $id);
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    if (isset($_POST['submitunlike'])) { // Kiểm tra nếu form được gửi
                        if($userlike)
                            $PostBLL->deleteLike($id, $iduser);
                    }
                    if (isset($_POST['submitlike'])) {
                        if(!$userlike)
                            $PostBLL->addLike($iduser, $id);
                    }
                    $userlike = $PostBLL->UserLikedPost($_SESSION['username'], $id);
                    echo '<meta http-equiv="refresh" content="0">';
                    exit;
                }
           ?>
            <div class="like-container">
                <?php if($userlike){ ?>
                    <form action="" method="post"  id="unlikeForm">
                        <button type="submit" id="likeButton" class="like-btn" name="submitunlike"> 👍 bạn đã thích</button>
                    </form>
                <?php }else{ ?>
                    <form action="" method="post" id="likeForm">
                        <button type="submit" id="likeButton" class="like-btn" name="submitlike"> 👍 thích</button>
                    </form>
                <?php } ?>
            </div>
            <?php } ?>

            <p>Lượt đánh giá tốt: <?= htmlspecialchars($likePostDetail['like_count']) ?> </p>
        </div>

        <!-- gữi phản hồi -->
        <?php
        if (!isset($_SESSION['username'])) {
            echo "Bạn chưa đăng nhập! Hãy đăng nhập để gửi phản hồi.";
        }else{
            echo $_SESSION['username'] . " bạn có thể gữi phản hồi.";
        }
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

        const repostButton = document.getElementById("repostButton");
        const repostBox = document.getElementById("repostBox");
        const closeRepostBox = document.getElementById("closeRepostBox");

        // Khi nhấn nút Repost, hiển thị hộp repost
        repostButton.addEventListener("click", function() {
            repostBox.style.display = "block";
        });

        // Khi nhấn nút "Hủy", ẩn hộp repost
        closeRepostBox.addEventListener("click", function() {
            repostBox.style.display = "none";
        });
    </script>
    
</body>
</html>
