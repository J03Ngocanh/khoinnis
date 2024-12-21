<?php 
require_once './core/controller.php';
require_once 'app/models/mailer.php';

class lohangController extends Controller {
    private $lohangModel;
    public function __construct() {
        $this->lohangModel = $this->model('lohangModel');
    } 
    public function lohang() {
        $lohang = $this->lohangModel->Getlistlh();
        $this->view('header');
        $this->view('lohang/lohang', ['lohang' => $lohang]);
    }
}
?>