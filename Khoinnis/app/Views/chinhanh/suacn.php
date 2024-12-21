
<style>


/* Style cho phần chỉnh sửa chi nhánh */
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

/* Căn chỉnh các trường Mã Chi Nhánh, Tên Chi Nhánh và SĐT lên một dòng */
.form-group {
    display: flex;
    width: 100%;
    gap: 100px;
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

.button_ne{
    display:flex;
    gap: 50px;
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
    <h2>SỬA CHI NHÁNH</h2>
    <?php $row=mysqli_fetch_array($chinhanh); ?>
    <form action="<?php echo WEBROOT . 'chinhanh/xulysua' ?>" method="POST">
    <input type="hidden" id="MaChiNhanh" name="MaChiNhanh" value="<?php echo htmlspecialchars($row['MaChiNhanh']); ?>" readonly><br>

 
        <!-- Nhóm Mã Chi Nhánh, Tên Chi Nhánh và SĐT vào một dòng -->
        <div class="form-group">
        <div class="form-item">
                <label for="MaChiNhanh">Mã Chi Nhánh:</label>
                <input type="text" id="MaChiNhanh" name="MaChiNhanh" value="<?php echo htmlspecialchars($row['MaChiNhanh']); ?>" readonly>
            </div>
            <div class="form-item">
                <label for="TenChiNhanh">Tên Chi Nhánh:</label>
                <input type="text" id="TenChiNhanh" name="TenChiNhanh" value="<?php echo htmlspecialchars($row['TenChiNhanh']); ?>" required>
            </div>
            <div class="form-item">
                <label for="SoDienThoai">Số Điện Thoại:</label>
                <input type="text" id="SoDienThoai" name="SoDienThoai" value="<?php echo htmlspecialchars($row['SoDienThoai']); ?>" required>
            </div>
        </div>
        <br>
        <label for="DiaChi">Địa Chỉ:</label>
        <input type="text" id="DiaChi" name="DiaChi" value="<?php echo htmlspecialchars($row['DiaChi']); ?>" required><br>

        <label for="Email">Email:</label>
        <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($row['Email']); ?>" required><br>

       <div class="button_ne">
            <button  type="submit">Lưu Thay Đổi</button>
            <button type="reset" class="btn-cancel">Hủy</button>
       </div>
    </form>
</div>
