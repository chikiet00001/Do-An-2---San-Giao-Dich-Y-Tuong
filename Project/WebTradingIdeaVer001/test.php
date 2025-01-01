<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';
require_once __DIR__ . '/../WebTradingIdea/DataAccessLayer/PostDAL.php';
session_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
$postDAL = new PostDAL();

$postCreateAtPost = $PostBLL->PostsTopTime("createatpost");
$postUpdateAtPost = $PostBLL->PostsTopTime("updatedatpost");

?>

<!-- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <!-- Login -->
    <?php 
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($UserBll->UserLogin($username, $password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $UserBll->UserDetails($username)['role'];
            echo "Đăng nhập thành công!";
        }else{
            echo "Sai tên đăng nhập hoặc mật khẩu.";
        }
    }
    ?>
    <h2>Đăng Nhập</h2>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form><br>
    
<?php 
$keyword = 'description';
$pendingPosts = $postDAL->SearchPosts($keyword);
echo "text";
// Hiển thị kết quả
foreach ($pendingPosts as $post) {
    echo "ID: " . $post['idpost'] . "<br>";
    echo "Title: " . $post['titlepost'] . "<br>";
    echo "Image: " . $post['imagepost'] . "<br>";
    echo "Author: " . $post['fullname'] . "<br>";
    echo "Created At: " . $post['createatpost'] . "<br><br>";
}
?>

    <!-- Đăng Ký -->
    <h2>Đăng ký</h2>
    <?php 
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
    
        $message = $UserBll->Userregister($username, $password, $email, $fullname);
        echo $message;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $UserBll->UserDetails($username)['role'];
    }
    ?>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required><br>

        <button type="submit" name="register">Register</button>
    </form>

    <h1>Danh sách bài đăng</h1>

    <?php if (is_array($postCreateAtPost)): ?>
        <?php foreach ($postCreateAtPost as $post): ?>
            <a href="idea-detail.php?idpost=<?= htmlspecialchars($post['idpost']) ?>" style="color: inherit; text-decoration: none;">
                <div>
                    <h2><?= htmlspecialchars($post['titlepost']) ?></h2>
                    <img src="<?= htmlspecialchars($post['imagepost']) ?>" alt="<?= htmlspecialchars($post['fullname']) ?>" width="300">
                    <p>Tác giả: <?= htmlspecialchars($post['fullname']) ?></p>
                    <p>đã tạo: <?= htmlspecialchars($post['createatpost']) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?= htmlspecialchars($posts) ?></p>
    <?php endif; ?>
    <a href="index.php">Quay lại</a>
    

    <h1>Danh sách Thay Đổi</h1>

    <div class="idea-cards">
            <?php if (is_array($postUpdateAtPost)): ?>
                <?php foreach ($postUpdateAtPost as $post): ?>
                    <a href="idea-detail.php?idpost=<?= htmlspecialchars($post['idpost']) ?>" style="color: inherit; text-decoration: none;">
                        <div class="idea-card">
                            <img src="https://cdn.nguyenkimmall.com/images/companies/_1/tin-tuc/kinh-nghiem-meo-hay/ng%20d%E1%BB%A5ng%20h%E1%BB%8Dc%20t%E1%BA%ADp/onluyen.vn.jpg" alt="Ý tưởng 1">
                            <h3>Ứng dụng quản lý học tập thông minh</h3>
                            <p class="summary">Ứng dụng giúp sinh viên quản lý thời gian học tập hiệu quả hơn.</p>
                            <p class="author">Tác giả: Nguyễn Văn A | Ngày: 20/11/2024</p>
                            <a href="idea-detail.html" class="btn detail-btn">Chi tiết</a>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?= htmlspecialchars($posts) ?></p>
            <?php endif; ?>
        </div>


    <br>
    <?php echo $_SESSION['username']?>
    <?php echo $_SESSION['role']?>
</body>
</html>