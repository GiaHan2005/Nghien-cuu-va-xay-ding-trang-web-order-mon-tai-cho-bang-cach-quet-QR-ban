<?php
session_start();
include("ketnoidb.php");

$invalid=false;
if ($_SERVER['REQUEST_METHOD']== 'POST'){
    $db = new KETNOI();

    $Username = trim($_POST['username'] ?? '');
    $Matkhau = $_POST['password'] ?? '';

    $nv = $db->check_login($Username, $Matkhau);

    if ($nv !== false && is_array($nv)) {
        $_SESSION['HoVaten'] = $nv['HoVaten'];
        $_SESSION['Username'] = $nv['Username'];
        $_SESSION['idNV'] = $nv['idNV'];

        header('Location: admin.php');
        exit();
    } else {
        $invalid = true;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập Nhân Viên</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
</head>
<body>

    <div id="wrapper">
        <form action="login.php" id="form-login" method ="post">
            <h1 class="form-heading">Đăng Nhập</h1>
            <div class="form-group">
                <i class="far fa-user"></i>
                <input type="text" class="form-input"placeholder="Tên đăng nhập" name="username" required>
            </div>
                <div class="form-group">
                <i class="fas fa-key"></i>
                <input type="password" class="form-input"placeholder="Mật khẩu" name="password" required>
                 <div id="mat">
                     <i class="far fa-eye"></i>
                 </div>
            </div>
            <?php if (isset($invalid) && $invalid): ?>
                <div style="color:red">Đăng nhập sai!!!</div>
            <?php endif; ?>
            <input type="submit" value="Bắt đầu làm việc" class="form-submit">
            <a href = "signup.php">Quên mật khẩu?</a>
        </form>
    </div>

</body>
</html>