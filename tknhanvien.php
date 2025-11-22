<?php
session_start();
include ('ketnoidb.php');
if (empty($_SESSION['is_admin'])) {
    header("Location: tknhanvien.php");
    exit();
}
$db = new KETNOI();

if (isset($_POST['btnXoa']) && !empty($_POST['xoa'])) {
    $dem = 0;
    foreach ($_POST['xoa'] as $id) {
        if ($db->xoaNhanVien($id)) {
            $dem++;
        }
    }
    echo "<script> alert('Đã xóa {$dem} nhân viên thành công!'); window.location='tknhanvien.php';</script>";
}
$result = $db->LayDanhSachNV();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách nhân viên</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 40px;
        background: #f6f8fc;
    }
    .container {
        width: 85%;
        margin: auto;
    }
    h1 {
        text-align: center;
        color: #33548aff;
        margin-bottom: 20px;
    }
    .action-buttons {
        text-align: right;
        margin-bottom: 10px;
    }
    .action-buttons button {
        background-color: #33548aff;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        margin-left: 5px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .action-buttons button:hover {
        background-color: #0056b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    th {
        background: #33548aff;
        color: white;
        text-align: left;
        padding: 10px;
    }
    td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    tr:hover { background: #f2f8ff; }
    
    .action-buttons a {
    border: none;
    border-radius: 6px;
    padding: 9px 15px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    color: #fff;
    background-color: #bcbdc1ff; 
    transition: all 0.25s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    text-decoration: none;
    }

    .action-buttons a:hover {
        background-color: #9c9da0ff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    tr a{
        border: none;
        border-radius: 6px;
        padding: 5px 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        color: #fff;
        background-color: #bcbdc1ff; 
        transition: all 0.25s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        text-decoration: none;
    }
    tr a:hover {
        background-color: #9c9da0ff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
</style>
</head>
<body>

<div class="container">
    <h1>Danh sách nhân viên</h1>

    <form method="post">
        <div class="action-buttons">
            <a href="themnv.php">+ Đăng ký tài khoản</a>
            <button type="submit" name="btnXoa"
                onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên đã chọn không?')">XÓA</button>
        </div>

        <table>
                <tr>
                    <th>Chọn</th>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Chức vụ</th>
                    <th>Hình thức</th>
                    <th>Số điện thoại</th>
                    <th></th>
                </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><input type="checkbox" name="xoa[]" value="<?php echo $row['idNV']; ?>"></td>
                <td><?php echo $row['idNV']; ?></td>
                <td><?php echo $row['HoVaten']; ?></td>
                <td><?php echo $row['ChucVu']; ?></td>
                <td><?php echo $row['HinhThuc']; ?></td>
                <td><?php echo $row['SoDienThoai']; ?></td>
                <td>                
                    <a href="suanv.php?id=<?php echo $row['idNV']; ?>">SỬA</a>
            </tr>
            <?php endwhile; ?>
        </table>
    </form>
</div>

</body>
</html>
