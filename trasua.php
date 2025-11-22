<?php
include("ketnoi.php");
$tt = new KETNOI();
$dstrasua = $tt->hienThiTraSua();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="tra.css">
</head>
<body>
    <h2>TRÀ SỮA</h2>
    <div class="danhsach">
        <?php foreach ($dstrasua as $ts): ?>
            <div id="loai">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($ts['HinhAnh']); ?>" alt="Hình món"><br>
                <div><?= htmlspecialchars($ts['TenMon']); ?></div>
                (<?= htmlspecialchars($ts['Size']); ?>)<br>
                <b><?= number_format($ts['Gia'], 0, ",", "."); ?>đ</b><br>

                <div class="nut">
                    <form action="chitiet.php" method="post" class ="chitiet">
                        <input type="hidden" name="idMon" value="<?= $ts['idMon']; ?>">
                        <button type="submit" name="chitiet">Chi tiết</button>
                    </form>
                    <form action="giohang.php" method="post" class="themmon">
                        <input type="hidden" name="idMon" value="<?= $ts['idMon']; ?>">
                        <button type="submit" name="chonmon">Thêm món</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
