<?php 
require_once './core/controller.php';
require_once 'app/models/lohangModel.php';

class lohangController extends Controller {
    private $lohangModel;

    public function __construct() {
        $this->lohangModel = $this->model('lohangModel');
    }

    public function lohang() {
        $lohang = $this->lohangModel->Getlistlh();
        $sanpham = $this->lohangModel->gethsd();
        $result = $this->lohangModel->Get_lohang_hsd();
    
        $today = time();
    
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $MaSanPham = $row['MaSanPham'];
            $HSDStr = $sanpham[$MaSanPham] ?? null;
    
            if ($HSDStr) {
                // Chỉ lấy các con số từ chuỗi (bỏ từ 'năm' nếu có)
                $HSDStr = filter_var($HSDStr, FILTER_SANITIZE_NUMBER_INT);
    
                if ($HSDStr > 0) {
                    try {
                        $date = new DateTime($row['NgaySanXuat']);
                        $date->add(new DateInterval("P{$HSDStr}Y"));
                        $HanHetHSD = $date->format('Y-m-d');
    
                        $expiredClass = (strtotime($HanHetHSD) - time() <= 365 * 24 * 60 * 60) ? 'expired' : '';
    
                        $row['HanHetHSD'] = $HanHetHSD;
                        $row['expiredClass'] = $expiredClass;
    
                        $data[] = $row;
                    } catch (Exception $e) {
                        echo "<br>Lỗi ngày sản xuất: " . $e->getMessage();
                    }
                }
            }
        }
    
       $this->view('header');
        $this->view('lohang/lohang', ['lohang' => $data]);
    }
    
    
    
}
?>
