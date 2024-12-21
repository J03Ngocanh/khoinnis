<?php

require_once 'core/Model.php';
#require_once 'category.php';
#require_once '../../core/Model.php';
class sanphamModel extends Model {
    protected $tblsanpham ="sanpham";
    protected $tbldvt = "dvt";
    public function Getlistsp(){
        $sql = "SELECT * FROM $this->tblsanpham INNER JOIN $this->tbldvt ON $this->tblsanpham.id_dvt = $this->tbldvt.id_dvt";
        $result=$this->con->query($sql);
        return $result;
    }

    public function Getttinsp($MaSanPham){
        $sql = "SELECT * FROM $this->tblsanpham INNER JOIN $this->tbldvt ON $this->tblsanpham.id_dvt = $this->tbldvt.id_dvt  WHERE MaSanPham = '$MaSanPham'";
        $result=$this->con->query($sql);
        return $result;
    }

    Public function Getdvt(){
        $sql = "SELECT * FROM  $this->tbldvt";
        $result=$this->con->query($sql);
        return $result;
    }

    public function SuaSP($MaSanPham, $TenSanPham, $DungTich, $id_dvt, $HinhAnh, $DonGia, $HanSuDung){
        $sql = "UPDATE $this->tblsanpham SET TenSanPham = '$TenSanPham', DungTich= '$DungTich', id_dvt = $id_dvt, HinhAnh='$HinhAnh',DonGia= $DonGia HanSuDung = '$HanSuDung' WHERE  MaSanPham = '$MaSanPham'";
        $result=$this->con->query($sql);
        return $result;
    }

 

    public function XoaSP($MaSanPham){
        $sql = "DELETE FROM $this->tblsanpham WHERE MaSanPham='$MaSanPham'";
        $result=$this->con->query($sql);
        return $result;
    }

    public function ThemSP($TenSanPham, $DungTich, $id_dvt, $HinhAnh,$DonGia,$HanSuDung){
        $sql = "INSERT INTO $this->tblsanpham(TenSanPham, DungTich, id_dvt, HinhAnh,DonGia,HanSuDung) VALUES ('$TenSanPham', '$DungTich', '$id_dvt', '$HinhAnh','$DonGia','$HanSuDung')";
        echo $sql;
        $result=$this->con->query($sql);
        return $result;
    
    }
 

}
?>