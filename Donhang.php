<?php
session_start();
require_once 'Ketnoidb.php';
$db = new KETNOI();

$idBan = $_SESSION['idBan'] ?? 0;
if ($idBan <= 0) {
    die("<h3>Không xác định được bàn! Vui lòng quét mã QR lại.</h3>");
}

$tenBan = $db->getTenBan($idBan);
$donHangs = $db->getDonHangTheoBan($idBan);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đơn hàng của <?= htmlspecialchars($tenBan) ?></title>
<link rel="stylesheet" href="DonHang.css">
</head>
<body>

<div class="top-bar">
    <a href="gioithieu.php?ban=<?= $idBan ?>" class="back-btn">⬅ Quay lại đặt món</a>
</div>

<h2>Đơn hàng của <?= htmlspecialchars($tenBan) ?></h2>

<?php if (!empty($donHangs)) { ?>
    <?php $so = 1; foreach ($donHangs as $idDon => $don): ?>
        <div class="order-form">
            <div class="order-time">
                <p><b>Đơn hàng #<?= $so ?> - Thời gian:</b> <?= htmlspecialchars($don['ThoiGian']) ?></p>
            </div>

            <table>
                <tr>
                    <th>Tên món</th>
                    <th>Số lượng</th>
                    <th>Ghi chú</th>
                    <th>Thành tiền</th>
                </tr>
                <?php foreach ($don['Mon'] as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['TenMon']) ?></td>
                        <td><?= $m['SoLuong'] ?></td>
                        <td><?= htmlspecialchars($m['GhiChu']) ?></td>
                        <td><?= number_format($m['ThanhTien'], 0, ",", ".") ?>đ</td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="total-section">
                <p><b>Tổng cộng: <?= number_format($don['TongTien'], 0, ",", ".") ?>đ</b></p>
            </div>
        </div>
    <?php $so++; endforeach; ?>
<?php } else { ?>
    <div class="empty-order">
        <p>Chưa có đơn hàng nào cho <?= htmlspecialchars($tenBan) ?>.</p>
    </div>
<?php } ?>

</body>
</html>
