-- =========================================================================================================================
-- Notifications
CREATE TABLE notifications(
	idnotification INT AUTO_INCREMENT PRIMARY KEY,
	contentnotification TEXT NOT NULL,
	timestampnotification DATETIME DEFAULT CURRENT_TIMESTAMP,
	statusnotification BOOL DEFAULT FALSE,
	iduser INT,
	FOREIGN KEY (iduser) REFERENCES users(iduser)
);

INSERT INTO notifications (contentnotification, iduser, statusnotification)
VALUES
    ('Your post "Innovative Recycling Solution" has been approved.', 1, TRUE), -- Thông báo cho người dùng 1 (đã đọc)
    ('You have a new comment on your post "New Sustainable Idea".', 2, FALSE), -- Thông báo cho người dùng 2 (chưa đọc)
    ('Your account has been upgraded to Moderator.', 3, TRUE), -- Thông báo cho người dùng 3 (đã đọc)
    ('Your post "Optimizing Solar Panel Efficiency" is pending review.', 4, FALSE), -- Thông báo cho người dùng 4 (chưa đọc)
    ('You received a like on your post "Addressing Water Scarcity".', 1, FALSE); -- Thông báo cho người dùng 1 (chưa đọc)

SELECT * FROM notifications;

UPDATE notifications SET statusnotification = TRUE WHERE iduser = 14

SELECT n.contentnotification AS content, n.timestampnotification AS times FROM notifications n 
JOIN users u ON u.iduser = n.iduser 
WHERE u.username = 'chikiet00002' ORDER BY n.timestampnotification DESC;

SELECT  	n.idnotification,			n.contentnotification,	n.timestampnotification, 
			n.statusnotification,	u.username AS user
FROM notifications n
JOIN users u ON n.iduser = u.iduser
ORDER BY n.timestampnotification DESC;