<?php 
require_once './core/controller.php';
class tongquanController extends Controller {
    private $taikhoanModel;
    public function __construct() {
        $this->taikhoanModel = $this->model('taikhoanModel');
    } 
    public function tongquan() { 
        $this->view('header');
       $this->view('tongquan/tongquan');
    }

}
?>