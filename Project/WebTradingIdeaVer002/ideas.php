<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/PostBLL.php';

session_start();

$UserBll = new UserBll();
$PostBLL = new PostBLL();
 
$getSearch = isset($_GET['query']) ? htmlspecialchars(trim($_GET['query'])) : '';

if(!empty($getSearch)){
    $postCreateAtPost = $PostBLL->getPendingPosts($getSearch);
}else{
    $getIndex = $_GET['index'];
    if($getIndex == 1){
        $postCreateAtPost = $PostBLL->PostIdeas("createatpost");
    }else{
        $postCreateAtPost = $PostBLL->PostSolutions("createatpost");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang 
        <?php 
        if(!empty($getSearch)){
            echo "tìm kiếm";
        }else{
            if($getIndex == 1){
                echo "ý tưởng";
            }else{
                echo "giải pháp";
            }
        }
        ?>
     - Sàn Ý Tưởng</title>
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

        <!-- Ideas List -->
    <section class="ideas-list">
        <h1>
        <?php 
        if(!empty($getSearch)){
            echo $getSearch;
        }else{
            if($getIndex == 1){
                echo "Danh sách ý tưởng";
            }else{
                echo "Danh sách giải pháp";
            }
        }
        ?> 
        </h1>
        <div class="idea-cards">
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
                            <p class="summary">Đã cập nhật: <?= htmlspecialchars($post['createatpost']) ?></p>
                            <p class="author">Tác giả: <?= htmlspecialchars($post['fullname']) ?></p>
                            <a href="idea-detail.html" class="btn detail-btn">Chi tiết</a>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p><?= htmlspecialchars($posts) ?></p>
            <?php endif; ?>
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
</body>
</html>
