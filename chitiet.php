<?php
include("ketnoi.php");
$tt = new KETNOI();

$idMon = isset($_POST['idMon']) ? $_POST['idMon'] : null;
if (!$idMon) {
    header("Location: tra.php");
    exit();
}

$mon = $tt->layChiTietMon($idMon);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết món</title>
    <link rel="stylesheet" href="chitiet.css">
</head>
<body>
    <?php if ($mon): ?>
        <div class="chitietmon">
            <img src="data:image/jpeg;base64,<?= base64_encode($mon['HinhAnh']); ?>" alt="Hình món">
            <div class="chitiet-info">
                <h2><?= htmlspecialchars($mon['TenMon']); ?></h2>
                <p><b>Size:</b> <?= htmlspecialchars($mon['Size']); ?></p>
                <p><b>Giá:</b> <?= number_format($mon['Gia'], 0, ",", "."); ?>đ</p>
                <p><b>Mô tả:</b> <?= nl2br(htmlspecialchars($mon['MoTa'])); ?></p>

                <form action="giohang.php" method="post">
                    <input type="hidden" name="idMon" value="<?= $mon['idMon']; ?>">
                    <button type="submit" name="chonmon">Thêm vào giỏ hàng</button>
                </form>

                <a href="tra.php" class="quaylai">← Quay lại danh sách</a>
            </div>
        </div>
    <?php else: ?>
        <p>Không tìm thấy thông tin món.</p>
    <?php endif; ?>
</body>
</html>
