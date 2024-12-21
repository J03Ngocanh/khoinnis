<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
<body>
<div class="table-container">
    <h2>Danh Sách Chi Nhánh</h2>
    <button onclick="location.href='<?php echo WEBROOT . 'sanpham/them/' ?>'" class="btn btn-add">
            <i class="fas fa-plus"></i> Thêm Sản Phẩm
        </button>


        <table>
            <thead>
                <tr>
                    <th>Mã Chi Nhánh</th>
                    <th>Tên Chi Nhánh</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php
while ($row=mysqli_fetch_array($chinhanh)) {
    echo "<tr>
        <td>" . htmlspecialchars($row['MaChiNhanh']) . "</td>
        <td>" . htmlspecialchars($row['TenChiNhanh']) . "</td>
        <td>" . htmlspecialchars($row['DiaChi']) . "</td>
        <td>" . htmlspecialchars($row['SoDienThoai']) . "</td>
        <td>" . htmlspecialchars($row['Email']) . "</td>
        <td>
    <a href='" . WEBROOT . "chinhanh/sua/" . htmlspecialchars($row['MaChiNhanh']) . "' class='btn btn-edit'>
        <i class='fas fa-edit'></i>
    </a>
    <a href='" . WEBROOT . "chinhanh/xoa/" . htmlspecialchars($row['MaChiNhanh']) . "' class='btn btn-delete' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\");'>
        <i class='fas fa-trash'></i>
    </a>
        </td>

    </tr>";
}
?>

            </tbody>
        </table>
   </div>
</body>
</html>
    
</body>
</html>