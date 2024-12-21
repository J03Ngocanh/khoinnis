<?php

require_once 'core/Model.php';
#require_once 'category.php';
#require_once '../../core/Model.php';
class lohangModel extends Model {
    protected $tbllohang ="lohang";
    protected $tblsanpham ="sanpham";
    // public function Getlistlh(){
    //     $sql = "SELECT * FROM $this->tbllohang";
    //     $result=$this->con->query($sql);
    //     return $result;
    // }
    public function Getlistlh() {
        // Lấy danh sách lô hàng kết hợp tính ngày hết hạn từ bảng sản phẩm
        $query = "
            SELECT 
                l.MaLoHang, 
                l.MaSanPham, 
                l.NgaySanXuat, 
                l.SoLuongNhap, 
                l.SoLuongTon,
                p.HanSuDung,
                DATE_ADD(STR_TO_DATE(l.NgaySanXuat, '%Y-%m-%d'), 
             INTERVAL CAST(SUBSTRING(p.HanSuDung, 1, LOCATE(' ', p.HanSuDung) - 1) AS UNSIGNED) YEAR) AS HanHetHSD
            FROM 
                $this->tbllohang AS l
            JOIN 
               $this->tblsanpham AS p ON l.MaSanPham = p.MaSanPham
        ";

        return $this->con->query($query);
    }


    public function Get_lohang_hsd(){
        $sql = "SELECT 
        MaLoHang, 
        MaSanPham, 
        NgaySanXuat, 
        SoLuongNhap, 
        SoLuongTon

    FROM 
        $this->tbllohang ";
   


        $result=$this->con->query($sql);
        return $result;
    }

    public function gethsd() {
        $sql = "SELECT MaSanPham, HanSuDung FROM $this->tblsanpham";
        $result = $this->con->query($sql);
    
        $hsdData = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $hsdData[$row['MaSanPham']] = $row['HanSuDung'];
            }
        }
        return $hsdData;
    }
}
    ?>