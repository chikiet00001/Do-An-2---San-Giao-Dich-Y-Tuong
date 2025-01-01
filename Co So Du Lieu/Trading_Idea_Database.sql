CREATE DATABASE trading_idea

USE trading_idea




-- =========================================================================================================================
-- LIKES
CREATE TABLE likes(
	idlike INT AUTO_INCREMENT PRIMARY KEY,	
	createatlike DATETIME DEFAULT CURRENT_TIMESTAMP,
	iduser INT,
	idpost INT,
	FOREIGN KEY (iduser) REFERENCES users(iduser),
	FOREIGN KEY (idpost) REFERENCES posts(idpost)
)

SELECT COUNT(*) FROM likes l 
JOIN posts p ON p.idpost = l.idpost WHERE p.idpost = 1;

INSERT INTO likes (iduser, idpost)
VALUES
    (1, 2), -- Người dùng 1 thích bài viết 1
    (2, 1), -- Người dùng 2 thích bài viết 1
    (3, 2), -- Người dùng 3 thích bài viết 2
    (1, 3), -- Người dùng 1 thích bài viết 3
    (4, 4); -- Người dùng 4 thích bài viết 4
    
SELECT * FROM likes;

SELECT 
    l.idlike,
    u.username AS user_liked,
    p.titlepost AS post_title,
    l.createatlike
FROM likes l
JOIN users u ON l.iduser = u.iduser
JOIN posts p ON l.idpost = p.idpost;

-- =========================================================================================================================
-- COMMENTS
CREATE TABLE comments(
	idcomment INT AUTO_INCREMENT PRIMARY KEY,
	commentpost TEXT NOT NULL,
	createatcmt DATETIME DEFAULT CURRENT_TIMESTAMP,
	updateadcmt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	iduser INT,
	idpost INT,
	FOREIGN KEY (iduser) REFERENCES users(iduser),
	FOREIGN KEY (idpost) REFERENCES posts(idpost)
)

SELECT u.fullname, c.commentpost, c.updateadcmt , u.iduser FROM comments c 
JOIN posts p ON p.idpost = c.idpost 
JOIN users u ON c.iduser = u.iduser
WHERE p.idpost = 1

SELECT iduser FROM users WHERE username = 'chikiet00002'

INSERT INTO comments (commentpost, iduser, idpost) 
VALUES
    ('Good!', 1, 1),

INSERT INTO comments (commentpost, iduser, idpost)
VALUES
    ('Great idea! I love this approach.', 1, 1), -- Người dùng 1 bình luận về bài viết 1
    ('This solution seems very promising!', 2, 1), -- Người dùng 2 bình luận về bài viết 1
    ('How can we implement this?', 3, 2), -- Người dùng 3 bình luận về bài viết 2
    ('Interesting concept, but needs more details.', 4, 3), -- Người dùng 4 bình luận về bài viết 3
    ('Thanks for sharing this.', 1, 4); -- Người dùng 1 bình luận về bài viết 4
    
SELECT * FROM comments;

SELECT 
    c.idcomment,
    u.username AS user_commented,
    p.titlepost AS post_title,
    c.commentpost,
    c.createatcmt,
    c.updateadcmt
FROM comments c
JOIN users u ON c.iduser = u.iduser
JOIN posts p ON c.idpost = p.idpost;




