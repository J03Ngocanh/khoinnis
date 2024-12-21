<style>
/* Style cho phần chỉnh sửa sản phẩm */
.detail {
    margin-left: 300px;
    margin-top: 100px;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 60%;
}

.detail h2 {
    font-size: 24px;
    color: #1abc9c;
    margin-bottom: 20px;
    text-align: center;
}

.detail form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Căn chỉnh các trường Mã Sản Phẩm, Tên Sản Phẩm và Dung Tích lên một dòng */
.form-group {
    display: flex;
    width: 100%;
    gap: 20px; /* Giảm khoảng cách giữa các trường */
    align-items: center;
}

/* Căn chỉnh Dung Tích và Đơn Vị Tính cùng một dòng */
.form-group-extended {
    display: flex;
    width: 100%;
    gap: 20px;
    align-items: center;
}

/* Điều chỉnh độ rộng của Tên Sản Phẩm */
.form-item input[name="TenSanPham"] {
    width: 600px; /* Tên sản phẩm chiếm phần còn lại của dòng */
}
.form-item input[name="MaSanPham"],
.form-item input[name="DungTich"] {
    width: 200px;
}
.detail select[name="id_dvt"] {
    width: 200px;  /* Đặt chiều rộng của select */
    padding: 10px;  /* Khoảng cách bên trong select */
    font-size: 14px; /* Kích thước chữ */
    border: 1px solid #ccc; /* Đường viền của select */
    border-radius: 5px; /* Bo tròn góc */
    background-color: #f9f9f9; /* Màu nền của select */
    box-sizing: border-box; /* Đảm bảo padding được tính vào kích thước của select */
}

.detail select[name="id_dvt"]:focus {
    outline: none; /* Xóa viền khi focus */
    border-color: #1abc9c; /* Thay đổi màu viền khi focus */
    background-color: #e8f8f2; /* Thay đổi màu nền khi focus */
}


/* Các phần còn lại */
.detail label {
    font-weight: bold;
    font-size: 16px;
    color: #333;
    display: block;
}

.detail input {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
}

.detail input:focus {
    outline: none;
    border-color: #1abc9c;
}

.detail button {
    padding: 10px 15px;
    font-size: 16px;
    background-color: #1abc9c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.detail button:hover {
    background-color: #16a085;
    transform: scale(1.05);
}

.detail .btn-cancel {
    padding: 10px 15px;
    text-align: center;
    background-color: #e74c3c;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.detail .btn-cancel:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

.button_ne {
    display: flex;
    gap: 50px;
}

/* Responsive */
@media screen and (max-width: 768px) {
    .detail {
        margin-left: 20px;
        width: 100%;
    }

    /* Khi màn hình nhỏ, giữ các trường trên một dòng */
    .form-group, .form-group-extended {
        flex-direction: column;
        gap: 10px;
    }

    .form-item input[name="TenSanPham"] {
        width: 100%;
    }
}


</style>
<div class="detail"> 
    <h2>SỬA SẢN PHẨM</h2>
    <?php $row = mysqli_fetch_array($sanpham); ?>
    <form action="<?php echo WEBROOT . 'sanpham/xulysua' ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="MaSanPham" name="MaSanPham" value="<?php echo htmlspecialchars($row['MaSanPham']); ?>" readonly><br>

        <!-- Nhóm Mã Sản Phẩm và Tên Sản Phẩm vào một dòng -->
        <div class="form-group">
            <div class="form-item">
                <label for="MaSanPham">Mã Sản Phẩm:</label>
                <input type="text" id="MaSanPham" name="MaSanPham" value="<?php echo htmlspecialchars($row['MaSanPham']); ?>" readonly>
            </div>
            <div class="form-item">
                <label for="TenSanPham">Tên Sản Phẩm:</label>
                <input type="text" id="TenSanPham" name="TenSanPham" value="<?php echo htmlspecialchars($row['TenSanPham']); ?>" required>
            </div>
        </div>
        
        <!-- Nhóm Dung Tích và Đơn Vị Tính vào một dòng -->
        <div class="form-group-extended">
            <div class="form-item">
                <label for="DungTich">Dung Tích:</label>
                <input type="text" id="DungTich" name="DungTich" value="<?php echo htmlspecialchars($row['DungTich']); ?>" required>
            </div>
            <div class="form-item">
                <label for="id_dvt">Đơn Vị Tính:</label>
                <select id="id_dvt" name="id_dvt" required>
                    <?php
                    // Giả sử $dvt chứa dữ liệu đơn vị tính
                    while ($dvt = mysqli_fetch_array($donvitinh)) {
                        $selected = ($dvt['id_dvt'] == $row['id_dvt']) ? 'selected' : '';
                        echo "<option value='" . $dvt['id_dvt'] . "' $selected>" . $dvt['ten_dvt'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-item">
                <label for="DonGia">Đơn giá:</label>
                <input type="text" id="DonGia" name="DonGia" value="<?php echo htmlspecialchars($row['DonGia']); ?>" required>
            </div>
            <div class="form-item">
                <label for="HanSuDung">Hạn sử dụng:</label>
                <input type="text" id="HanSuDung" name="HanSuDung" value="<?php echo htmlspecialchars($row['HanSuDung']); ?>" required>
            </div>
          
        </div>
        
        <!-- Hình ảnh sản phẩm -->
        <label for="HinhAnh">Hình Ảnh:</label>
        <input type="file" id="HinhAnh" name="HinhAnh">
        <br>
        <img src="<?php echo WEBROOT . 'public/img/'.$row['HinhAnh'] ?> " alt="Image" width="120px;"><br>

        <div class="button_ne">
            <button type="submit">Lưu Thay Đổi</button>
            <button type="reset" class="btn-cancel">Hủy</button>
        </div>
    </form>
</div>
<script >
document.addEventListener("DOMContentLoaded", () => {
  const imageInput = document.getElementById("HinhAnh"); // Cập nhật ID cho input file
  const previewImage = document.querySelector(".detail img"); // Cập nhật selector cho ảnh xem trước
  const resetButton = document.querySelector(".btn-cancel"); // Cập nhật selector cho nút hủy
  const originalSrc = previewImage.src; // Lưu đường dẫn gốc của ảnh ban đầu

  // Xử lý khi người dùng chọn tệp
  imageInput.addEventListener("change", (event) => {
    const file = event.target.files[0];

    // Kiểm tra nếu không có tệp được chọn
    if (!file) return;

    // Kiểm tra loại tệp
    if (!file.type.startsWith("image/")) {
      alert("Vui lòng chọn một tệp hình ảnh hợp lệ.");
      imageInput.value = ""; // Reset input file
      return;
    }

    // Kiểm tra kích thước tệp (<2MB)
    if (file.size > 2 * 1024 * 1024) {
      alert("Dung lượng tệp phải nhỏ hơn 2MB.");
      imageInput.value = ""; // Reset input file
      return;
    }

    // Hiển thị ảnh xem trước
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.src = e.target.result; // Thay đổi src của ảnh xem trước
    };
    reader.readAsDataURL(file);
  });

  // Xử lý khi nhấn nút "Hủy"
  resetButton.addEventListener("click", (event) => {
    event.preventDefault(); // Ngăn chặn hành động reset mặc định của form
    previewImage.src = originalSrc; // Khôi phục ảnh gốc
    imageInput.value = ""; // Reset input file
  });
});


</script>
<?php 
if (isset($_SESSION['thanhcong'])) {
    echo "<script>alert('" . addslashes($_SESSION['thanhcong']) . "');</script>";
    unset($_SESSION['thanhcong']);
}
?>


