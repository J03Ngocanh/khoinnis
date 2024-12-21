<?php

require_once 'core/Model.php';
#require_once 'category.php';
#require_once '../../core/Model.php';
class phieuxuatModel extends Model {
    protected $tblphieuxuat ="phieuxuat";
    protected $tbltaikhoan ="taikhoan";
    protected $tblsanpham ="sanpham";
    protected $tblchitietpx = "chitietphieuxuat";
    protected $tblchinhanh = "chinhanh";
    protected $tbllohang = "lohang";
    public function Getlistpx(){
        $sql = "SELECT * FROM $this->tblphieuxuat INNER JOIN $this->tbltaikhoan ON $this->tblphieuxuat.username = $this->tbltaikhoan.username";
        $result=$this->con->query($sql);
        return $result;
    }

    public function Getchinhanh(){
        $sql = "SELECT MaChiNhanh, TenChiNhanh FROM $this->tblchinhanh";
        $result=$this->con->query($sql);
        return $result;
    }

    public function getsp($tensp) {
        // Kiểm tra giá trị của từ khóa tìm kiếm và loại bỏ khoảng trắng thừa
        $tensp = trim($tensp); 
        
        // Prepared statement để bảo vệ khỏi SQL Injection
        $sql = "SELECT sp.MaSanPham, sp.TenSanPham, lh.MaLoHang, lh.SoLuongTon, sp.HanSuDung, lh.NgaySanXuat
                FROM $this->tblsanpham sp
                JOIN $this->tbllohang lh ON sp.MaSanPham = lh.MaSanPham
                WHERE sp.TenSanPham LIKE ? OR lh.MaLoHang LIKE ?";
    
        // Chuẩn bị câu lệnh SQL
        if ($stmt = $this->con->prepare($sql)) {
            // Bind tham số vào câu lệnh SQL
            $searchTerm = "%$tensp%";
            $stmt->bind_param("ss", $searchTerm, $searchTerm);
    
            // Thực thi câu lệnh SQL
            $stmt->execute();
    
            // Lấy kết quả truy vấn
            $result = $stmt->get_result();
    
            // Mảng lưu trữ kết quả
            $products = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = [
                    'batch_id' => $row['MaLoHang'],
                    'product_name' => $row['TenSanPham'],
                    'manufacture_date' => $row['NgaySanXuat'],  // Ngày sản xuất
                    'stock_quantity' => $row['SoLuongTon']  // Số lượng tồn
                ];
            }
    
            // Đóng kết nối prepared statement
            $stmt->close();
            
            return $products; 
        } else {
            // Nếu có lỗi trong việc chuẩn bị câu lệnh, trả về mảng rỗng
            return [];
        }
    }
    

    
    
    
    
    public function thempx($username, $MaChiNhanh) {
        try {
        
                // Chèn dữ liệu vào bảng `phieuxuat`
                $sqlInsert = "INSERT INTO $this->tblphieuxuat (username, MaChiNhanh, NgayXuat) VALUES (?, ?, NOW())";
                echo $sqlInsert;
                $stmtInsert = $this->con->prepare($sqlInsert);
        
                if (!$stmtInsert) {
                    throw new Exception("Lỗi chuẩn bị câu lệnh chèn: " . $this->con->error);
                }
        
                // Bind các tham số
                $stmtInsert->bind_param('ss', $username, $MaChiNhanh);
        
                // Thực thi câu lệnh
                if (!$stmtInsert->execute()) {
                    throw new Exception("Không thể chèn dữ liệu: " . $stmtInsert->error);
                }
    
            // Sử dụng SELECT để lấy MaPhieuNhap vừa được chèn
            $query = "SELECT MaPhieuXuat FROM $this->tblphieuxuat ORDER BY NgayXuat DESC LIMIT 1;";
            $result = $this->con->query($query);
    
            if ($row = $result->fetch_assoc()) {
                $newId = $row['MaPhieuXuat'];
                echo "Mã phiếu xuat mới tạo: " . $newId;
                return $newId;
            } else {
                throw new Exception("Không tìm thấy dữ liệu vừa chèn!");
            }
    
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function themsp_phieuxuat($username, $MaChiNhanh){

    }
}
?>