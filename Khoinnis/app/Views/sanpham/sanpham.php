
    <style>
          /* Tiêu đề trang */
          h2 {
         margin-left: 30px;
           /* // background-color: #4CAF50; */
            color:  #4CAF50;
            padding: 10px 0;
            font-size: 25px;
       
        }

        /* Định dạng bảng */
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
            text-align: left;
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
.btn-add{
    text-decoration: none;
    align-items: right;

}

.btn-edit:hover i {
    color: #388E3C;
}

.btn-delete:hover i {
    color: #D32F2F;
}
/* Nút "Thêm" */
/* Nút "Thêm" */
.btn-add {
    background-color: #4CAF50; /* Màu xanh */
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 8px 10px 10px 10px; /* Thêm khoảng cách trong nút */
    position: fixed; /* Đặt nút ở vị trí cố định */
    top: 70px; /* Đặt cách từ trên xuống */
    right: 20px; /* Đặt cách từ phải vào */
    border-radius: 10px; /* Bo tròn góc nút */
    border: solid white;
    z-index: 1000; /* Đảm bảo nút hiển thị trên các phần tử khác */
}

/* Hiệu ứng hover */
.btn-add:hover {
    background-color: #388E3C; /* Màu xanh đậm hơn khi hover */
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
}

/* Biểu tượng trong nút */
.btn-add i {
    margin-right: 8px;
    font-size: 18px;
    color: white;
}

    </style>

    <div class="table-container">
        <h2>Danh Sách Sản Phẩm</h2>
        <button onclick="location.href='<?php echo WEBROOT . 'sanpham/them/' ?>'" class="btn btn-add">
            <i class="fas fa-plus"></i> Thêm Sản Phẩm
        </button>

        <table>
            <thead>
                <tr>
                    <th>Mã Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Dung Tích</th>
                    <th>Đơn Vị Tính</th>
                    <th>Hình Ảnh</th>
                    <th>Đơn Gía</th>
                    <th>Hạn sử dụng </th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
            <?php
// Duyệt qua các sản phẩm trong cơ sở dữ liệu
while ($row = $sanpham->fetch_assoc()) {
    echo "<tr>
        <td>" . htmlspecialchars($row['MaSanPham']) . "</td>
        <td>" . htmlspecialchars($row['TenSanPham']) . "</td>
        <td>" . htmlspecialchars($row['DungTich']) . "</td>
        <td>" . htmlspecialchars($row['ten_dvt']) . "</td>
        <td><img src='" . WEBROOT . 'public/img/'.$row['HinhAnh'] . "' alt='Image' width='80px;'></td>
      <td>" . number_format($row['DonGia'], 0, ',', '.') . "đ</td>

        <td>" . htmlspecialchars($row['HanSuDung']) . "</td>
        <td>
            <a href='" . WEBROOT . "sanpham/sua/" . htmlspecialchars($row['MaSanPham']) . "' class='btn btn-edit'>
                <i class='fas fa-edit'></i>
            </a>
            <a href='" . WEBROOT . "sanpham/xoa/" . htmlspecialchars($row['MaSanPham']) . "' class='btn btn-delete' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\");'>
                <i class='fas fa-trash'></i>
            </a>
        </td>
       
    </tr>";
}
?>
            </tbody>
        </table>
    </div>
    <?php 
if (isset($_SESSION['thanhcong1'])) {
    echo "<script>alert('" . addslashes($_SESSION['thanhcong1']) . "');</script>";
    unset($_SESSION['thanhcong1']);
}
?>

