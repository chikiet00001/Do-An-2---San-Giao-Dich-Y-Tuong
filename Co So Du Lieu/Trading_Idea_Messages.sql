-- =========================================================================================================================
-- MESSAGES
CREATE TABLE messages(
	idmessage INT AUTO_INCREMENT PRIMARY KEY,
	contentmessage TEXT NOT NULL,
	timestampmessage DATETIME DEFAULT CURRENT_TIMESTAMP,
	statusmessage BOOL DEFAULT FALSE,
	idusersender INT,
	iduserreceiver INT, 
	FOREIGN KEY (idusersender) REFERENCES users(iduser),
	FOREIGN KEY (iduserreceiver) REFERENCES users(iduser)
)

SELECT DISTINCT u.iduser, u.username, u.fullname, u.email
FROM messages s JOIN users u ON u.iduser = s.idusersender OR u.iduser = s.iduserreceiver
WHERE (idusersender = 1 OR iduserreceiver = 1) AND u.iduser != 1 ORDER BY timestampmessage DESC 

SELECT * FROM users

SELECT iduser, username, fullname, email
FROM users
WHERE username LIKE '%jane_admin%' OR fullname LIKE '%jane_admin%' OR email LIKE '%jane_admin%'

SELECT u1.username AS sender,
    u2.username AS receiver,
    m.contentmessage
FROM messages m
JOIN users u1 ON m.idusersender = u1.iduser
JOIN users u2 ON m.iduserreceiver = u2.iduser	

INSERT INTO messages (contentmessage, idusersender, iduserreceiver, statusmessage)
VALUES
    ('Hello, how are you?', 14, 5, TRUE), -- Người dùng 1 gửi tin nhắn cho người dùng 2 (đã đọc)
    ('I am fine, thanks!', 2, 1, TRUE), -- Người dùng 2 gửi trả lời cho người dùng 1 (đã đọc)
    ('Can we meet tomorrow?', 1, 3, FALSE), -- Người dùng 1 gửi tin nhắn cho người dùng 3 (chưa đọc)
    ('Sure, what time?', 3, 1, FALSE), -- Người dùng 3 gửi trả lời cho người dùng 1 (chưa đọc)
    ('Did you finish the project?', 2, 4, TRUE);
    
SELECT * FROM messages;

SELECT 
    m.idmessage,
    u1.username AS sender,
    u2.username AS receiver,
    m.contentmessage,
    m.timestampmessage,
    m.statusmessage
FROM messages m
JOIN users u1 ON m.idusersender = u1.iduser
JOIN users u2 ON m.iduserreceiver = u2.iduser;

INSERT INTO messages (contentmessage, idusersender, iduserreceiver, statusmessage)
VALUES
    ('Are you free this weekend?', 1, 2, FALSE), -- Người dùng 1 hỏi người dùng 2
    ('Yes, I am. Do you have any plans?', 2, 1, FALSE), -- Người dùng 2 trả lời
    ('I was thinking we could go hiking.', 1, 2, FALSE), -- Người dùng 1 gợi ý
    ('Sounds great! What time should we meet?', 2, 1, FALSE), -- Người dùng 2 đồng ý
    ('Let’s meet at 8 AM at the park entrance.', 1, 2, FALSE); -- Người dùng 1 đưa thời gian

SELECT m.* FROM messages m 
JOIN users u1 ON m.idusersender = u1.iduser
JOIN users u2 ON m.iduserreceiver = u2.iduser 
WHERE (m.idusersender = 1 AND m.iduserreceiver = 2) OR (m.idusersender = 2 AND m.iduserreceiver = 1) 
ORDER BY m.timestampmessage;