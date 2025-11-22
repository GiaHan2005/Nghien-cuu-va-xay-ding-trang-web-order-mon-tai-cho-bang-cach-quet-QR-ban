<?php
include("ketnoi.php");
$tt = new KETNOI();
$dsMatcha = $tt->hienThiMatcha();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="tra.css">
</head>
<body>
    <h2>MATCHA</h2>
    <div class="danhsach">
        <?php foreach ($dsMatcha as $Matcha): ?>
            <div id="loai">
                <img src="data:image/jpeg;base64,<?= base64_encode($Matcha['HinhAnh']); ?>" alt="Hình món"><br>
                <div><?= htmlspecialchars($Matcha['TenMon']); ?></div>
                (<?= htmlspecialchars($Matcha['Size']); ?>)<br>
                <b><?= number_format($Matcha['Gia'], 0, ",", "."); ?>đ</b><br>

                <div class="nut">
                    <form action="chitiet.php" method="post" class ="chitiet">
                        <input type="hidden" name="idMon" value="<?= $Matcha['idMon']; ?>">
                        <button type="submit" name="chitiet">Chi tiết</button>
                    </form>
                    <form action="giohang.php" method="post" class="themmon">
                        <input type="hidden" name="idMon" value="<?= $Matcha['idMon']; ?>">
                        <button type="submit" name="chonmon">Thêm món</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
