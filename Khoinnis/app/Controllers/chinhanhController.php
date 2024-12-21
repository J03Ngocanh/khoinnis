<?php 
require_once './core/controller.php';
require_once 'app/models/mailer.php';

class chinhanhController extends Controller {
    private $chinhanhModel;
    public function __construct() {
        $this->chinhanhModel = $this->model('chinhanhModel');
    } 
    public function chinhanh() {
        $chinhanh = $this->chinhanhModel->Getlistcn();
        $this->view('header');
        $this->view('chinhanh/chinhanh', ['chinhanh' => $chinhanh]);
    }

    public function sua($MaChiNhanh){
        $chinhanh = $this->chinhanhModel->Getttincn($MaChiNhanh);
        $this->view('header');
        $this->view('chinhanh/suacn', ['chinhanh' => $chinhanh]);
    }

    public function them(){
        $this->view('header');
        $this->view('chinhanh/themcn');
    }

    public function xulythem(){
        $TenChiNhanh = $_POST['TenChiNhanh'];
        //echo $TenChiNhanh;
        $DiaChi = $_POST['DiaChi'];
        $SoDienThoai = $_POST['SoDienThoai'];
       
        $Email = $_POST['Email'];
        $this->chinhanhModel->ThemCN($TenChiNhanh, $DiaChi, $SoDienThoai, $Email);
        header('Location: /Khoinnis/chinhanh/chinhanh');

    }
    public function xulysua(){
        $MaChiNhanh = $_POST['MaChiNhanh'];
        $TenChiNhanh = $_POST['TenChiNhanh'];
        $Email = $_POST['Email'];
        $DiaChi = $_POST['DiaChi'];
        $SoDienThoai = $_POST['SoDienThoai'];
        $this->chinhanhModel->SuaCN($MaChiNhanh, $TenChiNhanh, $DiaChi, $SoDienThoai, $Email);
        header('Location: /Khoinnis/chinhanh/chinhanh');
    }

    public function xoa($MaChiNhanh) {
        $this->chinhanhModel->xoaCN($MaChiNhanh);
        $_SESSION['thanhcong']="Bạn đã xóa thành công sản phẩm mã: $MaChiNhanh  ";
        header("location: /Khoinnis/chinhanh/chinhanh");

    }
}