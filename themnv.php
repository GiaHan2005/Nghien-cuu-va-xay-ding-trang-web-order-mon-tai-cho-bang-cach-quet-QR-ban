<?php
session_start();
include("ketnoidb.php"); 

$db = new KETNOI(); 
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $HoVaten = $_POST['HoVaten'];
    $Username = $_POST['Username'];
    $ChucVu = $_POST['ChucVu'];
    $HinhThuc = $_POST['HinhThuc'];
    $SoDienThoai = $_POST['SoDienThoai'];
    $MatKhau = $_POST['MatKhau'];

    if ($db->themNhanVien($HoVaten, $Username, $ChucVu, $HinhThuc, $SoDienThoai, $MatKhau)) {
        $msg = "Thêm nhân viên thành công!";
    } else {
        $msg = "Lỗi khi thêm nhân viên.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm nhân viên mới</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    background: white;
    padding: 40px 60px;
    border-radius: 14px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    width: 400px;
}
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 25px;
}
input, select {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 15px;
}
button {
    width: 100%;
    background-color: #33548aff;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
    margin-top: 8px;
}
button:hover {
    background-color: #33548aff;
}
.message {
    text-align: center;
    margin-top: 15px;
    font-weight: bold;
}
.back {
    text-align: center;
    margin-top: 15px;
}
.back a {
    color: #007bff;
    text-decoration: none;
}
.back a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
    <div class="container">
        <h2>Thêm nhân viên mới</h2>
        <form method="POST">
            <input type="text" name="HoVaten" placeholder="Họ và tên" required>
            <input type="text" name="Username" placeholder="Tên đăng nhập" required>
            
            <select name="ChucVu" required>
                <option value="">-- Chọn vị trí --</option>
                <option value="Thu ngân">Thu ngân</option>
                <option value="Phục vụ">Phục vụ</option>
            </select>

            <select name="HinhThuc" required>
                <option value="">-- Chọn hình thức làm việc --</option>
                <option value="FULLTIME">FULLTIME</option>
                <option value="PARTTIME">PARTTIME</option>
            </select>

            <input type="text" name="SoDienThoai" placeholder="Số điện thoại" required>
            <input type="password" name="MatKhau" placeholder="Mật khẩu" required>

            <button type="submit">THÊM</button>
        </form>

        <div class="message"><?= htmlspecialchars($msg) ?></div>

        <div class="back">
            <a href="tknhanvien.php">← Quay lại</a>
        </div>
    </div>
</body>
</html>
