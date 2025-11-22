<?php
session_start();
include("ketnoidb.php");

$err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === 'admin' && $password === '88888') {
        $_SESSION['is_admin'] = true;
        header("Location: tknhanvien.php");
        exit();
    } else {
        $err = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng nhập Admin</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(120deg, #a6c0fe, #f68084);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.login-box {
    background: white;
    padding: 40px 60px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    text-align: center;
}
.login-box h2 {
    color: #333;
    margin-bottom: 20px;
}
.login-box input {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.login-box button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}
.login-box button:hover {
    background-color: #218838;
}
.error {
    color: red;
    margin-top: 10px;
}
</style>
</head>
<body>
    <div class="login-box">
        <h2>ADMIN</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Tài khoản" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng nhập</button>
        </form>
        <?php if ($err): ?>
            <div class="error"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
