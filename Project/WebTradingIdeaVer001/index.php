<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';

session_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
 
$postCreateAtPost = $PostBLL->PostsTopTime("createatpost");
$postUpdateAtPost = $PostBLL->PostsTopTime("updatedatpost");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sàn Ý Tưởng - Đại học Nam Cần Thơ</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
   
        <div class="auth-buttons">
            <button class="btn login-btn">Đăng nhập</button>
            <button class="btn signup-btn">Đăng ký</button>
        </div>
    </header>
    <!-- Banner -->
    <section class="banner">
        <h1>Biến ý tưởng thành hiện thực</h1>
        <p>Kết nối sinh viên và nhà đầu tư tại Đại học Nam Cần Thơ.</p>
        <button class="btn banner-btn">Khám phá ngay</button>
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
                        <div class="idea-card">
                            <img src="<?= htmlspecialchars($post['imagepost']) ?>" alt="<?= htmlspecialchars($post['fullname']) ?>">
                            <h3>
                                <?= htmlspecialchars(mb_strlen($post['titlepost']) > 45
                                    ? mb_substr($post['titlepost'], 0, 45) . '...' 
                                    : $post['titlepost']) ?>
                            </h3>
                            <p class="author">Tác giả: <?= htmlspecialchars($post['fullname']) ?></p>
                            <p class="summary">Đã tạo: <?= htmlspecialchars($post['createatpost']) ?></p>
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
                        <div class="idea-card">
                            <img src="<?= htmlspecialchars($post['imagepost']) ?>" alt="<?= htmlspecialchars($post['fullname']) ?>">
                            <h3>
                                <?= htmlspecialchars(mb_strlen($post['titlepost']) > 45
                                    ? mb_substr($post['titlepost'], 0, 45) . '...' 
                                    : $post['titlepost']) ?>
                            </h3>
                            <p class="author">Tác giả: <?= htmlspecialchars($post['fullname']) ?></p>
                            <p class="summary">Đã cập nhật: <?= htmlspecialchars($post['updatedatpost']) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?= htmlspecialchars($posts) ?></p>
            <?php endif; ?>
        </div>
    </section>
    <!-- Login Form -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <span class="close-btn" id="closeLogin">&times;</span>
            <?php 
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
