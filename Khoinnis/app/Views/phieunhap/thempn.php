<div class="detail"> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Nhập Hàng</title>
    <style>
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
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    width: calc(100% - 22px);
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    border-radius: 5px;
    border: none; /* Loại bỏ viền */
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
   <form action="<?php echo WEBROOT . 'phieunhap/taophieunhap/' ?>" method="post">

   <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>"> <!-- Thay USER_NAME bằng username thực tế -->
   <input type="hidden" name="sanpham" id="sanpham">
        <div class="container">
            <h2>Thông tin Sản Phẩm Phiếu nhập</h2>
    
            <!-- Tìm kiếm sản phẩm -->
            <div class="search-container">
                <Label>Tìm kiếm sản phẩm: </Label>
                <input type="text" id="search" placeholder="Nhập từ khóa...">
                <div id="search-results" style="position: absolute; border: 1px solid #ccc; z-index: 999;"></div> 
                <!-- <button >Tìm kiếm</button> -->
            </div>
    
            <!-- Kết quả tìm kiếm -->
            <table>
                <thead>
                    <tr>
                        <th>Mã Sản Phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Ngày Sản Xuất</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    <!-- Kết quả tìm kiếm sẽ được thêm vào đây -->
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4">Tổng Tiền</td>
                        <td id="totalAmount">0đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <button type="submit">Lưu Phiếu Nhập</button>
   </form>
 <!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const $productTable = $("#productTable");
    const $totalAmount = $("#totalAmount");
    const $sanphamInput = $("#sanpham");
    const $searchResults = $("#search-results");

    // Hàm định dạng tiền tệ
    function formatCurrency(value) {
        return value.toLocaleString('vi-VN') + " đ";
    }

    // Hàm cập nhật tổng tiền
    function updateTotalAmount() {
        let total = 0;
        $productTable.find("tr").each(function () {
            const price = parseInt($(this).find(".total-price").text().replace(/\D/g, ""), 10) || 0;
            total += price;
        });
        $totalAmount.text(formatCurrency(total));
    }

    // Hàm cập nhật dữ liệu sản phẩm vào input ẩn
    function updateSanphamData() {
        const sanphamData = [];
        $productTable.find("tr").each(function () {
            const id = $(this).find(".product-id").text();
            const name = $(this).find(".product-name").text();
            const nsx = $(this).find(".product-date").val(); 
            const quantity = $(this).find(".quantity").val();
            const price = $(this).find(".product-price").text().replace(/\D/g, "");

            sanphamData.push({
                MaSanPham: id,
                TenSanPham: name,
                NgaySanXuat: nsx,
                SoLuong: quantity,
                DonGia: price
            });
        });
        $sanphamInput.val(JSON.stringify(sanphamData)); // Ghi vào input ẩn
    }

    // Xử lý tìm kiếm sản phẩm
    $("#search").on("keyup", function () {
        const query = $(this).val().trim();
        if (query.length > 0) {
            $.ajax({
                url: "/Khoinnis/phieunhap/timkiem",
                method: "POST",
                data: { nd: query },
                success: function (response) {
                    $searchResults.html(response).show();
                }
            });
        } else {
            $searchResults.hide();
        }
    });

    // Chọn sản phẩm từ kết quả tìm kiếm
// Chọn sản phẩm từ kết quả tìm kiếm
$searchResults.on("click", "div", function () {
    const productData = $(this).data();
    let productExists = false;

    // Kiểm tra xem sản phẩm đã tồn tại trong bảng chưa
    $productTable.find("tr").each(function () {
        const $row = $(this);
        const existingProductId = $row.find(".product-id").text();

        if (existingProductId === productData.id) {
            // Nếu sản phẩm đã tồn tại, tăng số lượng
            const $quantityInput = $row.find(".quantity");
            const currentQuantity = parseInt($quantityInput.val(), 10) || 0;
            $quantityInput.val(currentQuantity + 1);

            // Cập nhật thành tiền
            const price = parseInt($row.find(".product-price").text().replace(/\D/g, ""), 10);
            $row.find(".total-price").text(formatCurrency((currentQuantity + 1) * price));

            productExists = true;
            return false; // Dừng vòng lặp
        }
    });

    // Nếu sản phẩm chưa tồn tại, thêm dòng mới
    if (!productExists) {
        const newRow = `
            <tr>
                <td class="product-id">${productData.id}</td>
                <td class="product-name">${productData.name}</td>
                <td><input type="date" class="product-date"></td>
                <td><input type="number" class="quantity" value="1" min="1"></td>
                <td class="product-price">${formatCurrency(productData.price)}</td>
                <td class="total-price">${formatCurrency(productData.price)}</td>
            </tr>
        `;
        $productTable.append(newRow);
    }

    // Cập nhật tổng tiền và dữ liệu sản phẩm
    updateTotalAmount();
    updateSanphamData();
    $searchResults.hide();
});


    // Cập nhật thành tiền khi thay đổi số lượng
    $productTable.on("input", ".quantity", function () {
        const $row = $(this).closest("tr");
        const quantity = parseInt($(this).val(), 10) || 1;
        const price = parseInt($row.find(".product-price").text().replace(/\D/g, ""), 10);
        $row.find(".total-price").text(formatCurrency(quantity * price));
        updateTotalAmount();
        updateSanphamData();
    });
    // Cập nhật dữ liệu khi thay đổi Ngày Sản Xuất
    $productTable.on("change", ".product-date", function () {
        updateSanphamData();
    });
});
</script>
</body>
</html>