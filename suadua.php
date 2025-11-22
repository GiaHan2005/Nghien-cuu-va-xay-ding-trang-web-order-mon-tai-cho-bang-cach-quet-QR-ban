<?php
include("ketnoi.php");
$tt = new KETNOI();
$dssd = $tt->hienThiSuaDua();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="tra.css">
</head>
<body>
    <h2>SỮA DỪA</h2>
    <div class="danhsach">
        <?php foreach ($dssd as $sd): ?>
            <div id="loai">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($sd['HinhAnh']); ?>" alt="Hình món"><br>
                <div><?= htmlspecialchars($sd['TenMon']); ?></div>
                (<?= htmlspecialchars($sd['Size']); ?>)<br>
                <b><?= number_format($sd['Gia'], 0, ",", "."); ?>đ</b><br>

                <div class="nut">
                    <form action="chitiet.php" method="post" class ="chitiet">
                        <input type="hidden" name="idMon" value="<?= $sd['idMon']; ?>">
                        <button type="submit" name="chitiet">Chi tiết</button>
                    </form>
                    <form action="giohang.php" method="post" class="themmon">
                        <input type="hidden" name="idMon" value="<?= $sd['idMon']; ?>">
                        <button type="submit" name="chonmon">Thêm món</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>