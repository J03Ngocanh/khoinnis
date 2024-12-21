<?php 
require_once './core/controller.php';
require_once 'app/models/mailer.php';

class taikhoanController extends Controller {
    private $taikhoanModel;
    public function __construct() {
        $this->taikhoanModel = $this->model('taikhoanModel');
    } 
    public function quenmatkhau() {
        
       $this->view('taikhoan/forgot_password');
    }
    public function login() {
        
        $this->view('taikhoan/login');
    }

    // Hàm xử lý khi người dùng ấn "Gửi mã xác nhận"
   public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
  // Kiểm tra email trong cơ sở dữ liệu
  $user = $this->taikhoanModel->checkemail($email);

  if ($user) {
      // Tạo mã xác nhận
      $verificationCode = rand(100000, 999999);
     
      // Lưu mã xác nhận vào cơ sở dữ liệu
      if ($this->taikhoanModel->saveVerificationCode($user['id_taikhoan'], $verificationCode)) {
  
          // Gửi mã xác nhận qua email (sử dụng PHPMailer hoặc thư viện khác)
          $mailer = new Mailer();
          if ($mailer->sendVerificationCode($email, $verificationCode)) {
              // Lưu email vào session để dùng ở bước xác nhận
              $_SESSION['email'] = $email;
              $_SESSION['message'] = "Mã xác nhận đã được gửi đến email của bạn.";
              $_SESSION['message_type'] = "success";
              $this->view('taikhoan/verify_code'); // Chuyển tới trang nhập mã xác nhận
              exit;
          }else {
            $_SESSION['message'] = "Không thể gửi email. Vui lòng thử lại.";
            $_SESSION['message_type'] = "error";
            $this->view('taikhoan/forgot_password'); // Quay lại form quên mật khẩu
            exit();
        }

    } 
                }
             else {
                $_SESSION['message'] = "Email không tồn tại trong hệ thống.";
                $_SESSION['message_type'] = "error";
                $this->view('taikhoan/forgot_password');
                exit();
            }
        }
    }
    
        
    
      // Hàm xử lý khi người dùng nhập mã xác nhận
      public function verifyCode() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificationCode = $_POST['verification_code'];
            $email = $_SESSION['email']; // Lấy email từ session

            // Kiểm tra email trong cơ sở dữ liệu
            $user = $this->taikhoanModel->checkemail($email);

            if ($user) {
                // Kiểm tra mã xác nhận
                if ($this->taikhoanModel->checkVerificationCode($user['id_taikhoan'], $verificationCode)) {
                    // Nếu mã xác nhận đúng, chuyển đến trang thay đổi mật khẩu
                    $_SESSION['message'] = "Mã xác nhận đúng. Bạn có thể thay đổi mật khẩu.";
                    $_SESSION['message_type'] = "success";
                    $this->view('taikhoan/reset_password');

                } else {
                    $_SESSION['message'] = "Mã xác nhận không chính xác.";
                    $_SESSION['message_type'] = "error";
                    $this->view('taikhoan/verify_code');
                }
            } else {
                $_SESSION['message'] = "Email không tồn tại trong hệ thống.";
                $_SESSION['message_type'] = "error";
                $this->view('taikhoan/verify_code');
            }
        }
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['email']; // Lấy email từ session
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword === $confirmPassword) {
                // Mã hóa mật khẩu mới (sử dụng password_hash để bảo mật)
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                // Cập nhật mật khẩu mới vào cơ sở dữ liệu
                $user = $this->taikhoanModel->updatePassword($email, $hashedPassword);

                if ($user) {
                    $_SESSION['message'] = "Mật khẩu đã được thay đổi thành công!";
                    $_SESSION['message_type'] = "success";
                    // Xóa session email khi xong
                    unset($_SESSION['email']);
                    // Redirect về trang đăng nhập hoặc trang nào đó
                    header("Location: /khoinnis/taikhoan/login");
                    exit;
                } else {
                    $_SESSION['message'] = "Có lỗi xảy ra. Vui lòng thử lại.";
                    $_SESSION['message_type'] = "error";
                    $this->view('taikhoan/reset_password');
                    exit;
                }
            } else {
                $_SESSION['message'] = "Mật khẩu và xác nhận mật khẩu không khớp.";
                $_SESSION['message_type'] = "error";
                $this->view('taikhoan/reset_password');
                exit;
            }
        }
    }
    



    public function xulydangnhap() {
        $username = $_POST['username'] ;
        $password = $_POST['password'] ;
        
        $check_tk = $this->taikhoanModel->checktk($username) ;
        if ($check_tk && $row = mysqli_fetch_assoc($check_tk)) { 
           
            if (password_verify($password, $row['password'])) {
                // Lưu họ tên vào Session
            //    $_SESSION['hoten'] = $row['hoten'];
                $_SESSION['username'] = $username;
                
                // Tùy chọn lưu thông tin đăng nhập (Remember Me)
                if (!empty($_POST['rememberMe'])) {
                    setcookie('login_username', $username, time() + (7 * 24 * 60 * 60), "/");
                    setcookie('login_password', $password, time() + (7 * 24 * 60 * 60), "/");
                }
                // if($row['role']==1){
                //     header('Location: /khoinnis/admin/listsp');
                //     exit();
                // }
              if(isset($_SESSION['loidangnhap'])){
                unset($_SESSION['loidangnhap']);
              }
               
              header('Location:/khoinnis/tongquan/');
                exit();
            } else {
                $_SESSION['loidangnhap'] = "Bạn đã nhập sai Password.";
                header('Location:/khoinnis/tongquan/');

            }
        } else {
            $_SESSION['loidangnhap'] = "Không tồn tại tài khoản.";
            header('Location:/khoinnis/tongquan/');

        }
    
    }
    
public function signup() {
   
    $this->view('taikhoan/signup');
 
}
public function xulydangky(){
    $username = $_POST['username'];
    $sdt = $_POST['sdt'];
    $password = $_POST['password'];
    $password_hash= password_hash($password,PASSWORD_DEFAULT);
    $email = $_POST['email'];
   

    $checkusername= $this->taikhoanModel->checkusername($username);
    $checksdt = $this->taikhoanModel->checksdt($sdt);
    $checkemail = $this->taikhoanModel->checkemail($email);
    
      $i=0 ;
       if(mysqli_num_rows($checkusername)>0){
          
            $_SESSION['trungusername'] = "Tên đăng nhập này đã tồn tại."; 
   $i=$i+1;
       }
       else{
        if(isset($_SESSION['trungusername'])){ unset($_SESSION['trungusername']);}
        $_SESSION['hienthiusername']=$username;
       }
      if (mysqli_num_rows($checkemail)>0) {
        session_start();
        $_SESSION['trungemail'] = "Email này đã tồn tại";
        $i = $i + 1; 
    } 
    
       else{
        if(isset($_SESSION['trungemail'])){ unset($_SESSION['trungemail']);}
        $_SESSION['hienthiemail']=$email;
       }

       if(mysqli_num_rows($checksdt) >0){
        session_start();
        $_SESSION['trungsdt'] = "SDT này đã tồn tại";
        $i = $i + 1; 
       }
       

       if($i == 0){
       $this->taikhoanModel->themtaikhoan($username, $password_hash, $sdt, $email);
        if(isset($_SESSION['trungusername'])){ unset($_SESSION['trungusername']);}
       if(isset($_SESSION['trungsdt'])){ unset($_SESSION['trungsdt']);}
       if(isset($_SESSION['trungemail'])){unset($_SESSION['trungemail']);}
       if(isset($_SESSION['hienthiemail'])){
        unset($_SESSION['hienthiemail']);
    }
    if(isset($_SESSION['hienthisdt'])){
        unset($_SESSION['hienthisdt']);
    }
    if(isset($_SESSION['hienthiusername'])){
        unset($_SESSION['hienthiusername']);
    }
   
    if(isset($_SESSION['hienthipass'])){
        unset($_SESSION['hienthipass']);
    }
    header('Location: /khoinnis/taikhoan/login'); 
    }
        else{
          $_SESSION['hienthiusername']=$username;
          $_SESSION['hienthipass']=$password;
          header('Location: /khoinnis/taikhoan/signup');
        } 
}
    public function logout() {
        if(isset($_SESSION['username'])){
            unset($_SESSION['username']);
           // unset($_SESSION['hoten']);
        header('Location: /khoinnis/tongquan/');
        exit();
        }
    }
}
?>

