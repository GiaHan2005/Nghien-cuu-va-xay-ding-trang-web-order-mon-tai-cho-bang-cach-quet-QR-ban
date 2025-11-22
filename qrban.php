<?php
require_once 'Ketnoidb.php';
$kn = new KETNOI();

$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
    . "://{$_SERVER['HTTP_HOST']}" . '/tiemtra/public/menu.php';

//  CẬP NHẬT MÃ QR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_qr_for'])) {
    $idSave = intval($_POST['save_qr_for']);
    $targetUrl = $baseUrl . '?ban=' . $idSave;

    $kn->LuuMaQRBan($idSave, $targetUrl);

    header('Location: qrban.php');
    exit;
}

$tables = $kn->LayDanhSachBan();
?>


<!doctype html>

<html lang="vi">

<head>

  <meta charset="utf-8">

  <title>Quản lý QR bàn</title>

  <style>

     body{

      font-family:Arial,Helvetica,sans-serif;

      margin:20px;

      background: #fcfdffff;

      color:#222

    }

    .grid{

      display:grid;

      grid-template-columns:repeat(auto-fill,minmax(220px,1fr));

      gap:18px

    }

    .card{

      background:#fff;

      border-radius:8px;

      padding:12px;

      box-shadow:0 6px 18px rgba(0,0,0,0.06);

      text-align:center

    }

    img.qr{

      width:150px;

      height:150px

    }

    .actions{margin-top:8px;

      display:flex;

      gap:8px;

      justify-content:center

    }

    a.btn{

      padding:8px 10px;

      border-radius:6px;

      text-decoration:none;

      color:white;

      background:#1976d2

    }

    button.copy{

      padding:8px 10px;

      border-radius:6px;

      border:1px solid #ccc;

      background:#fff;

      cursor:pointer

    }

    header{

      margin-bottom:12px

    }

  </style>

</head>

<body>

<header>

  <h2>Danh sách QR</h2>

</header>

<div class="grid">

<?php

    foreach ($tables as $t):

          $id = intval($t['idBan']);

          $ten = $t['TenBan'];

          // Tạo URL mục tiêu 

          $targetUrl = $baseUrl . '?ban=' . $id;

          // Tạo URL gọi API tạo QR 

          $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($targetUrl);

?>

  <div class="card">

    <form method="post" style="margin-top:6px">

    <input type="hidden" name="save_qr_for" value="<?= $id ?>">

    <button type="submit" style="padding:6px 8px;border-radius:6px;background:#28a745;color:#fff;border:none;cursor:pointer">Lưu MaQR</button>

    </form>

    <h3><?= htmlspecialchars($ten) ?></h3>

    <img class="qr" src="<?= $qrApiUrl ?>" alt="QR <?= htmlspecialchars($ten) ?>">

    <div class="actions">

      <a class="btn" href="<?= $qrApiUrl ?>" target="_blank" download="QR-<?= $id ?>.png">Tải</a>

      <button class="copy" onclick="navigator.clipboard && navigator.clipboard.writeText('<?= htmlspecialchars($targetUrl) ?>') ? alert('Đã copy URL') : alert('Không copy được, hãy bấm và copy thủ công')">Copy URL</button>

    </div>

    <p style="font-size:13px;color:#666;margin-top:8px;"><small>Link: <a href="<?= htmlspecialchars($targetUrl) ?>" target="_blank"><?= htmlspecialchars($targetUrl) ?></a></small></p>

  </div>

<?php endforeach; ?>

</div>

</body>

</html>