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
    gap: 50px;
    align-items: center;
}

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


/* Responsive */
@media screen and (max-width: 768px) {
    .detail {
        margin-left: 20px;
        width: 100%;
    }

    /* Khi màn hình nhỏ, giữ các trường trên một dòng */
    .form-group {
        flex-direction: column;
        gap: 10px;
    }
}

</style>

<div class="detail"> 
    <h2>THÊM SẢN PHẨM</h2>
    <form action="<?php echo WEBROOT . 'sanpham/xulythem' ?>" method="POST" enctype="multipart/form-data">
        <!-- Nhóm Mã Sản Phẩm, Tên Sản Phẩm và Dung Tích vào một dòng -->
            <div class="form-item">
                <label for="TenSanPham">Tên Sản Phẩm:</label>
                <input type="text" id="TenSanPham" name="TenSanPham" value="" required>
            </div>
         
     
        <div class="form-group">
            <div class="form-item">
                <label for="DungTich">Dung Tích:</label>
                <input type="text" id="DungTich" name="DungTich" value="" required>
            </div>
            <div class="form-item">
            <label for="id_dvt">Đơn Vị Tính:</label>
        <select id="id_dvt" name="id_dvt" required>
            <!-- Giả sử bạn có một mảng các đơn vị tính để lựa chọn -->
            <?php
            // Giả sử $dvt chứa dữ liệu đơn vị tính
            while ($dvt = mysqli_fetch_array($donvitinh)) {
                echo "<option value='" . $dvt['id_dvt'] . "'>" . $dvt['ten_dvt'] . "</option>";
            }
            ?>
        </select>
            </div>
            <div class="form-item">
                <label for="DonGia">Đơn giá:</label>
                <input type="text" id="DonGia" name="DonGia" value="" required>
            </div>
            <div class="form-item">
                <label for="HanSuDung">Hạn sử dụng:</label>
                <input type="text" id="HanSuDung" name="HanSuDung" value="" required>
            </div>
            

        </div>
  

        <!-- Hình ảnh sản phẩm -->
        <label for="HinhAnh">Hình Ảnh:</label>
        <input type="file" id="HinhAnh" name="HinhAnh"><br>

        <div class="button_ne">
            <button type="submit">Thêm sản phẩm</button>
            <button type="reset" class="btn-cancel">Hủy</button>
        </div>
    </form>
</div>
<script >
document.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('HinhAnh'); // Cập nhật selector cho file input
  const formResetButton = document.querySelector('.btn-cancel'); // Cập nhật selector cho nút reset
  const previewImageContainer = document.createElement('div');

  // Thêm container hiển thị ảnh xem trước
  previewImageContainer.style.marginTop = '10px';
  previewImageContainer.innerHTML = '<img id="preview-image" style="width: 500px; display: none; border: 1px solid #ccc; border-radius: 5px;" />';

  // Chèn container vào sau file input
  fileInput.insertAdjacentElement('afterend', previewImageContainer);

  const previewImage = document.getElementById('preview-image');

  // Lắng nghe sự kiện thay đổi file input
  fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];

    // Kiểm tra nếu không có file
    if (!file) {
      previewImage.style.display = 'none';
      return;
    }

    // Kiểm tra loại file
    if (!file.type.startsWith('image/')) {
      alert('Vui lòng chọn tệp ảnh hợp lệ!');
      fileInput.value = ''; // Reset input
      previewImage.style.display = 'none';
      return;
    }

    // Kiểm tra kích thước file (giới hạn 2MB)
    if (file.size > 2 * 1024 * 1024) {
      alert('Kích thước tệp không được vượt quá 2MB!');
      fileInput.value = ''; // Reset input
      previewImage.style.display = 'none';
      return;
    }

    // Hiển thị ảnh xem trước
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.src = e.target.result;
      previewImage.style.display = 'block'; // Hiển thị ảnh sau khi load
    };
    reader.readAsDataURL(file);
  });

  // Reset ảnh xem trước khi nhấn nút hủy
  formResetButton.addEventListener('click', () => {
    previewImage.style.display = 'none';
    fileInput.value = ''; // Reset input file
  });
});



</script>
<?php 
if (isset($_SESSION['loi'])) {
    echo "<script>alert('" . addslashes($_SESSION['loi']) . "');</script>";
    unset($_SESSION['loi']);
}
?>

