<?php
include("ketnoi.php");
$tt = new KETNOI();
$dscaphe = $tt->hienThiCaPhe();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="tra.css">
</head>
<body>
    <h2>CÀ PHÊ</h2>
    <div class="danhsach">
        <?php foreach ($dscaphe as $cp): ?>
            <div id="loai">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($cp['HinhAnh']); ?>" alt="Hình món"><br>
                <div><?= htmlspecialchars($cp['TenMon']); ?></div>
                (<?= htmlspecialchars($cp['Size']); ?>)<br>
                <b><?= number_format($cp['Gia'], 0, ",", "."); ?>đ</b><br>

                <div class="nut">
                    <form action="chitiet.php" method="post" class ="chitiet">
                        <input type="hidden" name="idMon" value="<?= $cp['idMon']; ?>">
                        <button type="submit" name="chitiet">Chi tiết</button>
                    </form>
                    <form action="giohang.php" method="post" class="themmon">
                        <input type="hidden" name="idMon" value="<?= $cp['idMon']; ?>">
                        <button type="submit" name="chonmon">Thêm món</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
