
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       
        h2 {
            color: #4CAF50;
            padding: 10px 0;
        }

        table {
   width: 90%;
   margin: 20px auto;
   border-collapse: collapse;
   background-color: white;
   box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Định dạng các ô tiêu đề */
th {
   background-color: #4CAF50;
   color: white;
   padding: 12px 15px;
 
}

/* Định dạng các ô dữ liệu */
td {
   padding: 12px 15px;
   text-align: center;
   border: 1px solid #ddd;
 /* //  background-color: #f9f9f9; */
   border: none;
}
tr:nth-child(even) {
background-color: #f9f9f9; /* Màu nền cho các hàng chẵn */
}

tr:nth-child(odd) {
background-color: #ffffff; /* Màu nền cho các hàng lẻ */
}

/* Hiệu ứng hover cho các hàng */
tr:hover {
   background-color: #f1f1f1;
}

/* Định dạng tiêu đề bảng và các cột */
.table-container {
   margin-left:250px;
   /* max-width: 1200px; */
   margin-top:60px;

   overflow-x: auto;
}

/* Thêm hiệu ứng hover khi di chuột qua các hàng */
tr:hover {
   background-color: #f1f1f1;
}

/* Định dạng bảng trên các thiết bị di động */
@media (max-width: 600px) {
   table {
       width: 100%;
   }
   th, td {
       font-size: 14px;
   }
}

        .btn-add {
            position: fixed;
            top: 70px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
        }

        .btn-add:hover {
            background-color: #388E3C;
            transform: scale(1.05);
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            max-width: 1200px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1001;
            border-radius: 10px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-edit i, .btn-delete i {
    font-size: 1.2rem;
    color: #4CAF50; /* Màu cho nút sửa */
    margin-right: 5px;
}

.btn-delete i {
    color: #FF4B4B; /* Màu cho nút xóa */
}

.btn-edit, .btn-delete  {
    text-decoration: none;
    padding: 5px;
}


.btn-edit:hover i {
    color: #388E3C;
}

.btn-delete:hover i {
    color: #D32F2F;
}
    </style>
    <div class="table-container">

<body>

    <button class="btn-add" onclick="location.href='<?php echo WEBROOT . 'phieunhap/them/' ?>'">
        <i class="fas fa-plus"></i> Tạo Phiếu Nhập
    </button>

    <h2>Danh Sách Phiếu nhập</h2>

    <table>
        <thead>
            <tr>
                <th>Mã Phiếu nhập</th>
                <th>Tên nhân viên</th>
                <th>Ngày nhập</th>
                <th>Tổng tiền</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($phieunhap)) { ?>
                <tr onclick="openPopup('<?php echo $row['MaPhieuNhap']; ?>')">
                    <td><?php echo htmlspecialchars($row['MaPhieuNhap']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['NgayNhap']); ?></td>
                    <td><?php echo number_format($row['TongTien'], 0, ',', '.') . " VNĐ"; ?></td>
                    <td>
    <a href="<?php echo WEBROOT . 'phieunhap/sua/' . htmlspecialchars($row['MaPhieuNhap']); ?>" class="btn btn-edit">
        <i class="fas fa-edit"></i>
    </a>
    <a href="<?php echo WEBROOT . 'phieunhap/xoa/' . htmlspecialchars($row['MaPhieuNhap']); ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
        <i class="fas fa-trash"></i>
    </a>
</td>


                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Overlay tối màn hình -->
    <div id="overlay" class="overlay" onclick="closePopup()"></div>

    <!-- Popup chi tiết phiếu nhập -->
    <div id="orderDetailsPopup" class="popup">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Chi tiết phiếu nhập</h2>

        <table>
            <thead>
                <tr>
                    <th>Tên Sản phẩm</th>
                    <th>Mã lô</th>
                    <th>Đơn giá</th>
                    <th>Ngày sản xuất</th>
                    <th>Số lượng</th>
               
                </tr>
            </thead>
            <tbody id="productDetailsContent">
                <!-- Chi tiết được thêm động -->
            </tbody>
        </table>
    </div>

    <script>
        function openPopup(mahd) {
            const popup = document.getElementById('orderDetailsPopup');
            const overlay = document.getElementById('overlay');
            popup.style.display = 'block';
            overlay.style.display = 'block';

            const detailsContent = document.getElementById('productDetailsContent');
            detailsContent.innerHTML = '';

            // Gán dữ liệu chi tiết
            <?php while ($rowctsp = mysqli_fetch_array($chitiet)) { ?>
                if ('<?php echo $rowctsp['MaPhieuNhap']; ?>' === mahd) {
                    const newRow = `
                        <tr>
                            <td><?php echo $rowctsp['TenSanPham']; ?></td>
                            <td><?php echo $rowctsp['MaLoHang']; ?></td>
                            <td>${Intl.NumberFormat().format(<?php echo $rowctsp['DonGia']; ?>)} VNĐ</td>
                            <td><?php echo $rowctsp['NgaySanXuat']; ?></td>
                            <td><?php echo $rowctsp['SoLuong']; ?></td>
                        </tr>
                    `;
                    detailsContent.innerHTML += newRow;
                }
            <?php } ?>
        }

        function closePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('orderDetailsPopup').style.display = 'none';
        }
    </script>

</body>
</div>
</html>
