<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';

session_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
 
$postCreateAtPost = $PostBLL->PostsTopTime("createatpost");
$postUpdateAtPost = $PostBLL->PostsTopTime("updatedatpost");
$idpost = isset($_GET['idpost']) ? intval($_GET['idpost']) : 0;
$iduser = $UserBll->getUserIdByUsername($_SESSION['username']);
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
        
        /* Tùy chỉnh nút radio */
        input[type="radio"] {
            appearance: none;
            background-color: #fff;
            margin: 0;
            font: inherit;
            color: #E91E63;
            width: 1.15em;
            height: 1.15em;
            border: 0.15em solid currentColor;
            border-radius: 50%;
            display: grid;
            place-content: center;
            transition: 120ms transform ease-in-out;
        }

        /* Vòng tròn bên trong (giả phần tử) */
        input[type="radio"]::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            border-radius: 50%;
            transform: scale(0); /* Ẩn vòng tròn mặc định */
            transition: 120ms transform ease-in-out;
            background-color: #E91E63;
        }

        /* Khi radio được chọn */
        input[type="radio"]:checked::before {
            transform: scale(1); /* Hiển thị vòng tròn bên trong */
        }

        /* Hiển thị nút radio theo hàng ngang */
        .radio-group {
            display: flex; /* Flexbox cho các nút radio */
            gap: 1em; /* Khoảng cách giữa các nút */
            align-items: center; /* Căn giữa theo trục dọc */
        }

        label {
            display: flex;
            align-items: center; /* Căn giữa nội dung trong label */
            gap: 0.5em; /* Khoảng cách giữa radio và text */
            font-size: 16px;
            cursor: pointer;
        }


        .btnupfile {
            width: 100%;
            appearance: none; /* Loại bỏ giao diện mặc định của trình duyệt */
            border: .2em solid #E91E63;
            background: hsl(0, 0%, 100%, 0); /* Trong suốt */
            padding: .85em 1.5em;
            color: #E91E63;
            border-radius: 2em;
            /* transition: background 0.3s, color 0.3s; Hiệu ứng mượt */
            cursor: pointer;
        }

        /* Hiệu ứng khi hover, focus, hoặc active */
        .btnupfile:hover,
        .btnupfile:focus,
        .btnupfile:active {
            background: #E91E63;
            color: #fff;
        }

        .btnuppost {
            font-size: 120%;
            width: 100%;
            appearance: none; /* Loại bỏ giao diện mặc định của trình duyệt */
            border: .2em solid #E91E63;
            background: hsl(0, 0%, 100%, 0); /* Trong suốt */
            padding: .85em 1.5em;
            color: #E91E63;
            border-radius: 2em;
            /* transition: background 0.3s, color 0.3s; Hiệu ứng mượt */
            cursor: pointer;
        }

        /* Hiệu ứng khi hover, focus, hoặc active */
        .btnuppost:hover,
        .btnuppost:focus,
        .btnuppost:active {
            background: #E91E63;
            color: #fff;
        }
        
        /* Ẩn input file gốc */
        input[type="file"] {
            display: none;
        }

        /* Nhãn tùy chỉnh */
        label[for="file-upload"] {
            display: grid;
            grid-auto-flow: column;
            grid-gap: .5em;
            justify-items: center;
            align-content: center;
            color: #E91E63;
            border: .2em solid #E91E63;
            background: hsla(0, 0%, 0%, 0);
            padding: .85em 1.5em;
            border-radius: 2em;
            transition: 0.3s;
            cursor: pointer;
        }

        label[for="file-upload"]:hover {
            background: #E91E63;
            color: #fff;
        }

        /* Vùng hiển thị đường dẫn file */
        #file-path {
            margin-top: 10px;
            font-style: italic;
            color: #555;
        }


        #wrapper{
            max-width: 960px;
            margin: 0px auto;
        }
        #titlepost {
            width: 100%;
            font-size: 150%;
            appearance: none;
            border: none;
            outline: none;
            border-bottom: .2em solid #E91E63;
            background: rgba(#E91E63, .2);
            border-radius: .2em .2em 0 0;
            padding: .4em;
            color: #E91E63;
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

    <!-- body -->
    <?php
    $imageUrl = "";  // Khởi tạo giá trị mặc định cho $imageUrl
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
        // Thay bằng API key của bạn từ ImgBB
        $apiKey = 'c6bb50adb858fa103be0b7e562a22185';
        $file = $_FILES['image']['tmp_name'];

        // Đọc file ảnh và encode sang base64
        $base64 = base64_encode(file_get_contents($file));

        // API URL của ImgBB
        $url = 'https://api.imgbb.com/1/upload';
        
        // Dữ liệu cần gửi
        $data = [
            'key' => $apiKey,
            'image' => $base64
        ];

        // Khởi tạo cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Thực thi và lấy kết quả
        $response = curl_exec($ch);
        curl_close($ch);

        // Giải mã JSON trả về
        $result = json_decode($response, true);

        // Xử lý kết quả
        if (isset($result['data']['url'])) {
            $imageUrl = $result['data']['url'];
            $_SESSION['imagepost'] = $imageUrl;
            echo "Ảnh đã được tải lên thành công: <a href='$imageUrl' target='_blank'>$imageUrl</a>";
        } else {
            echo "Lỗi khi upload ảnh: " . ($result['error']['message'] ?? 'Không rõ lỗi.');
        }
    } else {
        echo "Vui lòng chọn ảnh để upload.";
    }

    // Phần còn lại của mã
    $post = $PostBLL->PostDetail($idpost);

    $selected_option = isset($_POST['option']) ? $_POST['option'] : null;
    $ideapost = ($selected_option == 1) ? "idea" : "solution";

    // Cập nhật bài viết nếu người dùng gửi form
    
    if (isset($_POST['btn-add'])) {
        if($idpost == 0){
            echo $PostBLL->insertPost($_POST['title'], $_SESSION['imagepost'], $_POST['content'], $ideapost, $iduser);
        }else{
            $PostBLL->updatePost($idpost, $_POST['title'], $_SESSION['imagepost'], $_POST['content'], $ideapost);
        }
    }
    ?>

    <div id="wrapper">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="file-upload" class="custom-file-upload">Chọn ảnh Đại Diện</label>
            <input type="file" name="image" id="file-upload" accept="image/*" required>
            <div id="file-path">Chưa chọn file nào</div>
            <button type="submit" class="btnupfile">Tải lên</button>
        </form>

        <form action="" method="post">
            <img src="
            <?php 
            if($idpost == 0){
                if(!empty($imageUrl)){
                    echo $imageUrl;
                }else echo "";
            }else{
                if (empty($imageUrl)) {
                    echo $post['imagepost'];
                }else{
                    echo $imageUrl;
                }
            }
            ?>" alt="" id="wrapper">

            <div class="radio-group">
                <label><input type="radio" name="option" value="1" checked>Ý Tưởng</label>
                <label><input type="radio" name="option" value="2">Giải Pháp</label>
            </div><br>

            <input type="text" name="title" id="titlepost" placeholder="Nhập tiêu đề..." value="<?php if ($idpost != 0) echo $post['titlepost']; ?>"><br>

            <textarea class="mytextarea" rows="50" name="content"><?php if ($idpost != 0) echo $post['contentpost']; ?></textarea><br>

            <input type="submit" value="Thêm bài viết" name="btn-add" class="btnuppost">
        </form><br>
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
    <script src="https://cdn.tiny.cloud/1/pzf2lk3aq9c4b74wdks1bkdtzi8ehs96rdmlgk1tltggbhxg/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // JavaScript để hiển thị đường dẫn file
        const fileInput = document.getElementById('file-upload');
        const filePathDisplay = document.getElementById('file-path');

        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                // Hiển thị tên file đã chọn
                filePathDisplay.textContent = fileInput.files[0].name;
            } else {
                filePathDisplay.textContent = "Chưa chọn file nào";
            }
        });

        tinymce.init({
            selector: '.mytextarea',
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern',
                'image'
            ],
            toolbar: [
                'undo redo | bold italic underline strikethrough | fontselect fontsizeselect | image',
                'forecolor backcolor | alignleft aligncenter alignright alignjustify | outdent indent',
                'bullist numlist | link media | insertdatetime preview | table emoticons',
                'code fullscreen | cut copy paste'
            ],
            menubar: true,
            statusbar: true,
            toolbar_mode: 'sliding',
            automatic_uploads: false,  // Tắt tải ảnh tự động
            file_picker_types: 'image',  // Chỉ chọn ảnh
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'image') {
                    var input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'image/*';  // Chỉ cho phép ảnh

                    input.onchange = function () {
                        var file = input.files[0];
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            // Đảm bảo rằng Base64 được chèn đúng
                            var base64Image = e.target.result;

                            // Gọi lại callback và chèn ảnh vào TinyMCE
                            callback(base64Image, { alt: file.name });
                        };

                        reader.readAsDataURL(file);  // Đọc file và chuyển thành Base64
                    };

                    input.click();  // Mở hộp thoại chọn ảnh
                }
            }
        });
    </script>  
</body>
</html>