<?php
include("ketnoi.php");
$tt = new KETNOI();
$dslr = $tt->hienThiLaiRai();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="tra.css">
</head>
<body>
    <h2>LAI RAI</h2>
    <div class="danhsach">
        <?php foreach ($dslr as $lr): ?>
            <div id="loai">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($lr['HinhAnh']); ?>" alt="Hình món"><br>
                <div><?= htmlspecialchars($lr['TenMon']); ?></div>
                <b><?= number_format($lr['Gia'], 0, ",", "."); ?>đ</b><br>

                <div class="nut">
                    <form action="chitiet.php" method="post" class ="chitiet">
                        <input type="hidden" name="idMon" value="<?= $lr['idMon']; ?>">
                        <button type="submit" name="chitiet">Chi tiết</button>
                    </form>
                    <form action="giohang.php" method="post" class="themmon">
                        <input type="hidden" name="idMon" value="<?= $lr['idMon']; ?>">
                        <button type="submit" name="chonmon">Thêm món</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
