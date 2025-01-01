<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';

session_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
 
$postCreateAtPost = $PostBLL->PostsTopTime("createatpost");
$postUpdateAtPost = $PostBLL->PostsTopTime("updatedatpost");

$id = isset($_GET['iduser']) ? intval($_GET['iduser']) : 0;
$pfile = $UserBll->getUserDetails($id); 
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
        
</body>
</html>
