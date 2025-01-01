<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/NotificationsBLL.php';


session_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
$NotificationsBLL = new NotificationsBLL();

if(!empty($_SESSION['username'])){
    $postCreateAtPost = $PostBLL->PostsTopTime("createatpost");
    $postUpdateAtPost = $PostBLL->PostsTopTime("updatedatpost");
}else{
    $postCreateAtPost = $PostBLL->PostsTopTimeAnonymous("createatpost");
    $postUpdateAtPost = $PostBLL->PostsTopTimeAnonymous("updatedatpost");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sàn Ý Tưởng - Đại học Nam Cần Thơ</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .admin-button {
            text-decoration: none;
            color: #333; /* Màu chữ mặc định */
            background-color: transparent; /* Nền trong suốt */
            border-radius: 8px;
            border: none; /* Loại bỏ viền */
            transition: all 0.3s ease;
            width: 76px; /* Chiều rộng giống nút Hồ Sơ */
            text-align: center;
            display: inline-block;
            /* padding: 10px 0; Khoảng cách bên trong */
        }

        .admin-button i {
            font-size: 16px; /* Kích thước biểu tượng */
            margin-bottom: 8px; /* Khoảng cách với chữ */
            color: #000; /* Màu đen */
        }

        /* Hiệu ứng hover nút Admin */
        .admin-button:hover {
            background-color: #282c263e; /* Màu nền khi hover */
            color: white; /* Đổi màu chữ khi hover */
        }

        .admin-button:hover i {
            color: white; /* Đổi màu biểu tượng khi hover */
        }

        /* icon hồ sơ */
        .profile-button {
            text-decoration: none;
            color: #333;
            background-color: transparent; /* Nền trong suốt */
            border-radius: 8px;
            border: none; /* Loại bỏ viền */
            transition: all 0.3s ease;
            width: 76px;
            text-align: center;
            display: inline-block; /* Đảm bảo nút có thể hoạt động như một block element */
        }

        .profile-button i {
            font-size: 18px;
            margin-bottom: 8px;
            color: #000; /* Màu biểu tượng đen */
        }

        /* Hiệu ứng khi hover */
        .profile-button:hover {
            background-color: #282c263e; /* Màu nền khi hover */
            color: white; /* Đổi màu chữ khi hover */
            border-color: transparent; /* Không có viền khi hover */
        }

        .profile-button:hover i {
            color: white; /* Đổi màu biểu tượng thành trắng khi hover */
        }


        /* Nút Message */
        .message-button {
            text-decoration: none;
            color: #333; /* Màu chữ mặc định */
            background-color: transparent; /* Nền trong suốt */
            border-radius: 8px;
            border: none; /* Loại bỏ viền */
            transition: all 0.3s ease;
            width: 76px; /* Chiều rộng giống nút Hồ Sơ */
            text-align: center;
            display: inline-block;
        }

        .message-button i {
            font-size: 18px; /* Kích thước biểu tượng */
            margin-bottom: 8px; /* Khoảng cách với chữ */
            color: #000; /* Màu đen */
        }

        /* Hiệu ứng hover nút Message */
        .message-button:hover {
            background-color: #282c263e; /* Màu nền khi hover */
            color: white; /* Đổi màu chữ khi hover */
        }

        .message-button:hover i {
            color: white; /* Đổi màu biểu tượng khi hover */
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
<!-- Tìm Kiếm-->
    
        <div class="search-bar">
            <form action="ideas.php" method="GET">
            <button type="submit" style="float: left;"><i class="fas fa-search"></i></button>
                <input 
                    type="text" name="query" 
                    value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>" 
                    placeholder="Tìm kiếm ý tưởng hoặc giải pháp...">
            </form>
        </div>
        <?php if(empty($_SESSION['username'])){ ?>
        <div class="auth-buttons">
            <button class="btn login-btn">Đăng nhập</button>
            <button class="btn signup-btn">Đăng ký</button>
        </div>
        <?php }else{?>
            
            <div>
                <!-- Nút Admin -->
                <?php if($_SESSION['role'] == "admin" || $_SESSION['role'] == "moderator"){ ?>
                <a href="member-management.php" class="admin-button">
                    <i class="fas fa-user-shield"></i><br>
                    <h5>Quản trị</h5>   
                </a>
                <?php }?>

                <style>
                    #dialogBox {
                        display: none; /* Ban đầu ẩn đi */
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        width: 50%;
                        padding: 20px;
                        background: #fff;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        border-radius: 8px;
                        text-align: center;
                        z-index: 1000;
                    }

                    /* Màn hình nền mờ */
                    #overlay {
                        display: none;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.5);
                        z-index: 999;
                    }

                    .btn-close {
                        background-color: #dc3545;
                        color: white;
                    }
                </style>
                <!-- Message -->
                <?php 
                $loadNotifications = $NotificationsBLL->getUserNotifications($_SESSION['username']);
                $checkNotifications = $NotificationsBLL->getUnreadNotificationCount($_SESSION['username']);
                if($checkNotifications != 0){
                    
                ?>
                <button class="message-button btn-primary" id="notifyButton">
                    <i class="fas fa-envelope"></i><br>
                    <h5 style="color: #dc3545;">Tin Nhắn</h5>
                </button>
                <?php }else{?>
                    <button class="message-button btn-primary" id="notifyButton">
                        <i class="fas fa-envelope"></i><br>
                        <h5>Tin Nhắn</h5>
                    </button>
                <?php }?>

                <div id="dialogBox">
                    <?php 
                        if(isset($_POST['updateNotification'])){
                            $iduser = $UserBll->getUserIdByUsername($_SESSION['username']);
                            $NotificationsBLL->updateNotificationStatus($iduser);
                            echo '<meta http-equiv="refresh" content="0">';
                            exit;
                        }
                    ?>
                    <form action="" method="post">
                        <button type="submit" class="btn-close" id="closeButton" name="updateNotification">Đóng</button>
                    </form>
                    <div>
                        <?php 
                            try {
                                $notifications = $NotificationsBLL->getUserNotifications($_SESSION['username']);?>
                                <p style="color: #000;">Thông báo của người dùng: <?php echo htmlspecialchars($_SESSION['username']) ?></p><br>
                                <?php foreach ($notifications as $notification) { ?>
                                    <div style="border: 4px double green;" >
                                        <h3 style="color: #000;">Nội dung: <?php echo htmlspecialchars($notification['content']) ?> </h3>
                                        <p style="color: #000;">Thời gian: <?php echo htmlspecialchars($notification['times']) ?></p>
                                    </div>
                                <?php }
                            } catch (Exception $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        ?>
                    </div>
                </div>

                <script>
                    // JavaScript xử lý
                    const notifyButton = document.getElementById('notifyButton');
                    const closeButton = document.getElementById('closeButton');
                    const dialogBox = document.getElementById('dialogBox');
                    const overlay = document.getElementById('overlay');

                    // Mở hộp thoại
                    notifyButton.addEventListener('click', () => {
                        dialogBox.style.display = 'block';
                        overlay.style.display = 'block';
                    });

                    // Đóng hộp thoại
                    closeButton.addEventListener('click', () => {
                        dialogBox.style.display = 'none';
                        overlay.style.display = 'none';
                    });

                    // Đóng hộp thoại khi bấm vào nền mờ
                    overlay.addEventListener('click', () => {
                        dialogBox.style.display = 'none';
                        overlay.style.display = 'none';
                    });
                </script>

                <!-- Profile của mình -->
                <a href="profileme.php" class="profile-button" >
                    <i class="fas fa-user"></i><br>
                    <h5>Hồ Sơ</h5>
                </a>
            </div>
        <?php }?>
    </header>

    <!-- Banner -->
    <section class="banner">
        <h1>Biến ý tưởng thành hiện thực</h1>
        <p>Kết nối sinh viên và nhà đầu tư tại Đại học Nam Cần Thơ.</p>
        <a href="ideas.php?index=3"><button class="btn banner-btn">Khám phá ngay</button></a>
    </section>

    <!-- Categories -->
    <section class="categories">
        <h2>Danh mục nổi bật</h2>
        <div class="category-list">
            <div class="category">
                <i class="fas fa-laptop-code"></i>
                <h3>Công nghệ</h3>
                <p>50+ Ý tưởng</p>
            </div>
            <div class="category">
                <i class="fas fa-chart-line"></i>
                <h3>Kinh doanh</h3>
                <p>30+ Ý tưởng</p>
            </div>
            <div class="category">
                <i class="fas fa-leaf"></i>
                <h3>Môi trường</h3>
                <p>20+ Ý tưởng</p>
            </div>
            <div class="category">
                <i class="fas fa-heartbeat"></i>
                <h3>Y tế</h3>
                <p>15+ Ý tưởng</p>
            </div>
        </div>
    </section>

    <!-- Latest Ideas -->
    <section class="latest-ideas">
        <h2>Ý tưởng & Giải Pháp mới nhất</h2>
        <div class="idea-list">
            <?php if (is_array($postCreateAtPost)): ?>
                <?php foreach ($postCreateAtPost as $post): ?>
                    <a href="idea-detail.php?idpost=<?= htmlspecialchars($post['idpost']) ?>" style="color: inherit; text-decoration: none;">
                        <div class="idea-card" style="height: 400px;">
                            <img src="<?= htmlspecialchars($post['imagepost']) ?>" alt="<?= htmlspecialchars($post['fullname']) ?>">
                            <h3>
                                <?= htmlspecialchars(mb_strlen($post['titlepost']) > 45
                                    ? mb_substr($post['titlepost'], 0, 45) . '...' 
                                    : $post['titlepost']) ?>
                            </h3>
                            <p class="author">Tác giả: <?= htmlspecialchars($post['fullname']) ?></p>
                            <p class="summary">Đã tạo: <?= htmlspecialchars($post['createatpost']) ?></p>
                            <p class="summary">Mô tả: 
                                <?= htmlspecialchars(mb_strlen($post['descriptionpost']) > 45
                                    ? mb_substr($post['descriptionpost'], 0, 60) . '...' 
                                    : $post['descriptionpost']) ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?= htmlspecialchars($posts) ?></p>
            <?php endif; ?>
        </div>
    </section>

        <!-- Investment Call -->
    <section class="investment-call">
        <h2>Ý tưởng & Giải Pháp cập nhật mới nhất</h2>
        <div class="investment-list">
            <?php if (is_array($postUpdateAtPost)): ?>
                <?php foreach ($postUpdateAtPost as $post): ?>
                    <a href="idea-detail.php?idpost=<?= htmlspecialchars($post['idpost']) ?>" style="color: inherit; text-decoration: none;">
                        <div class="idea-card" style="height: 400px;">
                            <img src="<?= htmlspecialchars($post['imagepost']) ?>" alt="<?= htmlspecialchars($post['fullname']) ?>">
                            <h3>
                                <?= htmlspecialchars(mb_strlen($post['titlepost']) > 45
                                    ? mb_substr($post['titlepost'], 0, 45) . '...' 
                                    : $post['titlepost']) ?>
                            </h3>
                            <p class="author">Tác giả: <?= htmlspecialchars($post['fullname']) ?></p>
                            <p class="summary">Đã cập nhật: <?= htmlspecialchars($post['updatedatpost']) ?></p>
                            <p class="summary">Mô tả: 
                                <?= htmlspecialchars(mb_strlen($post['descriptionpost']) > 45
                                    ? mb_substr($post['descriptionpost'], 0, 60) . '...' 
                                    : $post['descriptionpost']) ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?= htmlspecialchars($posts) ?></p>
            <?php endif; ?>
        </div>

        <div class="about-item">
            <img style="width: 70%; margin-top: 80px; border-radius: 10px; border: 3px solid black;" src="https://i.ibb.co/zhhNNcM/istock-638171640-banner.jpg" alt="Giá trị cốt lõi" class="about-image">
            <h2>Giá trị cốt lõi</h2>
            <ul style="margin: 0 auto; text-align: center;">
                <li><strong>Hợp tác:</strong> Tăng cường sự kết nối giữa các bên liên quan.</li>
                <li><strong>Sáng tạo:</strong> Thúc đẩy đổi mới và tư duy sáng tạo.</li>
                <li><strong>Phát triển:</strong> Hỗ trợ phát triển các ý tưởng tiềm năng.</li>
            </ul>
        </div>
        <div class="about-item">
            <h2>Đội ngũ của chúng tôi</h2>
            <p>
                Đội ngũ Sàn Ý Tưởng bao gồm những chuyên gia đam mê khởi nghiệp và đổi mới, luôn sẵn sàng hỗ trợ các bạn sinh viên
                trong hành trình khởi nghiệp.
            </p>
        </div>
    </section>
    <!-- Login Form -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <span class="close-btn" id="closeLogin">&times;</span>
            <?php 
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST['login'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    if ($UserBll->UserLogin($username, $password)) {
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $UserBll->UserDetails($username)['role'];
                        echo "Đăng Nhập Thành Công!.";
                    }else{
                        echo "Đăng Nhập Thất Bại!.";
                    }
                }
            }
            ?>
            <h2>Đăng nhập</h2>
            <form action="" method="post">
                <input type="username" id="username" name="username" placeholder="Tài Khoản" required>
                <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
                <button type="submit" class="btn" name="login">Đăng nhập</button>
            </form>
        </div>
    </div>

    <!-- Signup Form -->
    <div class="modal" id="signupModal">
        <div class="modal-content">
            <span class="close-btn" id="closeSignup">&times;</span>
            <h2>Đăng ký</h2>
            <?php 
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST['register'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];
                    $fullname = $_POST['fullname'];
                    if($password == $_POST['passwordconfirm']){
                        $message = $UserBll->Userregister($username, $password, $email, $fullname);
                        echo "<p style='color: green;'>$message</p>";
                        $_SESSION['username'] = $username;
                        $_SESSION['role'] = $UserBll->UserDetails($username)['role'];
                    }else{
                        echo "<p style='color: red;'>Mật khẩu không khớp!</p>";
                    }
                }
            }
            ?>
            <form action="" method="post">
                <input type="text" id="username" name="username" placeholder="Tài Khoản" required>
                <input type="text" id="fullname" name="fullname" placeholder="Họ và tên" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
                <input type="password" id="passwordconfirm" name="passwordconfirm"placeholder="Xác nhận mật khẩu" required>
                <button type="submit" class="btn" name="register">Đăng ký</button>
            </form>
        </div>
    </div>

    

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
        // Get modal elements
        const loginModal = document.getElementById('loginModal');
        const signupModal = document.getElementById('signupModal');
    
        // Get buttons
        const loginBtn = document.querySelector('.login-btn');
        const signupBtn = document.querySelector('.signup-btn');
    
        // Get close buttons
        const closeLogin = document.getElementById('closeLogin');
        const closeSignup = document.getElementById('closeSignup');
    
        // Show login modal
        loginBtn.addEventListener('click', () => {
            loginModal.style.display = 'flex';
        });
    
        // Show signup modal
        signupBtn.addEventListener('click', () => {
            signupModal.style.display = 'flex';
        });
    
        // Close login modal
        closeLogin.addEventListener('click', () => {
            loginModal.style.display = 'none';
        });
    
        // Close signup modal
        closeSignup.addEventListener('click', () => {
            signupModal.style.display = 'none';
        });
    
        // Close modal when clicking outside content
        window.addEventListener('click', (event) => {
            if (event.target === loginModal) {
                loginModal.style.display = 'none';
            }
            if (event.target === signupModal) {
                signupModal.style.display = 'none';
            }
        });
    </script>
    
</body>
</html>
