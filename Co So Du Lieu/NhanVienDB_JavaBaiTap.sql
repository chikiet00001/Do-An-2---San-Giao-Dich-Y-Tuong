CREATE DATABASE nhanviendb

USE nhanviendb

CREATE TABLE phong (
    maphg INT AUTO_INCREMENT,
    tenphg NVARCHAR(250) NOT NULL,
    PRIMARY KEY (maphg)
);

CREATE TABLE nhanvien(
	manv INT AUTO_INCREMENT,
	hoten NVARCHAR(250) NOT NULL,
	phai BOOL DEFAULT TRUE,
	ngaysinh DATE DEFAULT CURRENT_DATE,
	diachi NVARCHAR(250),
	luong DOUBLE NOT NULL,
	phong INT NOT NULL,
	PRIMARY KEY (manv),
	FOREIGN KEY (phong) REFERENCES phong(maphg)
);

SELECT manv, hoten, phai, ngaysinh, diachi, luong, phong FROM nhanvien

INSERT INTO phong (tenphg) VALUES 
('Phòng Kế Toán'),
('Phòng Nhân Sự'),
('Phòng IT'),
('Phòng Marketing')

INSERT INTO nhanvien (hoten, phai, ngaysinh, diachi, luong, phong) VALUE
('Nguyễn Văn A', TRUE, '1990-01-01', 'Hà Nội', 5000, 1),
('Trần Thị B', FALSE, '1992-02-02', 'TP.HCM', 6000, 2),
('Lê Minh C', TRUE, '1988-03-15', 'Đà Nẵng', 7000, 3),
('Phạm Thị D', FALSE, '1995-07-22', 'Hải Phòng', 4500, 4)
