<?php 
require_once './core/controller.php';
require_once 'app/models/mailer.php';

class sanphamController extends Controller {
    private $sanphamModel;
    public function __construct() {
        $this->sanphamModel = $this->model('sanphamModel');
    } 
    public function sanpham() {
        $sanpham = $this->sanphamModel->Getlistsp();
        $this->view('header');
        $this->view('sanpham/sanpham', ['sanpham' => $sanpham]);
    }

    public function sua($MaSanPham){
        $donvitinh = $this->sanphamModel->Getdvt();
        $sanpham = $this->sanphamModel->Getttinsp($MaSanPham);
        $this->view('header');
        $this->view('sanpham/suasp', ['sanpham' => $sanpham, 'donvitinh' => $donvitinh]);
    }

    public function them(){
        $donvitinh = $this->sanphamModel->Getdvt();
       $this->view('header');
        $this->view('sanpham/themsp', ['donvitinh' => $donvitinh]);
    }

    public function xulythem(){
        
        $TenSanPham = $_POST['TenSanPham'];
        $DungTich = $_POST['DungTich'];
        $id_dvt = $_POST['id_dvt'];
        $DonGia = $_POST['DonGia'];
        $HanSuDung = $_POST['HanSuDung'];
        $HinhAnh = '';
        if(isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['name'] != ''){
            $HinhAnh = $_FILES['HinhAnh']['name'];
            $file_tmp =$_FILES['HinhAnh']['tmp_name'];  
            move_uploaded_file($file_tmp,"public/img/".$HinhAnh);
         }
      
        
        $this->sanphamModel->ThemSP($TenSanPham, $DungTich, $id_dvt, $HinhAnh,$DonGia,$HanSuDung);
        $_SESSION['thanhcong']="Bạn đã thêm thành công sản phẩm tên: $TenSanPham ";
        header('Location: /Khoinnis/sanpham/sanpham');
        
    }
    public function xulysua(){
        $MaSanPham = $_POST['MaSanPham'];
        $TenSanPham = $_POST['TenSanPham'];
        $DungTich = $_POST['DungTich'];
        $id_dvt = $_POST['id_dvt'];
        $DonGia = $_POST['DonGia'];
        $HanSuDung = $_POST['HanSuDung'];
        $result=$this->sanphamModel->Getttinsp($MaSanPham);
        $row= mysqli_fetch_array($result);
        $hinh_anh = $row['HinhAnh'];
        if(isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['name'] != ''){
            $HinhAnh = $_FILES['HinhAnh']['name'];
            $file_tmp =$_FILES['HinhAnh']['tmp_name'];  
            move_uploaded_file($file_tmp,"public/img/".$HinhAnh);
         }

         $this->sanphamModel->SuaSP($MaSanPham, $TenSanPham, $DungTich, $id_dvt, $HinhAnh, $DonGia, $HanSuDung);

        $_SESSION['thanhcong']="Bạn đã sửa thành công sản phẩm mã: $MaSanPham , tên: $TenSanPham ";
        header('Location: /Khoinnis/sanpham/sanpham');
    }

    public function xoa($MaSanPham) {
        $this->sanphamModel->xoaSP($MaSanPham);
        $_SESSION['thanhcong1']="Bạn đã xóa thành công sản phẩm mã: $MaSanPham  ";
        header("location: /Khoinnis/sanpham/sanpham");

    }
}