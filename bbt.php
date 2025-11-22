<?php
include("ketnoi.php");
$tt = new KETNOI();
$dsbtt = $tt->hienThiBanhTrangTron();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="tra.css">
</head>
<body>
    <h2>BÁNH TRÁNG TRỘN</h2>
    <div class="danhsach">
        <?php foreach ($dsbtt as $btt): ?>
            <div id="loai">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($btt['HinhAnh']); ?>" alt="Hình món"><br>
                <div><?= htmlspecialchars($btt['TenMon']); ?></div>
                <b><?= number_format($btt['Gia'], 0, ",", "."); ?>đ</b><br>

                <div class="nut">
                    <form action="chitiet.php" method="post" class ="chitiet">
                        <input type="hidden" name="idMon" value="<?= $btt['idMon']; ?>">
                        <button type="submit" name="chitiet">Chi tiết</button>
                    </form>
                    <form action="giohang.php" method="post" class="themmon">
                        <input type="hidden" name="idMon" value="<?= $btt['idMon']; ?>">
                        <button type="submit" name="chonmon">Thêm món</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>