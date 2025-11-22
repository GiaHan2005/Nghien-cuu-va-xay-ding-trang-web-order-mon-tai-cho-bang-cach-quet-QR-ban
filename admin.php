<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: admin.php');
    exit;
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>ADMIN QUẢN LÝ TIỆM TRÀ</title>
    <style>
        body {
            margin: 0;
            display: flex;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f7fa;
        }
        /* --- SIDEBAR --- */
        nav {
            width: 240px;
            background: #1e293b;
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }
        nav h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 18px;
        }
        nav a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.2s;
        }
        nav a:hover,
        nav a:focus {
            background: #475569;   
            color: #fff;
            transform: translateY(-1px);
        }

        iframe {
            flex: 1;
            border: none;
            height: 100vh;
            background: white;
        }

        .logout {
        position: fixed; 
        bottom: 20px;
        left: 5%  
        }

        .logout button {
        -webkit-appearance: none;
        appearance: none;
        display: block;
        width: 100%;
        background-color: #cbd5e1;    
        color: #1e293b;
        border: none;
        padding: 10px 14px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        text-align: left;     
        transition: transform .12s ease, box-shadow .12s ease, background .12s ease;
        }

        
        .logout button:hover {
        background: #b9cbe0ff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(15,23,42,0.06);
        }

        .ten-nv {
        color: #cfd8dc;
        font-size: 14px;
        text-align: left;
        margin-left: 15px;
        margin-top: 4px;
        margin-bottom: 15px;
        font-style: italic;
        }

    </style>
</head>
<body>
<nav>
    <?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    ?>
    <h2>TIỆM TRÀ</h2>

    <?php if (!empty($_SESSION['HoVaten'])): ?>
        <p class="ten-nv">Nhân viên: <?php echo htmlspecialchars($_SESSION['HoVaten'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php else: ?>
        <p class="ten-nv">Chưa có nhân viên đăng nhập</p>
    <?php endif; ?>

    <a href="trangchu.php" target="content-frame" class="active">Trang Chủ</a>
    <a href="quanlyban.php" target="content-frame">Danh Sách Bàn</a>
    <a href="thucdon.php" target="content-frame">Thực Đơn</a>
    <a href="qrban.php" target="content-frame">QR Bàn</a>
    <a href="adlogin.php" target="content-frame">Cài Đặt/Tài Khoản</a>
    <form class="logout" method="post" action="logout.php" target="_top" onsubmit="return confirm('Bạn chắc chắn muốn đăng xuất?');">
        <button type="submit">Đăng Xuất</button>
    </form>
</nav>

<iframe name="content-frame" src="trangchu.php"></iframe>
</body>
</html>
