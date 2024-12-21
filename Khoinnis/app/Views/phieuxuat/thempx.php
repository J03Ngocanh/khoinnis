<div class="detail"> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Nhập Hàng</title>
    <style>
        .form-group label {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.form-group input, 
.form-group select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-group input:focus, 
.form-group select:focus {
    border-color: #1abc9c;
    box-shadow: 0 0 5px rgba(26, 188, 156, 0.5);
    outline: none;
}

.form-group input[readonly] {
    background-color: #f9f9f9;
    cursor: not-allowed;
}

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #1abc9c;
            margin-bottom: 20px;
        }

        .search-container {
            display: flex;
            margin-bottom: 20px;
        }

        .search-container input {
    border: none;
    border-bottom: 1px solid #ccc; /* Only bottom border */
    outline: none;
    border-radius: 0;
    padding-bottom: 5px; /* Adjust spacing */
}
        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
        #search-results {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    width: calc(100% - 22px); /* Giảm 22px để khớp với padding input */
    max-height: 200px; /* Giới hạn chiều cao, cho phép cuộn */
    overflow-y: auto; /* Thêm thanh cuộn dọc nếu nội dung quá nhiều */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng cho đẹp mắt */
    z-index: 1000;
    border-radius: 5px; /* Bo tròn các góc */
}

#search-results div {
    padding: 10px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.2s;
}

#search-results div:hover {
    background-color: #f2f2f2; /* Màu nền khi hover */
    color: #1abc9c; /* Đổi màu chữ khi hover */
}

#search-results div:not(:last-child) {
    border-bottom: 1px solid #eee; /* Viền ngăn cách giữa các dòng */
}
/* CSS cho nút */
button[type="submit"] {
    background-color: #4CAF50; /* Màu xanh lá cây */
    color: white;
    font-weight: bold;
    padding: 15px 20px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

/* Hiệu ứng hover */
button[type="submit"]:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

/* Hiệu ứng nhấn */
button[type="submit"]:active {
    background-color: #388e3c;
    transform: scale(0.95);
}

/* Hiệu ứng focus */
button[type="submit"]:focus {
    outline: none;
    box-shadow: 0 0 5px 3px rgba(76, 175, 80, 0.5);
}

/* Định nghĩa văn bản nút */
button[type="submit"]:hover::after {
    content: " ✓";
    font-weight: bold;
}
.flex-container {
    display: flex;
    gap: 20px; /* Khoảng cách giữa các ô input */
    margin-bottom: 20px; /* Khoảng cách dưới container */
}

.flex-container .form-group {
    flex: 1; /* Đảm bảo các ô input có kích thước đồng đều */
}

.flex-container .form-group label {
    margin-bottom: 5px;
    display: block;
    font-weight: bold;
    color: #555;
}

.flex-container .form-group input, 
.flex-container .form-group select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.2s, box-shadow 0.2s;
}

.flex-container .form-group input:focus, 
.flex-container .form-group select:focus {
    border-color: #1abc9c;
    box-shadow: 0 0 5px rgba(26, 188, 156, 0.5);
    outline: none;
}

.flex-container .form-group input[readonly] {
    background-color: #f9f9f9;
    cursor: not-allowed;
}



    </style>
</head>
<body>
<?php
// Bắt đầu session
// Kiểm tra xem username có tồn tại trong session không
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Lấy username từ session
} else {
    $username = 'hhiihhii'; // Nếu không có username trong session, gán giá trị rỗng
}


?>
   <form action="<?php echo WEBROOT . 'phieuxuat/taophieuxuat/' ?>" method="post">


  
   <input type="hidden" name="sanpham" id="sanpham">
   <div class="container">
    <h2>Thông tin phiếu xuất</h2>
   <div class="flex-container">
        <div class="form-group">
                <label for="username">Mã Nhân Viên:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="MaChiNhanh">Chi Nhánh:</label>
                <select id="MaChiNhanh" name="MaChiNhanh" required>
                    <option value="" disabled selected>Chọn chi nhánh</option>
                    <?php
             
                        while ($dvt = mysqli_fetch_array($chinhanh)) {
                        
                            echo "<option value='" . $dvt['MaChiNhanh'] . "' $selected>" . $dvt['TenChiNhanh'] . "</option>";
                        }
                        
                        ?>
                    
                </select>
            </div>
    
           
      
   </div>
  
            <h2>Thông tin Sản Phẩm Phiếu nhập</h2>
        


    
            <!-- Tìm kiếm sản phẩm -->
            <div class="search-container">
                <Label>Tìm kiếm sản phẩm: </Label>
                <input type="text" id="search" placeholder="Nhập từ khóa...">
                <div id="search-results" style="position: absolute; border: 1px solid #ccc; z-index: 999;"></div> 
                <!-- <button >Tìm kiếm</button> -->
            </div>
    
           
            <table>
    <thead>
        <tr>
            <th>Mã lô hàng</th>
            <th>Tên Sản Phẩm</th>
            <th>Ngày Sản Xuất</th>
            <th>Số lượng</th>
        </tr>
    </thead>
    <tbody id="productTable">
        <!-- Kết quả tìm kiếm sẽ được thêm vào đây -->
    </tbody>
</table>

        </div>
        <button type="submit">Lưu Phiếu Nhập</button>
   </form>
 <!-- Script -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function () {
            const $productTable = $("#productTable");
            const $sanphamInput = $("#sanpham");
            const $searchResults = $("#search-results");

            // Hàm cập nhật dữ liệu sản phẩm vào input ẩn
            function updateSanphamData() {
                const sanphamData = [];
                $productTable.find("tr").each(function () {
                    const id = $(this).find(".batch-id").text();
                    const name = $(this).find(".product-name").text();
                    const nsx = $(this).find(".product-date").val();
                    const quantity = $(this).find(".quantity").val();

                    sanphamData.push({
                        MaLoHang: id,
                        TenSanPham: name,
                        NgaySanXuat: nsx,
                        SoLuong: quantity
                    });
                });
                $sanphamInput.val(JSON.stringify(sanphamData)); // Ghi vào input ẩn
            }

            // Xử lý tìm kiếm sản phẩm
            $("#search").on("keyup", function () {
                const query = $(this).val().trim();
                if (query.length > 0) {
                    $.ajax({
                        url: "/Khoinnis/phieuxuat/timkiem",  // URL gọi controller
                        method: "POST",
                        data: { nd: query },  // Gửi từ khóa tìm kiếm
                        success: function (response) {
                            const results = JSON.parse(response);  // Giả sử kết quả trả về là một mảng JSON
                            let resultsHtml = '';
                            results.forEach(product => {
                                resultsHtml += `
                                    <div class="search-result-item" data-id="${product.batch_id}" data-name="${product.product_name}" data-nsx="${product.manufacture_date}" data-quantity="${product.stock_quantity}">
                                        Mã lô hàng: ${product.batch_id} - Tên sản phẩm: ${product.product_name} - Số lượng tồn: ${product.stock_quantity}
                                    </div>
                                `;
                            });
                            $searchResults.html(resultsHtml).show();
                        }
                    });
                } else {
                    $searchResults.hide();
                }
            });

            // Chọn sản phẩm từ kết quả tìm kiếm
          // Chọn sản phẩm từ kết quả tìm kiếm
$searchResults.on("click", ".search-result-item", function () {
    const productData = $(this).data();
    let manufactureDate = productData.nsx;

    // Chuyển đổi ngày từ dd/mm/yyyy thành yyyy-mm-dd
    const dateParts = manufactureDate.split('/');
    if (dateParts.length === 3) {
        manufactureDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
    }

    // Kiểm tra xem mã lô hàng đã tồn tại trong bảng chưa
    let existingRow = null;
    $productTable.find("tr").each(function () {
        const batchId = $(this).find(".batch-id").text();
        if (batchId === productData.id) {
            existingRow = $(this);
            return false; // Dừng vòng lặp nếu tìm thấy
        }
    });

    if (existingRow) {
        // Nếu mã lô đã tồn tại, tăng số lượng
        const quantityInput = existingRow.find(".quantity");
        const currentQuantity = parseInt(quantityInput.val(), 10);
        quantityInput.val(currentQuantity + 1); // Tăng số lượng lên 1
    } else {
        // Nếu mã lô chưa tồn tại, thêm dòng mới
        const newRow = `
            <tr>
                <td class="batch-id">${productData.id}</td>
                <td class="product-name">${productData.name}</td>
                <td><input type="date" class="product-date" value="${manufactureDate}" disabled></td>
                <td><input type="number" class="quantity" value="1" min="1"></td>
            </tr>
        `;
        $productTable.append(newRow); // Thêm sản phẩm vào bảng
    }

    $searchResults.hide(); // Ẩn kết quả tìm kiếm
    updateSanphamData(); // Cập nhật lại dữ liệu
});
});
    </script>
</body>
</html>