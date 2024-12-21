<?php 
require_once './core/controller.php';
require_once 'app/models/mailer.php';

class phieunhapController extends Controller {
    private $phieunhapModel;
    public function __construct() {
        $this->phieunhapModel = $this->model('phieunhapModel');
    } 
    public function phieunhap() {
        $phieunhap = $this->phieunhapModel->Getlistpn();
        $chitiet = $this->phieunhapModel->Getctietpn();     
        $this->view('header');
        $this->view('phieunhap/phieunhap', ['phieunhap' => $phieunhap, 'chitiet' =>  $chitiet ]);
    } 
    public function them(){
        $this->view('header');
        $this->view('phieunhap/thempn');
    }

    public function timkiem(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nd'])) {
            $tensp = $_POST['nd'];
            $result = $this->phieunhapModel->getsp($tensp);
    
            if ($result) {
                foreach ($result as $row) {
                    echo '<div data-id="' . $row['MaSanPham'] . '" 
                                data-name="' . htmlspecialchars($row['TenSanPham']) . '" 
                                data-price="' . number_format($row['DonGia'], 0, ',', '.') . '" 
                                data-total="' . number_format($row['DonGia'], 0, ',', '.') . ' đ">
                            ' . htmlspecialchars($row['TenSanPham']) . '
                          </div>';
                }
            }
            
            
            else {
                echo "<div>Không tìm thấy sản phẩm</div>";
            }
        } else {
            echo "<div>Dữ liệu không hợp lệ</div>";
        }
    }

    public function taophieunhap() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
            $username = $_POST['username'];
            $sanpham_raw = urldecode($_POST['sanpham']);
            $sanpham = json_decode($sanpham_raw, true);
            $TongTien = 0;
            foreach ($sanpham as $product) {
                $TongTien += $product['SoLuong'] * $product['DonGia'];
            }
    
            // Tạo phiếu nhập mới vào bảng phieunhap
            $result = $this->phieunhapModel->thempn($username, $TongTien);
    
            if (!$result) {
                echo "Không thể thêm phiếu nhập!";
                return;
            }
            
            $MaPhieuNhap = $result;
    
            // Lấy dữ liệu từ mảng sản phẩm và thêm vào bảng `lohang`
            foreach ($sanpham as $product) {
                $MaSanPham = $product['MaSanPham'];
                $DonGia = $product['DonGia'];
                $SoLuongNhap = $product['SoLuong'];
                $NgaySanXuat = $product['NgaySanXuat'];

               
              $sqlInsertLoHang = $this->phieunhapModel->themLohang($MaSanPham, $NgaySanXuat, $SoLuongNhap);
             $MaLoHang = $this->phieunhapModel->GetMalo($MaSanPham);
             
    
                if ($sqlInsertLoHang === TRUE) {
                    echo "Sản phẩm $MaSanPham đã được thêm vào bảng lohang! ";
                } else {
                    echo "Lỗi khi thêm sản phẩm $MaSanPham vào lohang: " ;
                }
    
                // Thêm chi tiết phiếu nhập vào bảng `chitietphieunhap`
             $sqlInsertChiTiet = $this->phieunhapModel->themsp_phieunhap($MaPhieuNhap, $MaSanPham, $SoLuongNhap, $DonGia, $MaLoHang);
         
              header('Location: /Khoinnis/phieunhap/phieunhap');
            }
        }
    }

    public function xoa($MaPhieuNhap){
        $this->phieunhapModel->xoa_ctpn($MaPhieuNhap);

        $this->phieunhapModel->xoapn($MaPhieuNhap);
        header("location: /Khoinnis/phieunhap/phieunhap");      
          exit();
    }

   
}
?>
