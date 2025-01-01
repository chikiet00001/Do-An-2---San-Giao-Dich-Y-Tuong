<?php
$imageUrl;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Thay bằng API key của bạn từ ImgBB
    $apiKey = '2758a8723d59e32fffc4aaf4e48e08ff';
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
        echo "Ảnh đã được tải lên thành công: <a href='$imageUrl' target='_blank'>$imageUrl</a>";
    } else {
        echo "Lỗi khi upload ảnh: " . ($result['error']['message'] ?? 'Không rõ lỗi.');
    }
} else {
    echo "Vui lòng chọn ảnh để upload.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Ảnh lên ImgBB</title>
</head>
<body>
    <h1>Upload ảnh lên ImgBB</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <img src="<?php echo $imageUrl;?>" alt="">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
