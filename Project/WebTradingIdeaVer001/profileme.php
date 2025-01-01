<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';

session_start();

$UserBll = new UserBll();
$PostBll = new PostBLL();
$username = $_SESSION['username'];

$pfile = $UserBll->UserDetails($username); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sàn Ý Tưởng - Đại học Nam Cần Thơ</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            flex-direction: column;
        }
        .user-info {
            background-color: #ffffff;
            padding: 30px;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-size: 14px;
            color: #444;
            margin: 30px auto; /* Căn giữa phần user-info */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f4f4f4;
            transition: all 0.3s ease;
        }

        input[type="password"]:disabled {
            background-color: #e9e9e9;
            cursor: not-allowed;
        }

        input[type="password"]:focus {
            border-color: #4caf50;
            background-color: #eaf6e3;
            outline: none;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            align-items: center;
        }

        .info-item label {
            font-weight: normal;
        }

        .info-item span {
            color: #777;
        }

        .status-badge {
            background-color: #ffcc00;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .role-badge {
            background-color: #4caf50;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Hover effect for labels */
        label:hover {
            color: #4caf50;
        }
        .custom-button {
            background-color: #007bff; /* Màu nền xanh dương */
            color: #ffffff; /* Màu chữ trắng */
            border: none; /* Loại bỏ viền */
            border-radius: 5px; /* Bo góc */
            padding: 10px 20px; /* Khoảng cách bên trong nút */
            font-size: 16px; /* Kích thước chữ */
            font-weight: bold; /* Chữ đậm */
            cursor: pointer; /* Thay đổi con trỏ khi rê chuột */
            transition: background-color 0.3s, transform 0.2s; /* Hiệu ứng khi hover */
            margin-bottom: 20px;
        }

        .custom-button:hover {
            background-color: #0056b3; /* Màu nền khi hover */
            transform: scale(1.05); /* Phóng to nhẹ */
        }

        .custom-button:active {
            background-color: #003f7f; /* Màu nền khi bấm */
            transform: scale(1); /* Thu nhỏ về trạng thái bình thường */
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

        <div class="auth-buttons">
            <button class="btn login-btn">Đăng nhập</button>
            <button class="btn signup-btn">Đăng ký</button>
        </div>
    </header>

    <!-- User Info Section -->
    <div class="user-info">
        <h2>Thông tin người dùng</h2>
        <div class="info-item">
            <label for="">userid:</label>
            <span><?= $pfile['iduser'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Username:</label>
            <span><?= $pfile['username'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Email:</label>
            <span><?= $pfile['email'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Fullname:</label>
            <span><?= $pfile['fullname'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Ngày Sinh:</label>
            <span><?= $pfile['dod'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Tổ chức:</label>
            <span><?= $pfile['organize'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Số Điện Thoại:</label>
            <span><?= $pfile['phonenumber'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Địa Chỉ:</label>
            <span><?= $pfile['address'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Ngày tạo:</label>
            <span><?= $pfile['createdat'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Chỉnh sửa gần nhất:</label>
            <span><?= $pfile['updatedat'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Trạng Thái:</label>
            <span class="status-badge"><?= $pfile['status'] ?></span>
        </div>
        <div class="info-item">
            <label for="">Vai trò:</label>
            <span class="role-badge"><?= $pfile['role'] ?></span>
        </div>
    <!-- Mật khẩu -->
        <?php 
        if (isset($_POST['submit'])) { // Kiểm tra nếu form được gửi
            $newpasswd = trim($_POST['password']); // Lấy giá trị mật khẩu mới
        
            if (!empty($newpasswd)) { // Kiểm tra mật khẩu không rỗng
                if ($UserBll->updatePassword($username, $newpasswd)) {
                    echo "Mật khẩu đã được cập nhật thành công.";
                } else {
                    echo "Có lỗi xảy ra khi cập nhật mật khẩu.";
                }
            } else {
                echo "Vui lòng nhập mật khẩu mới.";
            }
        }
        ?>
        <form action="" method="post" id="passwordForm">
            <div style="display: flex; align-items: center; justify-content: flex-end;">
                <input type="password" name="password" placeholder="*******" id="passwordInput" disabled style="margin-right: 10px;">
                <button type="submit" class="custom-button" id="toggleButton" name="submit" style="height: 50px;">Thay đổi mật khẩu</button>
            </div>
        </form>
    </div>

    <!-- Tạo Bài Viết-->
    <div class="create-post-container">
        <a href="create-post.php">
            <button type="submit" class="create-post-button">Tạo bài viết</button>
        </a>
    </div>
    
     <!-- Đổ dữ liệu bài viết-->
    <?php 
    $myPost = $PostBll->MyPosts($username);
    if ($myPost != null): // Mở khối điều kiện với cú pháp `if` của PHP
        foreach ($myPost as $post):
    ?>
        <div class="container" style="margin: 0 auto;">
            <a href="idea-detail.php?idpost=<?= htmlspecialchars($post['idpost']) ?>" class="link">
                <img src="<?= htmlspecialchars($post['imagepost']) ?>" alt="Thumbnail" class="thumbnail">
                <div class="info">
                    
                    <p class="title"><?= htmlspecialchars($post['titlepost']) ?></p>
                    <p class="description">Mô tả nội dung: <?= htmlspecialchars($post['contentpost']) ?></p>
                    <p class="post-category">Danh mục: 
                        <?php 
                        if($post['ideapost'] == 'solution')
                            echo "Giải pháp";
                        else
                            echo "Ý tưởng";
                        ?>
                    </p>
                    <p class="status">Trạng Thái: 
                        <?php 
                        if($post['statuspost'] == 'Pending')
                            echo "Đang chờ";
                        else if($post['statuspost'] == 'Approved')
                            echo "Đang hoạt động";
                        else 
                            echo "Bị từ chối";
                        ?>
                    </p>
                    <p class="timestamp">Tạo lúc: <?= htmlspecialchars($post['createatpost']) ?></p>
                </div>
            </a>
        </div>
        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['edit'])) {
                echo "Chỉnh sửa bài viết ID: " . htmlspecialchars($post['idpost']);
            }else{
                if (isset($_POST['delete'])) {
                    $idToDelete = htmlspecialchars($_POST['idpost']); // Lấy ID từ form
                    $PostBll->deletePost($idToDelete);
                    echo '<meta http-equiv="refresh" content="0">';
                    exit;
                }
            }
        }
        ?>
        
        <div class="button-container">
            <!-- Form chỉnh sửa -->
            <form action="create-post.php?idpost=<?= htmlspecialchars($post['idpost']) ?>" method="post">
                <button type="submit" name="edit" class="custom-button" style="margin-right: 30px; width: 200px;">Chỉnh sửa</button>
            </form>
                        
            <!-- Form xóa -->
            <form action="" method="post" id="deleteForm">
                <input type="hidden" name="idpost" value="<?php echo htmlspecialchars($post['idpost']); ?>">
                <button type="submit" name="delete" class="custom-button delete-button" style="width: 200px;" onclick="confirmDelete(event)">Xóa bài</button>
            </form>
        </div>
        
    <?php 
        endforeach;
    endif;
    ?>

    <!-- Chân trang -->
    <footer>
        <p>© 2024 Đại học Nam Cần Thơ - Sàn Ý Tưởng. Liên hệ: lekhoa583@gmail.com</p>
        <div>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
    </footer>

    <style>
        .create-post-container {
            margin: 0 auto;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Nút tạo bài viết */
        .create-post-button {
            width: 120px; /* Chiều rộng nút */
            height: 40px; /* Chiều cao nút */
            background-color: #4caf50; /* Màu xanh lá nổi bật */
            color: white; /* Màu chữ */
            border: none; /* Xóa viền */
            border-radius: 5px; /* Bo góc nút */
            font-size: 14px; /* Kích thước chữ */
            font-weight: bold; /* Chữ đậm */
            cursor: pointer; /* Con trỏ dạng tay khi hover */
            transition: all 0.3s ease; /* Hiệu ứng mượt khi hover */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
        }

        /* Hiệu ứng khi hover */
        .create-post-button:hover {
            background-color: #45a049; /* Màu xanh đậm hơn khi hover */
            transform: translateY(-2px); /* Nút nhô lên khi hover */
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); /* Đổ bóng đậm hơn */
        }

        /* Hiệu ứng khi nhấn */
        .create-post-button:active {
            transform: translateY(0); /* Hạ nút xuống vị trí gốc */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng như cũ */
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            background-color: #ccc;
            color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            max-width: 800px;
            font-family: Arial, sans-serif;
        }

        /* Link của video */
        .link {
            display: flex;
            text-decoration: none;
            color: inherit;
            width: 100%;
        }

        /* Ảnh thumbnail */
        .thumbnail {
            margin-right: 3%;
            width: 250px;   
            object-fit: cover;
        }

        /* Container chứa thông tin video */
        .info {
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Các style chi tiết */
        .title {
            width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: rgb(186 141 79);
        }

        .description,
        .post-category,
        .status,
        .timestamp {
            width: auto;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 14px;
            margin: 3px 0;
            color: #424242;
        }

        .status {
            color: #4caf50; /* Màu xanh cho trạng thái */
        }

        .title:hover {
            color: #f39c12; /* Đổi màu khi hover vào tiêu đề */
        }
        .button-container {
            margin: 0 auto;
            margin-left: 35%;
            display: flex;
            text-align: center;
            gap: 10px; /* Khoảng cách giữa các nút */
            justify-content: flex-start; /* Căn nút về bên trái */
        }

        /* Style chung cho nút */
        .custom-button {
            width: 120px; /* Chiều rộng của nút */
            height: 40px; /* Chiều cao của nút */
            background-color: #007bff; /* Màu nền */
            color: white; /* Màu chữ */
            border: none; /* Xóa đường viền */
            border-radius: 5px; /* Bo góc */
            font-size: 14px; /* Kích thước chữ */
            font-weight: bold; /* Chữ đậm */
            cursor: pointer; /* Con trỏ dạng tay khi hover */
            transition: all 0.3s ease; /* Hiệu ứng chuyển đổi khi hover */
        }

        /* Hiệu ứng khi hover nút */
        .custom-button:hover {
            background-color: #0056b3; /* Màu nền khi hover */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Đổ bóng nhẹ */
        }

        /* Nút xóa (cá nhân hóa) */
        .delete-button {
            background-color: #dc3545; /* Màu đỏ */
        }

        .delete-button:hover {
            background-color: #a71d2a; /* Màu đỏ đậm hơn khi hover */
        }
    </style>

    <script>
        const toggleButton = document.getElementById('toggleButton');
        const passwordInput = document.getElementById('passwordInput');
        const passwordForm = document.getElementById('passwordForm');

        let isEditing = false; // Trạng thái chỉnh sửa

        toggleButton.addEventListener('click', function (event) {
            if (isEditing) {
                // Khi đang chỉnh sửa và nhấn "Lưu mật khẩu"
                const password = passwordInput.value.trim();
                if (password.length === 0) {
                    event.preventDefault(); // Ngăn form submit nếu mật khẩu rỗng
                    alert("Vui lòng nhập mật khẩu.");
                    return;
                }
                if (password.length < 8) {
                    event.preventDefault(); // Ngăn form submit nếu mật khẩu ngắn hơn 8 ký tự
                    alert("Mật khẩu phải có ít nhất 8 ký tự.");
                    return;
                }
            } else {
                // Khi nhấn "Thay đổi mật khẩu"
                event.preventDefault(); // Ngăn form submit khi chưa sẵn sàng
                passwordInput.disabled = false; // Bật trường nhập mật khẩu
                toggleButton.innerText = "Lưu mật khẩu"; // Đổi nội dung nút
            }
            isEditing = !isEditing; // Đổi trạng thái
        });

        function confirmDelete(event) {
            const confirmation = confirm("Bạn có chắc chắn muốn xóa bài viết này không?");
            if (confirmation) {
                // Nếu người dùng xác nhận, gửi form
                document.getElementById('deleteForm').submit();
            }else{
                event.preventDefault();
            }
        }
    </script>
</body>
</html>