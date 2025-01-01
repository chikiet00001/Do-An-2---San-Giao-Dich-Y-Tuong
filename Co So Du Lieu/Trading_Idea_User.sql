-- =========================================================================================================================
-- USERS

CREATE TABLE users (
	iduser INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE,
	passwd VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	fullname VARCHAR(100) NOT NULL,
	dod DATE,
	organize VARCHAR(200),
	phonenumber VARCHAR(15),
	address VARCHAR(255),
	createdat DATETIME DEFAULT CURRENT_TIMESTAMP,
	updatedat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	status ENUM('active', 'inactive', 'banned') DEFAULT 'active',
	role ENUM('user', 'moderator', 'admin') DEFAULT 'user'
)

UPDATE users SET username = '', passwd = '', email = '', fullname = '', dod = '', 
organize = '', phonenumber = 0123456789, address = '', status, role WHERE iduser = 1

SELECT iduser, username, passwd, email, fullname, dod, organize, 
phonenumber, address, createdat, updatedat, status, role FROM users

UPDATE users SET passwd = 'kiet220903' WHERE username = 'chikiet00002'
 
INSERT INTO users (username, passwd, email, fullname) VALUES 
	('john_doe', 'hashed_password_123', 'john.doe@example.com', 'John Doe');
	
INSERT INTO users (username, passwd, email, fullname, dod, organize, phonenumber, address, status, role)
VALUES
    ('john_doe', 'hashed_password_123', 'john.doe@example.com', 'John Doe', '1990-05-15', 'Tech Co.', '0123456789', '123 Main St, City', 'active', 'user'),
    ('jane_admin', 'hashed_password_456', 'jane.admin@example.com', 'Jane Admin', '1985-11-23', 'Admin Org', '0987654321', '456 Market Ave, City', 'active', 'admin'),
    ('mike_mod', 'hashed_password_789', 'mike.mod@example.com', 'Mike Moderator', NULL, NULL, '0178923456', '789 Broadway, Town', 'active', 'moderator'),
    ('inactive_user', 'hashed_password_234', 'inactive.user@example.com', 'Inactive User', '1995-02-10', NULL, '0192837465', '654 Elm St, Village', 'inactive', 'user'),
    ('banned_user', 'hashed_password_567', 'banned.user@example.com', 'Banned User', '2000-07-30', NULL, NULL, '987 Pine Rd, Hamlet', 'banned', 'user');

SELECT * FROM users

SELECT COUNT(*) FROM users WHERE username = 'john_doe' AND passwd = 'hashed_password_123'

SELECT role FROM users WHERE username = 'username'

SELECT 	iduser, username, passwd, email, fullname, dod, organize, 
			phonenumber, address, createdat, updatedat, status, role
FROM users WHERE iduser = 1

SELECT iduser, username, passwd, email, fullname, dod, organize, phonenumber, address, createdat, updatedat, status, role FROM users

SELECT COUNT(*) FROM users WHERE email = 'email';