-- =========================================================================================================================
-- POSTS

CREATE TABLE posts (
	idpost INT AUTO_INCREMENT PRIMARY KEY,
	titlepost VARCHAR(250) NOT NULL,
	imagepost TEXT NOT NULL
	contentpost LONGTEXT NOT NULL,
	ideapost ENUM('idea', 'solution') DEFAULT 'solution',
	statuspost ENUM('Pending', 'Approved', 'ignored') DEFAULT 'Pending',
	createatpost DATETIME DEFAULT CURRENT_TIMESTAMP,
	updatedatpost DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	iduser INT,
	FOREIGN KEY (iduser) REFERENCES users(iduser)
)

ALTER TABLE posts ADD descriptionpost TEXT

ALTER TABLE posts ADD visibilitypost ENUM('public', 'protected', 'private') DEFAULT 'public'

SELECT idpost, titlepost, visibilitypost FROM posts

SELECT * FROM posts

UPDATE posts
SET statuspost = 'ignored'
WHERE idpost = 1; 

UPDATE posts
SET titlepost = '', imagepost = '', contentpost = '', ideapost = ''
WHERE idpost = 1; 

DELETE FROM posts WHERE idpost = 16

DELETE FROM likes WHERE idpost = 2 AND iduser = 1

INSERT INTO posts (titlepost, imagepost, contentpost, ideapost, iduser) VALUES 
('titlepost', 'imagepost', 'contentpost', 'ideapost', 1)

INSERT INTO posts (titlepost, contentpost, ideapost, statuspost, iduser)
VALUES
    ('Innovative Recycling Solution', 'A detailed description of an innovative recycling process.', 'solution', 'Approved', 1),
    ('New Sustainable Idea', 'Proposing a method to reduce carbon emissions.', 'idea', 'Pending', 2),
    ('Optimizing Solar Panel Efficiency', 'Research and development to enhance solar panel productivity.', 'solution', 'Approved', 3),
    ('Addressing Water Scarcity', 'An idea to efficiently harvest rainwater.', 'idea', 'Pending', 1),
    ('AI in Education', 'Using artificial intelligence to personalize learning experiences.', 'solution', 'Ignored', 4);
INSERT INTO posts (titlepost, imagepost, contentpost, ideapost, statuspost, iduser)
VALUES
('Quantum Solar System: Trải nghiệm vẻ đẹp và sự kỳ diệu của hệ mặt trời ngay trong chính ngôi nhà của mình', 'https://sanytuong.vn/wp-content/uploads/2024/09/quantum-thumbnail.jpg', '<p>Được chế tạo với độ ch&iacute;nh x&aacute;c cao v&agrave; c&ocirc;ng nghệ ti&ecirc;n tiến,Quantum Solar System sẽ&nbsp;đưa người&nbsp;d&ugrave;ng&nbsp;đến một thế giới thu nhỏ của vũ trụ. Với sự hỗ trợ của c&ocirc;ng nghệ bay&nbsp;từ trường ti&ecirc;n tiến, những h&agrave;nh tinh trong hệ mặt trời&nbsp;sẽ chuyển động một c&aacute;ch&nbsp;h&agrave;i h&ograve;a, tạo n&ecirc;n&nbsp;một cảnh tượng l&agrave;m say đắm người xem bằng vẻ đẹp v&agrave; t&iacute;nh ch&acirc;n thực của sản phẩm.</p>
<div class=""><img class="aligncenter" src="https://c1.iggcdn.com/indiegogo-media-prod-cld/image/upload/c_limit,w_695/v1682737367/wzvgwhzihfylksp93pe3.jpg" alt="" width="700" height="394" loading="lazy" data-shareid="#share1725441292410"></div>
<p>Mỗi h&agrave;nh tinh trong Quantum Solar System đều&nbsp;được thiết kế tỉ mỉ để phản &aacute;nh đ&uacute;ng với h&igrave;nh ảnh thực tế của những&nbsp;h&agrave;nh tinh ấy, từ đ&oacute; gi&uacute;p ch&uacute;ng ta&nbsp;kh&aacute;m ph&aacute; v&agrave; t&igrave;m hiểu về những điều kỳ diệu trong hệ mặt trời. D&ugrave; bạn l&agrave;&nbsp;người đam m&ecirc; khoa học với kiến thức s&acirc;u rộng hay l&agrave; người&nbsp;t&ograve; m&ograve; về chuyển động của hệ mặt trời, Quantum Solar System sẽ&nbsp;mang lại trải nghiệm tương t&aacute;c gi&uacute;p bạn c&oacute; th&ecirc;m nhiều th&ocirc;ng tin th&uacute; vị&nbsp;hơn về kh&ocirc;ng gian.</p>
<div class=""><img class="aligncenter" src="https://c1.iggcdn.com/indiegogo-media-prod-cld/image/upload/c_limit,w_695/v1682738564/tgwjxrlcy6vs11rgtrwt.jpg" alt="" width="700" height="394" loading="lazy" data-shareid="#share1725441292410"></div>
<p>Điều l&agrave;m n&ecirc;n sự kh&aacute;c biệt của sản phẩm&nbsp;n&agrave;y l&agrave; h&agrave;ng&nbsp;loạt những&nbsp;t&iacute;nh năng độc đ&aacute;o. Với khả năng đồng bộ thời gian thực với dữ liệu của NASA, người d&ugrave;ng c&oacute; thể quan s&aacute;t vị tr&iacute; của c&aacute;c h&agrave;nh tinh tại bất kỳ thời điểm n&agrave;o, d&ugrave; l&agrave; hiện tại,&nbsp;qu&aacute; khứ hay&nbsp;tương lai. Ngo&agrave;i ra, với khả năng cho ph&eacute;p&nbsp;t&ugrave;y chỉnh&nbsp;tốc độ quỹ đạo v&agrave; &aacute;nh s&aacute;ng LED, người d&ugrave;ng c&oacute; thể thoải m&aacute;i&nbsp;c&aacute;&nbsp;nh&acirc;n h&oacute;a sản phẩm theo &yacute; th&iacute;ch của bản th&acirc;n.</p>
<div class=""><img class="aligncenter" src="https://media.giphy.com/media/gUgC9NTUFZQXNiQSdf/giphy.gif" alt="" width="700" height="394" loading="lazy" data-shareid="#share1725441292411"></div>
<p>Bổ sung cho sức mạnh c&ocirc;ng nghệ của sản phẩm ch&iacute;nh l&agrave; thiết kế đẹp mắt v&agrave; hiện đại của Quantum Solar System, điều n&agrave;y khiến sản phẩm kh&ocirc;ng chỉ l&agrave; một c&ocirc;ng cụ tri thức m&agrave; c&ograve;n l&agrave; một t&aacute;c phẩm nghệ thuật quyến rũ. Quantum Solar System kh&ocirc;ng chỉ đơn thuần l&agrave; một sản phẩm gi&uacute;p bạn quan s&aacute;t hệ mặt trời, đ&acirc;y c&ograve;n l&agrave; minh chứng cho sự kh&eacute;o l&eacute;o của con người v&agrave; l&agrave; c&aacute;nh cửa dẫn tới những v&igrave; sao.</p>', 
'idea', 'Approved', 14)
('Post Title 1', 'https://i.imgur.com/SPWii.jpg', 'Content of post 1', 'idea', 'Pending', 14),
('Post Title 2', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTB2QM5UKnJlOyj2V1XybucefG2KKJVsUHHIg&s', 'Content of post 2', 'solution', 'Approved', 2),
('Post Title 3', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvvYl8_UoYSoxDH7vFa_pM4V-rRspemON5YQ&s', 'Content of post 3', 'idea', 'Ignored', 3),
('Post Title 4', 'https://cdn.creazilla.com/cliparts/3160658/bomb-clipart-lg.png', 'Content of post 4', 'solution', 'Pending', 4),
('Post Title 5', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkO-VJC-mMxo-xNgcDIg1lrw59ONFgZ41mrw&s', 'Content of post 5', 'idea', 'Approved', 5),
('Post Title 6', 'https://i.pinimg.com/736x/9d/fc/a4/9dfca418f1307611730bc4203b51aab2.jpg', 'Content of post 6', 'solution', 'Pending', 1),
('Post Title 7', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMi2WgbdUC8YOsV1DRZKhkoe75tLO0Ne3M0A&s', 'Content of post 7', 'idea', 'Ignored', 2),
('Post Title 8', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMi2WgbdUC8YOsV1DRZKhkoe75tLO0Ne3M0A&s', 'Content of post 8', 'solution', 'Approved', 3),
('Post Title 9', 'https://images.wallpapersden.com/image/ws-monkey-luffy-4k-one-piece-2024-art_92971.jpg', 'Content of post 9', 'idea', 'Pending', 4),
('Post Title 10', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQBQZTYRIDMhP7kPN8lEt98YNnxkrFkn20ywA&s', 'Content of post 10', 'solution', 'Pending', 5);

SELECT * from posts

SELECT idpost, titlepost, imagepost, contentpost, ideapost, statuspost, createatpost, updatedatpost, 
iduser FROM posts WHERE statuspost = 'Pending'

SELECT p.idpost, p.titlepost, p.imagepost, p.contentpost, p.ideapost, p.statuspost, p.createatpost FROM posts p
JOIN users u ON u.iduser = p.iduser
WHERE u.username = 'chikiet00002'

SELECT p.idpost, p.titlepost, p.imagepost, p.contentpost, p.ideapost, p.createatpost, p.updatedatpost,
	u.fullname
FROM posts p JOIN users u ON p.iduser = u.iduser WHERE idpost = 9

SELECT p.idpost, p.titlepost, p.ideapost, p.statuspost, u.username, u.email
FROM posts p
JOIN users u ON p.iduser = u.iduser;

SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.createatpost
FROM posts p 
JOIN users u ON u.iduser = p.iduser
WHERE statuspost = 'Pending' ORDER BY createatpost;

SELECT p.idpost, p.titlepost, p.imagepost, u.fullname, p.createatpost
FROM posts p 
JOIN users u ON u.iduser = p.iduser
WHERE statuspost = 'Pending' AND titlepost LIKE '%post%' OR contentpost LIKE '%post%';

SELECT * 
FROM posts
WHERE titlepost LIKE '%Innovative%' OR contentpost LIKE '%Innovative%';

SELECT COUNT(l.idlike)
FROM likes l JOIN users u ON u.iduser = l.iduser
JOIN posts p ON l.idpost = p.idpost
WHERE u.username = 'john_doe' AND p.idpost = 2