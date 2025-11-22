<?php
session_start();
include ('ketnoidb.php'); 

$db = new KETNOI();
$nhanvien = null;
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idNV = $_POST['idNV'];
    $hoTen = $_POST['hoTen'];
    $chucVu = $_POST['chucVu'];
    $hinhThuc = $_POST['hinhThuc'];
    $sdt = $_POST['sdt'];
    $username = $_POST['username'];
    $matKhau = $_POST['matKhau'];

    $success = $db->suaNhanVien($idNV, $hoTen, $username, $chucVu, $hinhThuc, $sdt, $matKhau);

    if ($success) {
        header("Location: tknhanvien.php");
        exit();
    } else {
        $message = "Cập nhật thông tin thất bại! Vui lòng thử lại.";
    }
}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idNV = $_GET['id'];

    $nhanvien = $db->layMotNhanVien($idNV);

    if (!$nhanvien) {
        header("Location: tknhanvien.php");
        exit();
    }
} else {
    header("Location: tknhanvien.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cập nhật nhân viên</title>
<style>
    body {
        font-family: Arial, sans-serif; margin: 40px; background: #f6f8fc;
        display: flex; justify-content: center; align-items: center;
    }
    .container {
        width: 500px; margin: auto; padding: 30px; background: #fff;
        border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    h1 { text-align: center; color: #33548aff; margin-bottom: 25px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { 
        display: block; margin-bottom: 5px; font-weight: 600; color: #333; 
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box; 
    }
    .action-buttons { text-align: right; margin-top: 20px; }
    .action-buttons button, .action-buttons a {
        background-color: #33548aff; color: white; border: none;
        padding: 10px 18px; border-radius: 5px; cursor: pointer;
        text-decoration: none; font-size: 14px; transition: background 0.2s;
        margin-left: 10px;
    }
    .action-buttons a { background-color: #777; }
    .action-buttons button:hover { background-color: #0056b3; }
    .action-buttons a:hover { background-color: #555; }
    .message { color: red; text-align: center; margin-bottom: 15px; }
</style>
</head>
<body>

<div class="container">
    <h1>Cập nhật thông tin nhân viên</h1>
    
    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="suanv.php" method="POST">
    
        <input type="hidden" name="idNV" value="<?php echo htmlspecialchars($nhanvien['idNV']); ?>">

        <div class="form-group">
            <label for="hoTen">Họ và tên:</label>
            <input type="text" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($nhanvien['HoVaten']); ?>" required>
        </div>

        <div class="form-group">
            <label for="username">Username (Tên đăng nhập):</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($nhanvien['Username']); ?>" required>
        </div>

        <div class="form-group">
            <label for="chucVu">Chức vụ:</label>
            <select id="chucVu" name="chucVu">
                <option value="Thu ngân" <?php if($nhanvien['ChucVu'] == 'Thu ngân') echo 'selected'; ?>>
                    Thu ngân
                </option>
                <option value="Phục vụ" <?php if($nhanvien['ChucVu'] == 'Phục vụ') echo 'selected'; ?>>
                    Phục vụ
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="hinhThuc">Hình thức:</label>
            <select id="hinhThuc" name="hinhThuc">
                <option value="PARTTIME" <?php if($nhanvien['HinhThuc'] == 'PARTTIME') echo 'selected'; ?>>
                    PARTTIME
                </option>
                <option value="FULLTIME" <?php if($nhanvien['HinhThuc'] == 'FULLTIME') echo 'selected'; ?>>
                    FULLTIME
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="sdt">Số điện thoại:</label>
            <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($nhanvien['SoDienThoai']); ?>">
        </div>

        <div class="form-group">
            <label for="matKhau">Mật khẩu mới:</label>
            <input type="password" id="matKhau" name="matKhau" placeholder="Nhập mật khẩu mới">
        </div>

        <div class="action-buttons">
            <a href="tknhanvien.php">Hủy</a>
            <button type="submit">Cập nhật</button>
        </div>
    </form>
</div>

</body>
</html>