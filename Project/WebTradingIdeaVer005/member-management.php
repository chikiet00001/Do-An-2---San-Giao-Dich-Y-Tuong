<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/RepostBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/NotificationsBLL.php';

ob_start();

session_start();

if(empty($_SESSION['username'])){
    header("Location: index.php"); 
    exit();
    ob_end_flush();
}

$UserBll = new UserBll();
$PostBLL = new PostBLL();
$RepostBLL = new RepostBLL();
$NotificationsBLL = new NotificationsBLL();
 
$postCreateAtPost = $PostBLL->PostsTopTime("createatpost");
$postUpdateAtPost = $PostBLL->PostsTopTime("updatedatpost");

$selected_function = $_GET['function'] ?? 'a';
$pendingPost = $PostBLL->PendingPosts();
$alluser = $UserBll->AllUsers();
$allrepost = $RepostBLL->getReposts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thành Viên - Sàn Ý Tưởng</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        input[type="text"], 
        input[type="password"], 
        input[type="date"], 
        input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        }

        .radio-group-status,
        .radio-group-role {
        display: flex;
        gap: 10px;
        }

        .radio-group-status label,
        .radio-group-role label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
        }

        input[type="radio"] {
        transform: scale(1.2);
        }

        button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
        }

        button:hover {
        background-color: #45a049;
        }

        /* Responsive cho thiết bị nhỏ */
        @media (max-width: 480px) {
        form {
            width: 90%;
        }
        }
    </style>
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

    <!-- Member Management Section -->
    <section class="member-management">
        <h1>Quản Lý Thành Viên</h1>

        <!-- Member Table -->
        <h2>Danh sách thành viên</h2><br>

        <style>
            .menu-container {
                display: flex;
                gap: 10px; /* Khoảng cách giữa các nút */
                margin-bottom: 20px; /* Khoảng cách với nội dung */
            }

            .menu-button {
                width: 150px;
                padding: 10px 20px;
                background-color: rebeccapurple;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .menu-button:hover {
                background-color: #0056b3;
            }

            
        </style>
        <!-- Menu chuyển đổi -->
        <div class="menu-container">
            <a href="?function=a" class="menu-button">Bài Viết</a>
            <a href="?function=b" class="menu-button">Báo Cáo</a>
            <a href="?function=c" class="menu-button">Thành Viên</a>
        </div>
        <?php if ($selected_function === 'a'): ?>
            <?php if (is_array($pendingPost)): ?>
                <table class="member-table content active" id="" >
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Hình Ảnh</th>
                            <th>Nội dung</th>
                            <th>Danh mục</th>
                            <th>Tạo lúc</th>
                            <th style="width: 100px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingPost as $post): ?>
                            <tr>
                                <td><?= htmlspecialchars(mb_strlen($post['titlepost']) > 45
                                    ? mb_substr($post['titlepost'], 0, 45) . '...' 
                                    : $post['titlepost']) ?></td>
                                <td ><img style="height: 120px; width: 200px;" src="<?php echo $post['imagepost']; ?>" alt="" ></td>
                                <td><?= htmlspecialchars(mb_strlen($post['contentpost']) > 45
                                    ? mb_substr($post['contentpost'], 0, 45) . '...' 
                                    : $post['contentpost']) ?></td>
                                <td><?php echo $post['ideapost']; ?></td>
                                <td><?php echo $post['createatpost']; ?></td>
                                <td>
                                    <!-- Nút Xem bài -->
                                    <a href="idea-detail.php?idpost=<?= htmlspecialchars($post['idpost']) ?>" style="color: inherit; text-decoration: none;"><button class="btn edit-btn">Xem</button></a>
                                    
                                    <!-- Nút xử lý duyệt bài -->
                                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_post'])){
                                        $PostBLL->approvePost($_POST['idpost']);
                                        echo '<meta http-equiv="refresh" content="0">';
                                        exit;
                                     } ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="idpost" value="<?php echo htmlspecialchars($post['idpost']); ?>">
                                        <button class="btn block-btn" type="submit" name="approve_post" >Duyệt</button>
                                    </form>
                                    
                                    <!-- Nút xử lý bỏ qua bài -->
                                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ignore_post'])){
                                        $PostBLL->ignorePost($_POST['idpost']);
                                        echo '<meta http-equiv="refresh" content="0">';
                                        exit;
                                     } ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="idpost" value="<?php echo htmlspecialchars($post['idpost']); ?>">
                                        <button class="btn delete-btn" type="submit" name="ignore_post">Bỏ Qua</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Không có bài viết chờ duyệt.</p>
            <?php endif; ?>
        <?php elseif ($selected_function === 'b'): ?>
            <?php if (is_array($allrepost)): ?>
                <table class="member-table content active" id="" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nội Dung</th>
                            <th>Thời Gian</th>
                            <th>User Báo Cáo</th>
                            <th>User Bị Báo Cáo</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allrepost as $repost): ?>
                            <tr>
                                <td><?php echo $repost['idrepost']; ?></td>
                                <td><?php echo $repost['reason']; ?></td>
                                <td><?php echo $repost['createatrepost']; ?></td>
                                <td><?php echo $repost['reporting_user']; ?></td>
                                <td><?php echo $repost['reported_user']; ?></td>
                                <td>
                                    <!-- Nút Xem bài -->
                                    <a href="idea-detail.php?idpost=<?= htmlspecialchars($repost['idpost']) ?>" 
                                    style="color: inherit; text-decoration: none;"><button class="btn edit-btn">Xem</button></a>

                                    <!-- Nút xử lý duyệt bài -->
                                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ignore_post'])){
                                        $PostBLL->ignorePost($_POST['idpost']);
                                        $RepostBLL->markAsResolved($repost['idrepost']);
                                        echo '<meta http-equiv="refresh" content="0">';
                                        exit;
                                     } ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="idpost" value="<?php echo htmlspecialchars($repost['idpost']); ?>">
                                        <button class="btn block-btn" type="submit" name="ignore_post" >Duyệt</button>
                                    </form>

                                    <!-- Nút xử lý bỏ qua bài -->
                                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ignore_repost'])){
                                        $RepostBLL->markAsIgnored($repost['idrepost']);
                                        echo '<meta http-equiv="refresh" content="0">';
                                        exit;
                                     } ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="idpost" value="<?php echo htmlspecialchars($repost['idpost']); ?>">
                                        <button class="btn delete-btn" type="submit" name="ignore_repost">Bỏ Qua</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Không có bài viết chờ duyệt.</p>
            <?php endif; ?>
        <?php elseif ($selected_function === 'c'): ?>
            <?php if (is_array($alluser)): ?>
                <table class="member-table content active" id="" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tài Khoản</th>
                            <th>Mật Khẩu</th>
                            <th>Email</th>
                            <th>Họ Tên</th>
                            <th>Ngày Sinh</th>
                            <th>Tổ Chức</th>
                            <th>Số Điện Thoại</th>
                            <th>Địa Chỉ</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th style="width: 30%;">Thao tác</th>
                        </tr>
                    </thead>
                    <style>
                        /* CSS để tùy chỉnh nút và khối div */
                        .hidden-div {
                            display: none; /* Ẩn khối div ban đầu */
                            width: 100%;
                            height: auto;
                            padding: 20px;
                            background-color: #f4f4f4;
                            border: 1px solid #ccc;
                            border-radius: 8px;
                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                            margin-top: 20px;
                        }
                        .content-header {
                            font-size: 18px;
                            font-weight: bold;
                            margin-bottom: 10px;
                        }
                        .content-body {
                            font-size: 14px;
                            margin-bottom: 10px;
                        }
                    </style>
                    <tbody>
                        <?php 
                            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                                if(isset($_POST['updateuser'])){
                                    $idusers = $_POST['iduser'];
                                    $username = trim($_POST['username']);
                                    $passwd = trim($_POST['passwd']);
                                    $email = trim($_POST['email']);
                                    $fullname = trim($_POST['fullname']);
                                    $dod = $_POST['dod'];
                                    $organize = trim($_POST['organize']);
                                    $phonenumber = trim($_POST['phonenumber']);
                                    $address = trim($_POST['address']);
                                    $status = trim($_POST['optionstatus']);
                                    $role = trim($_POST['optionrole']);
                                    $UserBll->updateUser($idusers, $username, $passwd, $email,
                                    $fullname, $dod, $organize, $phonenumber, $address, $status, 
                                    $role);
                                    echo '<meta http-equiv="refresh" content="0">';
                                    exit;
                                }
                            }
                        ?>
                        <?php foreach ($alluser as $user): ?>
                            <tr>
                                <td><?php echo $user['iduser'] ?></td>
                                <td><?php echo $user['username'] ?></td>
                                <td><?php echo "********" ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><?php echo $user['fullname'] ?></td>
                                <td><?php echo $user['dod'] ?></td>
                                <td><?php echo $user['organize'] ?></td>
                                <td><?php echo $user['phonenumber'] ?></td>
                                <td><?php echo $user['address'] ?></td>
                                <td><?php echo $user['status'] ?></td>
                                <td><?php echo $user['role'] ?></td>
                                <td>
                                    <button class="btn edit-btn show-btn" id="showDivBtn<?php echo $user['iduser']; ?>">Sửa</button>
                                    <?php 
                                        $isLocked = ($user['status'] != "active");
                                        if(isset($_POST['block' . $user['iduser']])){
                                            $newStatus = ($user['status'] != "active") ? "active" : "banned";
                                                $UserBll->updateUser($user['iduser'], $user['username'], $user['passwd'], $user['email'],
                                                $user['fullname'], $user['dod'], $user['organize'], $user['phonenumber'], $user['address'], 
                                                $newStatus, $user['role']);
                                            echo '<meta http-equiv="refresh" content="0">';
                                            exit;
                                        }
                                    ?>
                                    <form action="" method="post">
                                        
                                        <button type="submit" name="block<?php echo $user['iduser']; ?>" class="btn block-btn">
                                            <?php echo $isLocked ? "Mở Khóa" : "Khóa"; ?>
                                        </button>
                                    </form>

                                    <style>
                                        .overlay {
                                            display: none;
                                            position: fixed;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            background: rgba(0, 0, 0, 0.5);
                                            z-index: 999;
                                        }

                                        .overlay.active {
                                            display: block;
                                        }

                                        .Admindialog {
                                            display: none;
                                            position: fixed;
                                            top: 50%;
                                            left: 50%;
                                            transform: translate(-50%, -50%);
                                            background: white;
                                            padding: 20px;
                                            border-radius: 8px;
                                            z-index: 1000;
                                        }

                                        .Admindialog.active {
                                            display: block;
                                        }
                                    </style>
                                    <?php 
                                        if(isset($_POST['mess' . $user['iduser']])){
                                            $contentKey = 'content' . $user['iduser'];
                                            if (!empty($_POST[$contentKey])) {
                                                $NotificationsBLL->createNotification($_POST[$contentKey], $user['iduser']);
                                                echo '<meta http-equiv="refresh" content="0">';
                                                exit;
                                            }
                                        }
                                    ?>
                                    <button id="notify-btn-<?php echo $user['iduser']; ?>" style="height: auto;">Thông Báo</button>
                                    <div id="overlay-<?php echo $user['iduser']; ?>" class="overlay"></div>
                                    <div id="admin-dialog-<?php echo $user['iduser']; ?>" class="Admindialog">
                                        <h2>Thông Báo</h2>
                                        <p>Đây là hộp thoại dành cho admin.</p>
                                        <form action="" method="post">
                                            <input type="hidden" name="iduser" value="<?php echo htmlspecialchars($user['iduser']); ?>">
                                            <textarea rows="10" name="content<?php echo $user['iduser']; ?>"></textarea><br>
                                            <button type="submit" name="mess<?php echo $user['iduser']; ?>" style="background-color: red;"> Gửi </button>
                                        </form>
                                        <button id="close-dialog-<?php echo $user['iduser']; ?>">Đóng</button>
                                    </div>

                                    <script>
                                        document.querySelectorAll("[id^='notify-btn-']").forEach((notifyBtn) => {
                                            const userId = notifyBtn.id.split('-')[2];
                                            const dialog = document.getElementById(`admin-dialog-${userId}`);
                                            const overlay = document.getElementById(`overlay-${userId}`);
                                            const closeDialogBtn = document.getElementById(`close-dialog-${userId}`);

                                            // Hiển thị hộp thoại khi nhấn nút "Thông Báo"
                                            notifyBtn.addEventListener("click", () => {
                                                dialog.classList.add("active");
                                                overlay.classList.add("active");
                                            });

                                            // Đóng hộp thoại khi nhấn nút "Đóng"
                                            closeDialogBtn.addEventListener("click", () => {
                                                dialog.classList.remove("active");
                                                overlay.classList.remove("active");
                                            });

                                            // Đóng hộp thoại khi nhấn vào lớp phủ
                                            overlay.addEventListener("click", () => {
                                                dialog.classList.remove("active");
                                                overlay.classList.remove("active");
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <div class="hidden-div" id="hiddenDiv<?php echo $user['iduser']; ?>">
                                <div class="content-header">ID User: <?php echo $user['iduser']; ?></div>
                                <form action="" method="post">
                                    <div>
                                        <input type="hidden" name="iduser" value="<?php echo $user['iduser']; ?>">
                                        <p>Tài Khoản: </p><input type="text" name="username" value="<?php echo $user['username']; ?>" placeholder="Tài Khoản">
                                        <p>Mật Khẩu: </p><input type="password" name="passwd" value="<?php echo $user['passwd']; ?>" placeholder="Mật Khẩu">
                                        <p>Xác Nhận Mật Khẩu: </p><input type="password" value="<?php echo $user['passwd']; ?>" placeholder="Mật Khẩu">
                                        <p>Email: </p><input type="text" name="email" value="<?php echo $user['email']; ?>" placeholder="Email">
                                        <p>Họ Tên: </p><input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" placeholder="Họ Tên">
                                        <p>Ngày Sinh: </p><input type="date" name="dod" value="<?php echo $user['dod']; ?>">
                                        <p>Tổ Chức: </p><input type="text" name="organize" value="<?php echo $user['organize']; ?>" placeholder="Tổ chức">
                                        <p>Số Điện Thoại: </p><input type="number" name="phonenumber" value="<?php echo $user['phonenumber']; ?>" placeholder="Số Điện Thoại">
                                        <p>Địa Chỉ: </p><input type="text" name="address" value="<?php echo $user['address']; ?>" placeholder="Địa Chỉ">
                                        <p>Trạng Thái</p>
                                        <div class="radio-group-status">
                                            <label><input type="radio" name="optionstatus" value="active" <?php if ($user['status'] == "active") { echo "checked"; } ?> />active</label>
                                            <label><input type="radio" name="optionstatus" value="inactive" <?php if ($user['status'] == "inactive") { echo "checked"; } ?> />inactive</label>
                                            <label><input type="radio" name="optionstatus" value="banned" <?php if ($user['status'] == "banned") { echo "checked"; } ?> />banned</label>
                                        </div>
                                        <p>Role</p>
                                        <div class="radio-group-role">
                                            <label><input type="radio" name="optionrole" value="user" <?php if ($user['role'] == "user") { echo "checked"; } ?> />user</label>
                                            <label><input type="radio" name="optionrole" value="moderator" <?php if ($user['role'] == "moderator") { echo "checked"; } ?> />moderator</label>
                                            <label><input type="radio" name="optionrole" value="admin" <?php if ($user['role'] == "admin") { echo "checked"; } ?> />admin</label>
                                        </div>
                                    </div>
                                    <button type="submit" name="updateuser">Xác Nhận Thay Đổi</button>
                                </form><br>
                                <button class="show-btn" id="closeDivBtn<?php echo $user['iduser']; ?>" style="background-color: red;">Đóng</button>
                            </div>
                            
                            <script>
                                // JavaScript xử lý hiển thị và ẩn div
                                const showDivBtn<?php echo $user['iduser']; ?> = document.getElementById('showDivBtn<?php echo $user['iduser']; ?>');
                                const hiddenDiv<?php echo $user['iduser']; ?> = document.getElementById('hiddenDiv<?php echo $user['iduser']; ?>');
                                const closeDivBtn<?php echo $user['iduser']; ?> = document.getElementById('closeDivBtn<?php echo $user['iduser']; ?>');

                                showDivBtn<?php echo $user['iduser']; ?>.addEventListener('click', () => {
                                    hiddenDiv<?php echo $user['iduser']; ?>.style.display = 'block'; // Hiển thị div
                                });

                                closeDivBtn<?php echo $user['iduser']; ?>.addEventListener('click', () => {
                                    hiddenDiv<?php echo $user['iduser']; ?>.style.display = 'none'; // Ẩn div
                                });
                            </script>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Thành Viên Rỗng.</p>
            <?php endif; ?>
        <?php else: ?>
            <div class="function-content">
                <h2>Lỗi</h2>
                <p>Chức năng không hợp lệ!</p>
            </div>
        <?php endif; ?>


        <!-- Statistics Section -->
        <h2>Thống kê</h2>
        <div class="statistics">
            <canvas id="ideasChart" width="400" height="200"></canvas>
            <div class="visitor-count">
                <h3>Số lượt truy cập:</h3>
                <p><strong>12,345</strong></p>
            </div>
        </div>
    </section>
    <!-- Guest Notice -->
    <section class="guest-notice">
        <p>Chỉ các thành viên đã đăng nhập mới có thể tải tài liệu hoặc gửi phản hồi.</p>
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
        // Chart.js for idea statistics
        const ctx = document.getElementById('ideasChart').getContext('2d');
        const ideasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                datasets: [{
                    label: 'Số lượng ý tưởng',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Để biểu đồ co giãn theo container
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function showFunction(func) {
            // Ẩn tất cả các chức năng
            document.getElementById('function-a').style.display = 'none';
            document.getElementById('function-b').style.display = 'none';
            document.getElementById('function-c').style.display = 'none';

            // Hiển thị chức năng được chọn
            document.getElementById(`function-${func}`).style.display = 'block';
        }

        
        
    </script>
</body>
</html>
