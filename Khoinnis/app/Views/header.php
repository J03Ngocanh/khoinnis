<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao Diện Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Nunito", sans-serif;
            
        }
        
        .toto {
            display: flex;
            min-height: 100vh;
            background-color: #f9f9f9;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 60px;
            position: fixed;
            top: 0;
            z-index: 1000;
            margin-bottom: 60px;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .sidebar {
            width: 250px;
            background-color:rgb(68, 184, 88);;
            color: #fff;
            padding-top: 80px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }

        .icon-menu{
            display:flex;
            gap: 20px;
        }
        
        .sidebar .menu {
            list-style: none;
          
        }
        
        .sidebar .menu a {
            display: block;
            padding: 20px 25px;
            font-size: 1rem;
            color: white;
            text-decoration: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .sidebar .menu a i {
            margin-right: 10px;
          
        }

        .sidebar .menu a:hover {
            background-color: rgb(194, 224, 204);
            color: rgb(5, 27, 11);
        }

        .sidebar .menu a.active {
            background-color:rgb(21, 100, 12);
            color: white;
        }

        .content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
            color: #333;
        }
       
.detail{
    margin-left: 300px;
    margin-top: 100px;
}

    </style>
</head>
<body>
<div class="to">
    <header class="header">
        <div class="logo">
            <a href="<?php echo WEBROOT; ?>tongquan/tongquan">
                <img style="width: 200px; height: auto;" src='<?php echo WEBROOT; ?>public/img/innis.png'>
            </a>
            
        </div>
        <div class="icon-menu">
               <?php if (isset($_SESSION['username'])): ?>  Xin chào,
          
               <span > <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></span>
               <p>|</p>
               <a style="font-size:15px; text-decoration:none; color:black" href="<?php echo WEBROOT; ?>taikhoan/logout" class="icon">Đăng xuất</a>
               
            
            <?php else: ?>
               
                <a style="padding-left:20px;" href="<?php echo WEBROOT; ?>taikhoan/login" class="icon"><i class="fas fa-user"></i></a>
    <?php endif; ?>
</div>
    </header>
</div>

<div class="sidebar">
    <aside class="sidebar">
    <ul class="menu">
           <a href="<?php echo WEBROOT . 'tongquan/tongquan' ?>"><li><i class="fas fa-house"></i>Tổng quan</li></a>
           <a href="<?php echo WEBROOT . 'chinhanh/chinhanh' ?>"><li><i class="fas fa-building"></i>Chi nhánh</li></a>
           <a href="<?php echo WEBROOT . 'sanpham/sanpham' ?>"><li><i class="fa-brands fa-product-hunt"></i>Sản phẩm</li></a>
           <a href="<?php echo WEBROOT . 'lohang/lohang' ?>"><li><i class="fa-solid fa-boxes-stacked"></i>Lô hàng</li></a>
           <a href="<?php echo WEBROOT . 'phieunhap/phieunhap' ?>"><li><i class="fas fa-clipboard-list"></i>Phiếu nhập</li></a>
           <a href="<?php echo WEBROOT . 'phieuxuat/phieuxuat' ?>"><li><i class="fas fa-clipboard-list"></i>Phiếu xuất</li></a>
</ul>

    </aside>
</div>

<script>
    // Chọn tất cả các thẻ <a> trong menu
    const menuItems = document.querySelectorAll('.sidebar .menu a');

    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Ngừng sự kiện mặc định (ví dụ: di chuyển trang)
          

            // Xóa class 'active' khỏi tất cả các mục
            menuItems.forEach(menu => menu.classList.remove('active'));
            
            // Thêm class 'active' vào mục được chọn
            this.classList.add('active');

            // Bạn có thể bật lại link nếu cần:
            // window.location.href = this.href; 
        });
    });
</script>

</body>
</html>
