<?php

require_once 'core/Model.php';
#require_once 'category.php';
#require_once '../../core/Model.php';
class taikhoanModel extends Model {
    protected $tbltaikhoan ="taikhoan";
    protected $table2 = 'loaisp';
    public function checktk($username) {
        $sql = "SELECT * FROM $this->tbltaikhoan WHERE username= '$username'  ";
        $result=$this->con->query($sql);
        return $result;
    }
    public function checkusername($username){
        $sql = "SELECT * FROM $this->tbltaikhoan WHERE username= '$username' ";
        $result=$this->con->query($sql);
        return $result;

    } 
    public function checkpass($password){
        $sql = "SELECT * FROM $this->tbltaikhoan WHERE password='$password' ";
        $result=$this->con->query($sql);
        return $result;

    } 
    public function checksdt($sdt){
        $sql = "SELECT * FROM $this->tbltaikhoan WHERE sdt='$sdt' ";
        $result=$this->con->query($sql);
        return $result;

    } 
    public function checkemail($email){
        $sql = "SELECT * FROM $this->tbltaikhoan WHERE email='$email' ";
        $result=$this->con->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    } 

    public function themtaikhoan($username, $password, $sdt, $email){
        $sql = "INSERT INTO $this->tbltaikhoan(username,password,sdt,email) VALUES ('$username','$password',  '$sdt', '$email')";
        $result=$this->con->query($sql);
        return $result;

    }
    public function updatePassword($email, $newPassword) {
        $sql = "UPDATE $this->tbltaikhoan SET password = '$newPassword' WHERE email = '$email'";
        $result=$this->con->query($sql);
        return $result;
    }
    public function saveVerificationCode($userId, $verificationCode) {
        $sql = "UPDATE $this->tbltaikhoan SET verification_code = '$verificationCode' WHERE id_taikhoan = $userId";
        return $this->con->query($sql);

    }
    
    public function checkVerificationCode($userId, $verificationCode) {
        $sql = "SELECT * FROM $this->tbltaikhoan WHERE id_taikhoan = $userId AND verification_code = '$verificationCode'";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
}
    ?>