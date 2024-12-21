-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 17, 2024 lúc 08:06 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ne`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chinhanh`
--

CREATE TABLE `chinhanh` (
  `MaChiNhanh` varchar(6) NOT NULL,
  `TenChiNhanh` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chinhanh`
--

INSERT INTO `chinhanh` (`MaChiNhanh`, `TenChiNhanh`, `DiaChi`, `SoDienThoai`, `Email`) VALUES
('CN0001', 'Chi nhánh 34', 'Hà Đông - Hà Nội', '0123456789', 'email@domain.com'),
('CN0004', 'chi nhánh 2', 'Lê Duẩn - Hà Nội', '0827928097', 'ngoanh@gmail.com'),
('CN0005', 'chi nhanh ne', 'hhhhhhhhhhh', '0827928097', 'ddddd@gmail.com'),
('CN0006', 'Chi nhánh Nam Định', 'TP Nam Định', '01737432', 'ngongocanh15072311@gmail.com');

--
-- Bẫy `chinhanh`
--
DELIMITER $$
CREATE TRIGGER `trg_AutoMaChiNhanh` BEFORE INSERT ON `chinhanh` FOR EACH ROW BEGIN
    DECLARE newValue INT;
    DECLARE prefix VARCHAR(2);

    -- Tiền tố mã
    SET prefix = 'CN';

    -- Kiểm tra xem bảng IncrementTable đã có dữ liệu chưa, nếu chưa thì tạo mới
    IF (SELECT COUNT(*) FROM IncrementTable WHERE TableName = 'ChiNhanh') = 0 THEN
        -- Nếu không có dữ liệu, tạo mới
        INSERT INTO IncrementTable (TableName, CurrentValue) VALUES ('ChiNhanh', 1);
        SET newValue = 1;
    ELSE
        -- Nếu có dữ liệu, lấy giá trị hiện tại và tăng thêm 1
        UPDATE IncrementTable SET CurrentValue = CurrentValue + 1 WHERE TableName = 'ChiNhanh';
        SELECT CurrentValue INTO newValue FROM IncrementTable WHERE TableName = 'ChiNhanh';
    END IF;

    -- Gán mã tự động vào MaChiNhanh
    SET NEW.MaChiNhanh = CONCAT(prefix, LPAD(newValue, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieunhap`
--

CREATE TABLE `chitietphieunhap` (
  `MaPhieuNhap` varchar(6) NOT NULL,
  `MaLoHang` varchar(6) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(10,2) NOT NULL,
  `ThanhTien` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuxuat`
--

CREATE TABLE `chitietphieuxuat` (
  `MaPhieuXuat` varchar(6) NOT NULL,
  `MaLoHang` varchar(6) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(10,2) NOT NULL,
  `ThanhTien` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dvt`
--

CREATE TABLE `dvt` (
  `id_dvt` int(11) NOT NULL,
  `ten_dvt` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dvt`
--

INSERT INTO `dvt` (`id_dvt`, `ten_dvt`) VALUES
(1, 'chai'),
(2, 'tuýp'),
(3, 'chiếc'),
(4, 'hũ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `incrementtable`
--

CREATE TABLE `incrementtable` (
  `TableName` varchar(255) NOT NULL,
  `CurrentValue` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `incrementtable`
--

INSERT INTO `incrementtable` (`TableName`, `CurrentValue`) VALUES
('ChiNhanh', 6),
('LoHang', 1),
('NhanVien', 1),
('PhieuNhap', 1),
('PhieuXuat', 1),
('SanPham', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lohang`
--

CREATE TABLE `lohang` (
  `MaLoHang` varchar(6) NOT NULL,
  `MaSanPham` varchar(6) NOT NULL,
  `NgaySanXuat` date DEFAULT NULL,
  `SoLuongNhap` int(11) DEFAULT NULL,
  `SoLuongTon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lohang`
--

INSERT INTO `lohang` (`MaLoHang`, `MaSanPham`, `NgaySanXuat`, `SoLuongNhap`, `SoLuongTon`) VALUES
('LH0001', 'SP0001', '2024-12-01', 100, 100);

--
-- Bẫy `lohang`
--
DELIMITER $$
CREATE TRIGGER `trg_AutoMaLoHang` BEFORE INSERT ON `lohang` FOR EACH ROW BEGIN
    DECLARE newValue INT;
    DECLARE prefix VARCHAR(2);

    -- Tiền tố mã lô hàng
    SET prefix = 'LH';

    -- Kiểm tra xem bảng IncrementTable đã có dữ liệu chưa, nếu chưa thì tạo mới
    IF (SELECT COUNT(*) FROM IncrementTable WHERE TableName = 'LoHang') = 0 THEN
        -- Nếu không có dữ liệu, tạo mới
        INSERT INTO IncrementTable (TableName, CurrentValue) VALUES ('LoHang', 1);
        SET newValue = 1;
    ELSE
        -- Nếu có dữ liệu, lấy giá trị hiện tại và tăng thêm 1
        UPDATE IncrementTable SET CurrentValue = CurrentValue + 1 WHERE TableName = 'LoHang';
        SELECT CurrentValue INTO newValue FROM IncrementTable WHERE TableName = 'LoHang';
    END IF;

    -- Gán mã tự động vào MaLoHang
    SET NEW.MaLoHang = CONCAT(prefix, LPAD(newValue, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNhanVien` varchar(6) NOT NULL,
  `TenNhanVien` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNhanVien`, `TenNhanVien`) VALUES
('NV0001', 'Nguyễn Văn A');

--
-- Bẫy `nhanvien`
--
DELIMITER $$
CREATE TRIGGER `trg_AutoMaNhanVien` BEFORE INSERT ON `nhanvien` FOR EACH ROW BEGIN
    DECLARE newValue INT;
    DECLARE prefix VARCHAR(2);

    -- Tiền tố mã nhân viên
    SET prefix = 'NV';

    -- Kiểm tra xem bảng IncrementTable đã có dữ liệu chưa, nếu chưa thì tạo mới
    IF (SELECT COUNT(*) FROM IncrementTable WHERE TableName = 'NhanVien') = 0 THEN
        -- Nếu không có dữ liệu, tạo mới
        INSERT INTO IncrementTable (TableName, CurrentValue) VALUES ('NhanVien', 1);
        SET newValue = 1;
    ELSE
        -- Nếu có dữ liệu, lấy giá trị hiện tại và tăng thêm 1
        UPDATE IncrementTable SET CurrentValue = CurrentValue + 1 WHERE TableName = 'NhanVien';
        SELECT CurrentValue INTO newValue FROM IncrementTable WHERE TableName = 'NhanVien';
    END IF;

    -- Gán mã tự động vào MaNhanVien
    SET NEW.MaNhanVien = CONCAT(prefix, LPAD(newValue, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MaPhieuNhap` varchar(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `NgayNhap` date DEFAULT NULL,
  `TongTien` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `phieunhap`
--
DELIMITER $$
CREATE TRIGGER `trg_AutoMaPhieuNhap` BEFORE INSERT ON `phieunhap` FOR EACH ROW BEGIN
    DECLARE newValue INT;
    DECLARE prefix VARCHAR(2);

    -- Tiền tố mã phiếu nhập
    SET prefix = 'PN';

    -- Kiểm tra xem bảng IncrementTable đã có dữ liệu chưa, nếu chưa thì tạo mới
    IF (SELECT COUNT(*) FROM IncrementTable WHERE TableName = 'PhieuNhap') = 0 THEN
        -- Nếu không có dữ liệu, tạo mới
        INSERT INTO IncrementTable (TableName, CurrentValue) VALUES ('PhieuNhap', 1);
        SET newValue = 1;
    ELSE
        -- Nếu có dữ liệu, lấy giá trị hiện tại và tăng thêm 1
        UPDATE IncrementTable SET CurrentValue = CurrentValue + 1 WHERE TableName = 'PhieuNhap';
        SELECT CurrentValue INTO newValue FROM IncrementTable WHERE TableName = 'PhieuNhap';
    END IF;

    -- Gán mã tự động vào MaPhieuNhap
    SET NEW.MaPhieuNhap = CONCAT(prefix, LPAD(newValue, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuat`
--

CREATE TABLE `phieuxuat` (
  `MaPhieuXuat` varchar(6) NOT NULL,
  `MaNhanVien` varchar(6) NOT NULL,
  `MaChiNhanh` varchar(6) NOT NULL,
  `NgayXuat` date DEFAULT NULL,
  `TongTien` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Bẫy `phieuxuat`
--
DELIMITER $$
CREATE TRIGGER `trg_AutoMaPhieuXuat` BEFORE INSERT ON `phieuxuat` FOR EACH ROW BEGIN
    DECLARE newValue INT;
    DECLARE prefix VARCHAR(2);

    -- Tiền tố mã phiếu xuất
    SET prefix = 'PX';

    -- Kiểm tra xem bảng IncrementTable đã có dữ liệu chưa, nếu chưa thì tạo mới
    IF (SELECT COUNT(*) FROM IncrementTable WHERE TableName = 'PhieuXuat') = 0 THEN
        -- Nếu không có dữ liệu, tạo mới
        INSERT INTO IncrementTable (TableName, CurrentValue) VALUES ('PhieuXuat', 1);
        SET newValue = 1;
    ELSE
        -- Nếu có dữ liệu, lấy giá trị hiện tại và tăng thêm 1
        UPDATE IncrementTable SET CurrentValue = CurrentValue + 1 WHERE TableName = 'PhieuXuat';
        SELECT CurrentValue INTO newValue FROM IncrementTable WHERE TableName = 'PhieuXuat';
    END IF;

    -- Gán mã tự động vào MaPhieuXuat
    SET NEW.MaPhieuXuat = CONCAT(prefix, LPAD(newValue, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSanPham` varchar(6) NOT NULL,
  `TenSanPham` varchar(100) NOT NULL,
  `DungTich` varchar(50) DEFAULT NULL,
  `id_dvt` int(11) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `HanSuDung` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSanPham`, `TenSanPham`, `DungTich`, `id_dvt`, `HinhAnh`, `HanSuDung`) VALUES
('SP0001', 'Xịt khoáng dưỡng ẩm trà xanh INNISFREE Green Tea Hyaluronic Mist ', '200 mL', 1, 'toner_2.jpg', '3 năm'),
('SP0002', 'Xịt khoáng dưỡng ẩm trà xanh INNISFREE Green Tea Hyaluronic Mist ', '200 mL', 3, 'mat_na_1.jpg', '3 năm'),
('SP0003', 'Xịt khoáng dưỡng ẩm trà xanh INNISFREE Green Tea Hyaluronic Mist ', '200 mL', 3, 'toner_2.jpg', '3 năm'),
('SP0004', 'Xịt khoáng dưỡng ẩm trà xanh INNISFREE Green Tea Hyaluronic Mist ', '200 mL', 2, 'sua_duong_2.jpg', '3 năm'),
('SP0005', 'Xịt khoáng dưỡng ẩm trà xanh INNISFREE Green Tea Hyaluronic Mist ', '200 mL', 3, 'srm2.jpg', '4 năm');

--
-- Bẫy `sanpham`
--
DELIMITER $$
CREATE TRIGGER `trg_AutoMaSanPham` BEFORE INSERT ON `sanpham` FOR EACH ROW BEGIN
    DECLARE newValue INT;
    DECLARE prefix VARCHAR(2);

    -- Tiền tố mã sản phẩm
    SET prefix = 'SP';

    -- Kiểm tra xem bảng IncrementTable đã có dữ liệu chưa, nếu chưa thì tạo mới
    IF (SELECT COUNT(*) FROM IncrementTable WHERE TableName = 'SanPham') = 0 THEN
        -- Nếu không có dữ liệu, tạo mới
        INSERT INTO IncrementTable (TableName, CurrentValue) VALUES ('SanPham', 1);
        SET newValue = 1;
    ELSE
        -- Nếu có dữ liệu, lấy giá trị hiện tại và tăng thêm 1
        UPDATE IncrementTable SET CurrentValue = CurrentValue + 1 WHERE TableName = 'SanPham';
        SELECT CurrentValue INTO newValue FROM IncrementTable WHERE TableName = 'SanPham';
    END IF;

    -- Gán mã tự động vào MaSanPham
    SET NEW.MaSanPham = CONCAT(prefix, LPAD(newValue, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id_taikhoan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `sdt` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` int(11) DEFAULT NULL,
  `verification_code` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`id_taikhoan`, `username`, `password`, `sdt`, `email`, `role`, `verification_code`) VALUES
(3, 'beochan2311', '$2y$10$wzOP1m7jFbPT0To7oS9jU.nfgds/ecaCE7QLsQUvVbfRQHXaTaKke', 827928097, 'ngongocanh15072311@gmail.com', NULL, 501111),
(4, 'ngocanh2311', '$2y$10$t1ZeG2yO1G7e2GGTOouFlutinu0TKXCOrwQDE1POG3kPbLFU451B.', 0, 'ngrgrwg@gmail.com', NULL, NULL),
(5, 'anhne', '$2y$10$CG1NsE.2hkq5zlNnVcElr.PhfPIBicM04Tbd0B/ACkDOpzl6LjbNS', 123456, 'ngongocanh@gmail.com', NULL, NULL),
(6, 'ngongocanh', '$2y$10$y4MRBh.cffNiCey4QHOLDuBP58iETLsTMvL5/IM4B0Uj15WHGQNfG', 12862764, 'nvkjwwr@gmail.com', NULL, NULL),
(7, 'anhnene', '$2y$10$Olv9bWd9VdAmhuD45HijAeBCx7riQMz5t0GtXQQlfH3GFq9NCDsMi', 98765, 'theducnguyen17@gmail.com', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chinhanh`
--
ALTER TABLE `chinhanh`
  ADD PRIMARY KEY (`MaChiNhanh`);

--
-- Chỉ mục cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD PRIMARY KEY (`MaPhieuNhap`,`MaLoHang`),
  ADD KEY `MaLoHang` (`MaLoHang`);

--
-- Chỉ mục cho bảng `chitietphieuxuat`
--
ALTER TABLE `chitietphieuxuat`
  ADD PRIMARY KEY (`MaPhieuXuat`,`MaLoHang`),
  ADD KEY `MaLoHang` (`MaLoHang`);

--
-- Chỉ mục cho bảng `dvt`
--
ALTER TABLE `dvt`
  ADD PRIMARY KEY (`id_dvt`);

--
-- Chỉ mục cho bảng `incrementtable`
--
ALTER TABLE `incrementtable`
  ADD PRIMARY KEY (`TableName`);

--
-- Chỉ mục cho bảng `lohang`
--
ALTER TABLE `lohang`
  ADD PRIMARY KEY (`MaLoHang`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNhanVien`);

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaPhieuNhap`);

--
-- Chỉ mục cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD PRIMARY KEY (`MaPhieuXuat`),
  ADD KEY `MaNhanVien` (`MaNhanVien`),
  ADD KEY `MaChiNhanh` (`MaChiNhanh`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSanPham`),
  ADD KEY `fk_dvt` (`id_dvt`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id_taikhoan`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dvt`
--
ALTER TABLE `dvt`
  MODIFY `id_dvt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id_taikhoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `chitietphieunhap_ibfk_1` FOREIGN KEY (`MaPhieuNhap`) REFERENCES `phieunhap` (`MaPhieuNhap`),
  ADD CONSTRAINT `chitietphieunhap_ibfk_2` FOREIGN KEY (`MaLoHang`) REFERENCES `lohang` (`MaLoHang`);

--
-- Các ràng buộc cho bảng `chitietphieuxuat`
--
ALTER TABLE `chitietphieuxuat`
  ADD CONSTRAINT `chitietphieuxuat_ibfk_1` FOREIGN KEY (`MaPhieuXuat`) REFERENCES `phieuxuat` (`MaPhieuXuat`),
  ADD CONSTRAINT `chitietphieuxuat_ibfk_2` FOREIGN KEY (`MaLoHang`) REFERENCES `lohang` (`MaLoHang`);

--
-- Các ràng buộc cho bảng `lohang`
--
ALTER TABLE `lohang`
  ADD CONSTRAINT `lohang_ibfk_1` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`),
  ADD CONSTRAINT `phieunhap_ibfk_2` FOREIGN KEY (`MaChiNhanh`) REFERENCES `chinhanh` (`MaChiNhanh`);

--
-- Các ràng buộc cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD CONSTRAINT `phieuxuat_ibfk_1` FOREIGN KEY (`MaNhanVien`) REFERENCES `nhanvien` (`MaNhanVien`),
  ADD CONSTRAINT `phieuxuat_ibfk_2` FOREIGN KEY (`MaChiNhanh`) REFERENCES `chinhanh` (`MaChiNhanh`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_dvt` FOREIGN KEY (`id_dvt`) REFERENCES `dvt` (`id_dvt`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
