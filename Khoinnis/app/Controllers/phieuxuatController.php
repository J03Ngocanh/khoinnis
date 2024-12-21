<?php 
require_once './core/controller.php';
require_once 'app/models/mailer.php';

class phieuxuatController extends Controller {
    private $phieuxuatModel;
    public function __construct() {
        $this->phieuxuatModel = $this->model('phieuxuatModel');
    } 
    public function phieuxuat() {
        $chinhanh = $this->phieuxuatModel->Getchinhanh();
        $phieuxuat = $this->phieuxuatModel->Getlistpx();
       // $chitiet = $this->phieuxuatModel->Getctietpx();     
     //  $this->view('header');
        $this->view('phieuxuat/phieuxuat', ['phieuxuat' => $phieuxuat, 'chinhanh' => $chinhanh]);
    } 

    public function them(){
        $chinhanh = $this->phieuxuatModel->Getchinhanh();
      // $this->view('header');
        $this->view('phieuxuat/thempx', ['chinhanh' => $chinhanh]);
    }

    public function timkiem() {
        if (isset($_POST['nd'])) {
            $tensp = $_POST['nd'];

            // Gọi Model để tìm kiếm sản phẩm
            
            $products = $this->phieuxuatModel->getsp($tensp);

                 // Kiểm tra kết quả trả về từ model
      
        // Nếu không có sản phẩm, trả về một mảng rỗng
        if (empty($products)) {
            echo json_encode([]);  // Trả về mảng rỗng nếu không tìm thấy sản phẩm
        } else {
            // Trả về JSON hợp lệ
            echo json_encode($products);
        }
        }
    }
    
    

    public function taophieuxuat(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $MaChiNhanh = $_POST['MaChiNhanh'];
           
            $sanpham_raw = urldecode($_POST['sanpham']);
            $sanpham = json_decode($sanpham_raw, true);
            $result = $this->phieuxuatModel->thempx($username, $MaChiNhanh);
            if (!$result) {
                echo "Không thể thêm phiếu nhập!";
                return;
            }
        }
    }
}
?>