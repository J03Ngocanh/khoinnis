

<?php if (isset($chitiet) && $chitiet->num_rows > 0): ?>
    <?php while ($row = $chitiet->fetch_assoc()): ?>
        <div>
            <strong>Mã Sản Phẩm:</strong> <?= htmlspecialchars($row['MaSanPham']) ?> |
            <strong>Số lượng:</strong> <?= htmlspecialchars($row['SoLuong']) ?> |
            <strong>Đơn giá:</strong> <?= htmlspecialchars($row['DonGia']) ?> |
            <strong>Mã Lô:</strong> <?= htmlspecialchars($row['MaLoHang']) ?>
        </div>
        <hr>
    <?php endwhile; ?>
<?php else: ?>
    <p>Không tìm thấy chi tiết phiếu nhập!</p>
<?php endif; ?>
