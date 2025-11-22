<?php
include ('ketnoi.php');
$tt = new KETNOI();
$dsLoai = $tt->hienThiLoaiMonAn();

$idBan = isset($_GET['ban']) ? intval($_GET['ban']) : 0;
if ($idBan <= 0) {
    die("<h3>Không xác định được bàn! Vui lòng quét đúng mã QR.</h3>");
}
session_start();
$_SESSION['idBan'] = $idBan;

$tenBan = "Bàn $idBan";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MENU</title>
    <link rel="stylesheet" href="stylemenu.css">
</head>
<body>
    <nav>
        <h2> Danh Mục </h2>

        <?php 
        foreach ($dsLoai as $loai): 
            $tenLoai = $loai['TenLoai'];
            
            switch ($tenLoai) {
                case 'Trà': $file = 'tra.php'; break;
                case 'Matcha': $file = 'matcha.php'; break;
                case 'Cà Phê': $file = 'caphe.php'; break;
                case 'Trà Sữa': $file = 'trasua.php'; break;
                case 'Sữa Dừa': $file = 'suadua.php'; break;
                case 'Bánh Tráng Trộn': $file = 'bbt.php'; break;
                case 'Bánh Tráng Cuộn': $file = 'btc.php'; break;
                case 'Trứng Cút Nướng': $file = 'tcn.php'; break;
                case 'Topping': $file = 'topping.php'; break;
                case 'Lai Rai': $file = 'lairai.php'; break;
                case 'Mồi Bén': $file = 'moiben.php'; break;
                default: $file = 'gioithieu.php'; break;
            }
        ?>
            <a href="<?php echo $file; ?>" target="content-frame">
                <?php echo $tenLoai; ?>
            </a>
        <?php endforeach; ?>

        <hr>
        <a href="giohang.php" target="content-frame" class="gh">Giỏ Hàng</a>
        <a href="Donhang.php" target="content-frame" class="ttdh">Trạng Thái Đơn Hàng</a>
    </nav>

    <iframe name="content-frame" src="gioithieu.php"></iframe>
</body>
</html>
