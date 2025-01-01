-- =========================================================================================================================
-- REPORTS
CREATE TABLE reposts(
	idrepost INT AUTO_INCREMENT PRIMARY KEY,
	contenttype ENUM ('post', 'message', 'comment') NOT NULL,
	reason VARCHAR(250) NOT NULL,
	statusrepost ENUM ('pending' ,'resolved', 'ignored') DEFAULT 'pending',
	createatrepost DATETIME DEFAULT CURRENT_TIMESTAMP,
	idreportinguser INT,
	idreporteduser INT,
	FOREIGN KEY (idreportinguser) REFERENCES users(iduser),
	FOREIGN KEY (idreporteduser) REFERENCES users(iduser)
);

UPDATE reposts
SET statusrepost = 'resolved'
WHERE idrepost = 1;

ALTER TABLE reposts ADD idpost INT;
ALTER TABLE reposts 
ADD CONSTRAINT repost_idpost
FOREIGN KEY (idpost) 
REFERENCES posts(idpost);

SELECT r.idrepost, r.contenttype, r.reason, r.statusrepost, r.createatrepost, 
r.idreportinguser, r.idreporteduser, r.idpost, u1.username, u2.username FROM reposts r 
JOIN users u1 ON u1.iduser = r.idreportinguser
JOIN users u2 ON u2.iduser = r.idreporteduser;

INSERT INTO reposts (contenttype, reason, statusrepost, idreportinguser, idreporteduser)
VALUES
    ('post', 'The content is inappropriate.', 'pending', 1, 2), -- Người dùng 1 báo cáo bài viết của người dùng 2
    ('comment', 'Contains offensive language.', 'resolved', 2, 3), -- Người dùng 2 báo cáo bình luận của người dùng 3
    ('message', 'Spam messages repeatedly sent.', 'ignored', 3, 1), -- Người dùng 3 báo cáo tin nhắn của người dùng 1
    ('post', 'The post contains false information.', 'pending', 4, 1), -- Người dùng 4 báo cáo bài viết của người dùng 1
    ('comment', 'Unnecessary and irrelevant comment.', 'pending', 2, 4); -- Người dùng 2 báo cáo bình luận của người dùng 4
    
SELECT * FROM reposts;



SELECT	r.idrepost,	r.contenttype,	r.reason,	r.statusrepost,
   r.createatrepost,	u1.username AS reporting_user,	u2.username AS reported_user
FROM reposts r
JOIN users u1 ON r.idreportinguser = u1.iduser
JOIN users u2 ON r.idreporteduser = u2.iduser
ORDER BY r.createatrepost DESC;