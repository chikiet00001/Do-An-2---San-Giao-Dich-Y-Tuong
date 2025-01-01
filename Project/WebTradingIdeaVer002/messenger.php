<?php 
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/UserBLL.php';
require_once __DIR__ . '/../WebTradingIdea/BusinessLogicLayer/MessageBLL.php';

session_start();

ob_start();

if(empty($_SESSION['username'])){
    header("Location: index.php"); 
    exit();
    ob_end_flush();
}

$UserBll = new UserBll();
$MessageBLL = new MessageBLL();
 
$iduser = $UserBll->getUserIdByUsername($_SESSION['username']);
$chatuser = $MessageBLL->MessageChat($iduser);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Nhắn Tin</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: auto;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #00a36c;
        }

        .chat-btn, .notify-btn {
            background-color: #0078d4;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-btn:hover, .notify-btn:hover {
            background-color: #005fa3;
        }
        .messenger-container {
            display: flex;
            margin: 20px auto;
            max-width: 1200px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 80vh;
        }

        .messenger-sidebar {
            width: 30%;
            background: #f3f4f6;
            overflow-y: auto;
            padding: 10px;
            border-right: 1px solid #ccc;
        }

        .messenger-sidebar .search-bar {
            display: flex;
            margin-bottom: 10px;
        }

        .messenger-sidebar .search-bar input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 20px 0 0 20px;
            outline: none;
        }

        .messenger-sidebar .search-bar button {
            background: #0078d4;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 0 20px 20px 0;
            cursor: pointer;
        }

        .user-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .user:hover {
            background-color: #e8f0fe;
        }

        .user img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info h4 {
            margin: 0;
            font-size: 1em;
        }

        .user-info p {
            margin: 0;
            font-size: 0.8em;
            color: #777;
        }

        .messenger-chat {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 10px;
            background: #0078d4;
            color: white;
            font-size: 1.2em;
        }

        .chat-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            background: #f9f9f9;
        }

        .message {
            padding: 8px 12px;
            border-radius: 10px;
            margin: 5px 0;
            max-width: 70%;
        }

        .sent {
            background: #0078d4;
            color: white;
            align-self: flex-end;
        }

        .received {
            background: #ccc;
            align-self: flex-start;
        }

        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-right: 10px;
        }

        .chat-input button {
            background: #0078d4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-input button:hover {
            background: #005fa3;
        }
        .messenger-sidebar {
            width: 30%;
            background: #f3f4f6;
            overflow: hidden;
            padding: 10px;
            border-right: 1px solid #ccc;
            display: flex;
            flex-direction: column;
        }

        .user-list {
            flex: 1;
            overflow-y: auto;
            margin-top: 10px;
            padding: 0;
            list-style: none;
        }

        .user {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .user:hover {
            background-color: #e8f0fe;
        }

        .user img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info h4 {
            margin: 0;
            font-size: 1em;
        }

        .user-info p {
            margin: 0;
            font-size: 0.8em;
            color: #777;
        }
        .chat-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Định dạng cho từng tin nhắn */
        .message {
            display: inline-block; /* Để kích thước background bao quanh nội dung */
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 70%; /* Giới hạn chiều rộng tối đa */
            word-wrap: break-word; /* Tự động xuống dòng nếu vượt quá max-width */
            font-size: 1em;
            position: relative; /* Để sử dụng thêm các thành phần như mũi tên */
        }

        /* Tin nhắn gửi đi (bên phải) */
        .sent {
            background: #0078d4;
            color: white;
            align-self: flex-end;
            text-align: right;
        }

        /* Tin nhắn nhận được (bên trái) */
        .received {
            background: #e0e0e0;
            color: #333;
            align-self: flex-start;
            text-align: left;
        }
        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            background-color: #0078d4;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none; /* Xóa gạch chân khi sử dụng <a> */
        }

        .icon-btn:hover {
            background-color: #005fa3;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"><a >Sàn Ý Tưởng</a></div>
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

    <main class="messenger-container">
        <div class="messenger-sidebar">
            <div class="search-bar">
                <input type="text" id="user-search" placeholder="Tìm kiếm người dùng...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <ul class="user-list" id="user-list">

                <?php 
                    if(is_array($chatuser)):
                        foreach ($chatuser as $chat):
                ?>
                    <li class="user" data-id="1" data-name="<?php echo $chat['username']; ?>">
                        <img src="https://via.placeholder.com/40" alt="User Avatar">
                        <div class="user-info">
                            <h4><?php echo $chat['username']; ?></h4>
                            <p><?php echo $chat['fullname']; ?></p>
                        </div>
                    </li>
                <?php 
                    endforeach;
                endif;
                ?>
                
                
                <!-- Thêm người dùng khác -->
            </ul>
        </div>
        
        <div class="messenger-chat" id="messenger-chat">
            <div class="chat-header">
                <h4 id="chat-with">Người nhận</h4>
            </div>
            <div class="chat-messages" id="chat-messages">
                <!-- Tin nhắn sẽ được hiển thị tại đây -->

            </div>
            <div class="chat-input">
                <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
                <button id="send-button"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>        
    </main>

    <footer>
        <p>© 2024 Đại học Nam Cần Thơ - Sàn Ý Tưởng. Liên hệ: lekhoa583@gmail.com</p>
    </footer>
                
    <script>
        const searchInput = document.getElementById('user-search');
        const userList = document.getElementById('user-list');
        const users = userList.querySelectorAll('.user');
        const chatHeader = document.getElementById('chat-with');
        const chatMessages = document.querySelector('.chat-messages');
        const chatInput = document.querySelector('.chat-input input');
        const sendButton = document.querySelector('.chat-input button');
        const messageInput = document.getElementById('message-input');
        let selectedUserId = null;
        
        //Tìm kiếm người dùng
        searchInput.addEventListener('input', () => {
            const searchText = searchInput.value.toLowerCase();
            users.forEach(user => {
                const userName = user.dataset.name.toLowerCase();
                if (userName.includes(searchText)) {
                    user.style.display = 'flex'; // Hiển thị nếu khớp
                } else {
                    user.style.display = 'none'; // Ẩn nếu không khớp
                }
            });
        });

        // Hàm hiển thị hội thoại
        function loadConversation(user) {
            const userName = user.dataset.name;
            const userId = user.dataset.id;

            // Cập nhật tiêu đề chat-header
            chatHeader.textContent = userName;
            selectedUserId = userId;

            // Xóa tin nhắn cũ (hoặc tải từ cơ sở dữ liệu)
            chatMessages.innerHTML = '';

            
            // Mô phỏng tin nhắn cũ
            chatMessages.innerHTML += `
                <div class="message received">Chào bạn! Đây là tin nhắn mẫu của ${userName}.</div>
                <div class="message sent">Xin chào, có gì tôi giúp được bạn?</div>
                <div class="message sent">Xin chào, có gì tôi giúp được bạn?</div>
                <div class="message sent">Xin chào, có gì tôi giúp được bạn?</div>
                <div class="message sent">Xin chào, có gì tôi giúp được bạn?</div>
                <div class="message sent">Xin chào, có gì tôi giúp được bạn?</div>
                <div class="message sent">Xin chào, có gì tôi giúp được bạn?</div>
                <div class="message sent">Xin chào, có gì tôi giúp được bạn?</div>
            `;

            // Cuộn xuống cuối tin nhắn
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Chọn người dùng đầu tiên mặc định
        if (users.length > 0) {
            loadConversation(users[0]);
        }

        // Xử lý sự kiện click để chọn người dùng khác
        users.forEach(user => {
            user.addEventListener('click', () => {
                loadConversation(user);
            });
        });
        // Hàm gửi tin nhắn
        function sendMessage() {
            const message = messageInput.value.trim();
            if (message) {
                // Thêm tin nhắn của người gửi
                const sentMessage = document.createElement('div');
                sentMessage.classList.add('message', 'sent');
                sentMessage.textContent = message;
                chatMessages.appendChild(sentMessage);

                // Mô phỏng tin nhắn phản hồi
                setTimeout(() => {
                    const receivedMessage = document.createElement('div');
                    receivedMessage.classList.add('message', 'received');
                    receivedMessage.textContent = `Phản hồi từ ${chatHeader.textContent}`;
                    chatMessages.appendChild(receivedMessage);

                    // Cuộn xuống cuối
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 1000);

                // Xóa nội dung input và cuộn xuống
                messageInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
        // Lắng nghe sự kiện nhấn Enter
        messageInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault(); // Ngăn form submit mặc định
                sendMessage();
            }
        });

        // Lắng nghe sự kiện click nút gửi
        sendButton.addEventListener('click', sendMessage);

    </script>
</body>
</html>
