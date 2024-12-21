<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Lô Hàng</title>
    <style>

        /* Bôi đỏ các hàng đã hết hạn */
        .expired {

    color: #b71c1c;
    font-weight: bold;

}

/* Hiệu ứng hover */
.expired:hover {
    background-color: #ffeb3d !important;
}
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
        .detail {
            margin-left:250px;
            /* max-width: 1200px; */
            margin-top:60px;
        
            overflow-x: auto;
}
        

    </style>
</head>

<body>

    <div class="detail">
        
    <h2 style="text-align: center;">Danh Sách Lô Hàng</h2>
        <table>
            <tr>
                <th>Mã Lô Hàng</th>
                <th>Mã Sản Phẩm</th>
                <th>Số Lượng Nhập</th>
                <th>Số Lượng Tồn</th>
                <th>Ngày hết hạn</th>
            </tr>

        
          
        <?php foreach ($lohang as $row): ?>
            <tr class="<?php echo $row['expiredClass']; ?>">
                <td><?php echo $row['MaLoHang']; ?></td>
                <td><?php echo $row['MaSanPham']; ?></td>
                <td><?php echo $row['SoLuongNhap']; ?></td>
                <td><?php echo $row['SoLuongTon']; ?></td>
                <td><?php echo $row['HanHetHSD'] ?? 'Không xác định'; ?></td>
            </tr>
        <?php endforeach; ?>
</table>
    </div>

</body>
</html>
