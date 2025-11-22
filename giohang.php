<?php
session_start();
require_once "Ketnoidb.php";
$tt = new KETNOI();

$idBan = $_SESSION['idBan'] ?? 0;
if ($idBan <= 0) {
    die("<h3>Không xác định được bàn! Vui lòng quét mã QR lại.</h3>");
}

if (!isset($_SESSION['order'])) $_SESSION['order'] = [];

if (isset($_POST['chonmon']) && isset($_POST['idMon'])) {
    $idMon = intval($_POST['idMon']);
    $mon = $tt->getMonById($idMon); 

    if ($mon) {
        $found = false;
        foreach ($_SESSION['order'] as &$item) {
            if ($item['idMon'] == $idMon) {
                $item['SoLuong'] += 1;
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $_SESSION['order'][] = [
                'idMon' => $mon['idMon'],
                'TenMon' => $mon['TenMon'],
                'Size' => $mon['Size'],
                'Gia' => $mon['Gia'],
                'SoLuong' => 1,
                'GhiChu' => ''
            ];
        }
    }
}

if (isset($_POST['update_notes']) && isset($_POST['ghichu'])) {
    foreach ($_SESSION['order'] as &$mon) {
        $id = $mon['idMon'];
        if (isset($_POST['ghichu'][$id])) {
            $mon['GhiChu'] = trim($_POST['ghichu'][$id]);
        }
    }
    unset($mon);
}

if (isset($_POST['delete_selected']) && !empty($_POST['chonxoa'])) {
    $chonxoa = $_POST['chonxoa'];
    $_SESSION['order'] = array_filter($_SESSION['order'], function ($mon) use ($chonxoa) {
        return !in_array($mon['idMon'], $chonxoa);
    });
    $_SESSION['order'] = array_values($_SESSION['order']);
}

if (isset($_POST['submit_order'])) {
    if (!empty($_SESSION['order'])) {
        $tong = 0;
        foreach ($_SESSION['order'] as $i) {
            $tong += $i['Gia'] * $i['SoLuong'];
        }

        $ghiChu = "Khách bàn $idBan gọi món";
        $idDonHang = $tt->createDonHang($idBan, $tong, $ghiChu); 

        $idNV = $_SESSION['idNV'] ?? null;

        foreach ($_SESSION['order'] as $m) {
            $dongia = $m['Gia'];
            $thanhTien = $m['Gia'] * $m['SoLuong'];
            $tt->addChiTietDon($idDonHang, $m['idMon'], $idNV, $m['SoLuong'], $dongia, $thanhTien, $m['GhiChu']); 
        }

        $tt->updateTrangThaiBan($idBan, 1); 

        if (!isset($_SESSION['last_order'])) {
            $_SESSION['last_order'] = [];
        }
        $_SESSION['last_order'][] = $_SESSION['order'];

        $_SESSION['order'] = [];

        echo "<h3 style='color:green;text-align:center;'>Đặt đơn thành công cho bàn $idBan!</h3>";
        echo "<meta http-equiv='refresh' content='2;url=DonHang.php'>";
        exit;
    }
}

$tong = 0;
foreach ($_SESSION['order'] as $i) {
    $tong += $i['Gia'] * $i['SoLuong'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Giỏ hàng</title>
<link rel="stylesheet" href="giohang.css">
</head>
<body>

<div>
    <a href="tra.php?ban=<?= $idBan ?>">⬅ Quay lại đặt món</a>
</div>

<h2>Giỏ hàng của bạn (Bàn <?= $idBan ?>)</h2>

<?php if (!empty($_SESSION['order'])): ?>

<form method="post">
    <div style="text-align:right; margin-bottom:5px; padding-right: 25px; margin-top: 30px">
        <button name="update_notes">Lưu ghi chú</button>
        <button name="delete_selected" id="xoa">XÓA</button>
    </div>
<table width="100%">
    <tr>
        <th>Chọn</th>
        <th>Tên món</th>
        <th>Size</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Ghi chú</th>
        <th>Thành tiền</th>
    </tr>

    <?php foreach ($_SESSION['order'] as $i): ?>
    <tr>
        <td><input type="checkbox" name="chonxoa[]" value="<?= $i['idMon'] ?>"></td>
        <td><?= htmlspecialchars($i['TenMon']) ?></td>
        <td><?= htmlspecialchars($i['Size']) ?></td>
        <td><?= $i['SoLuong'] ?></td>
        <td><?= number_format($i['Gia'], 0, ",", ".") ?>đ</td>
        <td><input type="text" name="ghichu[<?= $i['idMon'] ?>]" value="<?= htmlspecialchars($i['GhiChu']) ?>"></td>
        <td><?= number_format($i['Gia'] * $i['SoLuong'], 0, ",", ".") ?>đ</td>
    </tr>
    <?php endforeach; ?>
</table>
</form>

<div class="total-section" style="text-align:right; margin-top:15px;">
    <p><b>Tổng cộng: <?= number_format($tong, 0, ",", ".") ?>đ</b></p>
    <form method="post">
        <button name="submit_order">Đặt đơn</button>
    </form>
</div>

<?php else: ?>
<p style="text-align:center;">Chưa có món nào trong giỏ hàng.</p>
<?php endif; ?>

</body>
</html>
