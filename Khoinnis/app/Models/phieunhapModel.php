<?php

require_once 'core/Model.php';
#require_once 'category.php';
#require_once '../../core/Model.php';
class phieunhapModel extends Model {
    protected $tblphieunhap ="phieunhap";
    protected $tbltaikhoan ="taikhoan";
    protected $tblsanpham ="sanpham";
    protected $tblchitietpn = "chitietphieunhap";
    protected $tbllohang = "lohang";
  
    public function Getlistpn(){
        $sql = "SELECT * FROM $this->tblphieunhap INNER JOIN $this->tbltaikhoan ON $this->tblphieunhap.username = $this->tbltaikhoan.username";
        $result=$this->con->query($sql);
        return $result;
    }

    public function getsp($tensp) {
        $sql = "SELECT MaSanPham, TenSanPham, DonGia FROM $this->tblsanpham WHERE TenSanPham LIKE '%$tensp%'";
        $result = $this->con->query($sql);
    
        $products = []; // Tạo mảng lưu kết quả
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row; // Thêm từng dòng vào mảng
            }
        }
        return $products; 
    }

    
    public function thempn($username, $TongTien) {
        try {
            // Chèn dữ liệu vào bảng `phieunhap`
            $sqlInsert = "INSERT INTO $this->tblphieunhap (username, NgayNhap, TongTien) VALUES (?, NOW(), ?)";
            $stmtInsert = $this->con->prepare($sqlInsert);
    
            if (!$stmtInsert) {
                throw new Exception("Lỗi chuẩn bị câu lệnh chèn: " . $this->con->error);
            }
    
            $stmtInsert->bind_param('si', $username, $TongTien);
    
            if (!$stmtInsert->execute()) {
                throw new Exception("Không thể chèn dữ liệu: " . $stmtInsert->error);
            }
    
            // Sử dụng SELECT để lấy MaPhieuNhap vừa được chèn
            $query = "SELECT MaPhieuNhap FROM $this->tblphieunhap ORDER BY NgayNhap DESC LIMIT 1;";
            $result = $this->con->query($query);
    
            if ($row = $result->fetch_assoc()) {
                $newId = $row['MaPhieuNhap'];
                echo "Mã phiếu nhập mới tạo: " . $newId;
                return $newId;
            } else {
                throw new Exception("Không tìm thấy dữ liệu vừa chèn!");
            }
    
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    
    

    public function themsp_phieunhap($MaPhieuNhap, $MaSanPham, $SoLuongNhap, $DonGia, $MaLoHang) {
        $sql = "INSERT INTO $this->tblchitietpn(MaPhieuNhap, MaSanPham, SoLuong, DonGia, MaLoHang) 
                VALUES ('$MaPhieuNhap', '$MaSanPham', $SoLuongNhap, $DonGia, '$MaLoHang')";
                echo $sql;
        $result = $this->con->query($sql);
        return $result;
    }

    public function themLohang($MaSanPham, $NgaySanXuat,$SoLuongNhap) {
        $sql = "INSERT INTO $this->tbllohang (MaSanPham, NgaySanXuat, SoLuongNhap) 
                VALUES ('$MaSanPham', '$NgaySanXuat',$SoLuongNhap)";
        $result = $this->con->query($sql);
        return $result;      
    }

    public function GetMalo($MaSanPham){
        $sql = "SELECT MaLoHang FROM $this->tbllohang
                      WHERE MaSanPham = '$MaSanPham' 
                      ORDER BY MaLoHang DESC LIMIT 1";
        $result = $this->con->query($sql);
        
    if ($result && $row = $result->fetch_assoc()) {
        return $row['MaLoHang']; // Trả về MaLoHang trực tiếp
    } else {
        return null;
    } 
    }

  

    

 public function tinhTongTien($MaPhieuNhap) {
    // Sửa câu lệnh SQL
    $sql = "SELECT SUM(ctpn.SoLuong * ctpn.DonGia) AS tongTien
            FROM $this->tblphieunhap AS pn
            INNER JOIN $this->tblchitietpn AS ctpn ON pn.MaPhieuNhap = ctpn.MaPhieuNhap
            WHERE pn.MaPhieuNhap = '$MaPhieuNhap'";

    // Thực hiện câu lệnh truy vấn
    $result = $this->con->query($sql);


    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $tongTien = $row['tongTien'];

            return $row['tongTien'];
                }
             else {
                return 0;
        }
    }
}
public function capnhatTongTien($MaPhieuNhap, $TongTien) {
    $sql = "UPDATE $this->tblphieunhap SET TongTien = $TongTien WHERE MaPhieuNhap = $MaPhieuNhap";
    return $this->con->query($sql);
}

public function Getctietpn(){
    $sql = "SELECT $this->tblchitietpn.*, 
       $this->tblphieunhap.*, 
       $this->tblsanpham.TenSanPham, 
       $this->tbllohang.NgaySanXuat
FROM $this->tblchitietpn
INNER JOIN $this->tblphieunhap ON $this->tblchitietpn.MaPhieuNhap = $this->tblphieunhap.MaPhieuNhap
INNER JOIN $this->tblsanpham ON $this->tblchitietpn.MaSanPham = $this->tblsanpham.MaSanPham
INNER JOIN $this->tbllohang ON $this->tblchitietpn.MaLoHang = $this->tbllohang.MaLoHang;";
   
    $result = $this->con->query($sql);
    return $result;
}

public function xoapn($MaPhieuNhap){
    $sql = "DELETE FROM $this->tblphieunhap WHERE MaPhieuNhap = '$MaPhieuNhap' ";
    $result = $this->con->query($sql);
    return $result;
}

public function xoa_ctpn($MaPhieuNhap){
    $sql = "DELETE FROM $this->tblchitietpn WHERE MaPhieuNhap = '$MaPhieuNhap'";
    $result = $this->con->query($sql);
    return $result;
}


    


}
?>