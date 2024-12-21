<?php

require_once 'core/Model.php';
#require_once 'category.php';
#require_once '../../core/Model.php';
class chinhanhModel extends Model {
    protected $tblchinhanh ="chinhanh";
    public function Getlistcn(){
        $sql = "SELECT * FROM $this->tblchinhanh";
        $result=$this->con->query($sql);
        return $result;
    }

    public function Getttincn($MaChiNhanh){
        $sql = "SELECT * FROM $this->tblchinhanh WHERE MaChiNhanh = '$MaChiNhanh'";
        $result=$this->con->query($sql);
        return $result;
    }
    public function SuaCN($MaChiNhanh, $TenChiNhanh, $DiaChi, $SoDienThoai, $Email){
        $sql = "UPDATE $this->tblchinhanh SET TenChiNhanh = '$TenChiNhanh', DiaChi = '$DiaChi', SoDienThoai = '$SoDienThoai', Email='$Email' WHERE  MaChiNhanh = '$MaChiNhanh'";
        $result=$this->con->query($sql);
        return $result;
    }

    public function XoaCN($MaChiNhanh){
        $sql = "DELETE FROM $this->tblchinhanh WHERE MaChiNhanh='$MaChiNhanh'";
        $result=$this->con->query($sql);
        return $result;
    }

    public function ThemCN($TenChiNhanh, $DiaChi, $SoDienThoai, $Email){
        $sql = "INSERT INTO $this->tblchinhanh(TenChiNhanh, DiaChi, SoDienThoai, Email) VALUES ('$TenChiNhanh', '$DiaChi', '$SoDienThoai', '$Email')";
        $result=$this->con->query($sql);
        return $result;
    
    }
 

}
?>