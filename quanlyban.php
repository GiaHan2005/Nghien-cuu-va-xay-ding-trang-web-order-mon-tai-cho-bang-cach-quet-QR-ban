<?php
session_start();
require_once 'ketnoidb.php';
$kn = new KETNOI();

// Giữ lại query string khi redirect
function redirect_keep($extra = []) {
    $qs = [];
    if (!empty($_GET['filter'])) $qs['filter'] = $_GET['filter'];
    foreach ($extra as $k => $v) $qs[$k] = $v;
    $loc = $_SERVER['PHP_SELF'];
    if (!empty($qs)) $loc .= '?' . http_build_query($qs);
    header('Location: ' . $loc);
    exit;
}

$tables = $kn->getDanhSachBan();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'select_table') {
        $selected = intval($_POST['table_id'] ?? 0);
        if ($selected > 0) redirect_keep(['table' => $selected]);
    }

    if ($action === 'save_table') {
        $tableId = intval($_POST['table_id'] ?? 0);
        $status = $_POST['status'] ?? 'available';
        $note = trim($_POST['table_note'] ?? '');
        $trangthai = ($status === 'reserved') ? 1 : 0;
        $kn->capNhatBan($tableId, $trangthai, $note);
        redirect_keep(['table' => $tableId]);
    }

    if ($action === 'complete') {
        $tableId = intval($_POST['table_id'] ?? 0);
        if ($tableId > 0) {

          $kn->hoanThanhBan($tableId);
          redirect_keep();
        }
    }

    if ($action === 'reset_all') {
        $kn->resetTatCaBan();
        redirect_keep();
    }
}

$filter = $_GET['filter'] ?? 'all';
$active_table = intval($_GET['table'] ?? 0);
$active = ($active_table && isset($tables[$active_table])) ? $tables[$active_table] : null;

$rows = [];
if ($active) {
    $rows = $kn->getChiTietDonTheoBan($active['id']);
}
?>

<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Quản lý bàn ăn</title>
<link rel="stylesheet" href="quanlyban.css">
</head>
<body>
  <header class="topbar">
    <h1 id="title">QUẢN LÝ BÀN ĂN</h1>
  </header>
<div class="container">
  <div class="header">
    <div class="controls">
      <form method="get" style="display:inline-block;">
        <label for="filter">Lọc:</label>
        <select id="filter" name="filter" onchange="this.form.submit()">
          <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>Tất cả</option>
          <option value="reserved" <?= $filter === 'reserved' ? 'selected' : '' ?>>Đã có khách</option>
          <option value="available" <?= $filter === 'available' ? 'selected' : '' ?>>Trống</option>
        </select>
      </form>

      <form method="post" style="display:inline-block; margin-left:12px;" onsubmit="return confirm('Bạn có chắc muốn RESET tất cả?');">
        <input type="hidden" name="action" value="reset_all">
        <button class="btn btn-danger" type="submit">RESET</button>
      </form>
    </div>
  </div>

  <div class="main-content">
    <div class="info-box">
      <?php if ($active): ?>
        <strong><?= htmlspecialchars($active['TenBan']) ?></strong><hr>
        <form method="post">
          <input type="hidden" name="table_id" value="<?= $active['id'] ?>">
          <label>Trạng thái:
            <select name="status">
              <option value="available" <?= !$active['reserved'] ? 'selected' : '' ?>>Trống</option>
              <option value="reserved" <?= $active['reserved'] ? 'selected' : '' ?>>Đã có khách</option>
            </select>
          </label>
          <br>
          <label>Ghi chú:
            <input name="table_note" class="input" value="<?= htmlspecialchars($active['note']) ?>">
          </label>
          <hr>
          <h4>Khách đặt món:</h4>
          <?php if (!empty($rows)): ?>
            <?php 
              $total = 0; 
              foreach ($rows as $o) {
                  $total += intval($o['ThanhTien']);
              }
            ?>
            <table class="orders-table">
              <thead><tr><th>Tên món</th><th>SL</th><th>Ghi chú</th><th>Giá</th></tr></thead>
              <tbody>
              <?php foreach ($rows as $o): ?>
                <tr>
                  <td><?= htmlspecialchars($o['TenMon']) ?></td>
                  <td><?= intval($o['SoLuong']) ?></td>
                  <td><?= htmlspecialchars($o['GhiChuCT'] ?? $o['GhiChuDon']) ?></td>
                  <td><?= number_format(intval($o['ThanhTien']), 0, ',', '.') ?>đ</td>
                </tr>
              <?php endforeach; ?>
              <tr>
                <td colspan="3"><strong>Tổng cộng:</strong></td>
                <td><strong><?= number_format($total, 0, ',', '.') ?>đ</strong></td>
              </tr>
              </tbody>
            </table>
          <?php else: ?>
            <p><i>Chưa có khách đặt món cho bàn này.</i></p>
          <?php endif; ?>
          <br>
          <button class="btn btn-primary" type="submit" name="action" value="save_table">Lưu</button>
          <button class="btn btn-danger" type="submit" name="action" value="complete" onclick="return confirm('Xác nhận hoàn thành và xóa đơn hàng của bàn này?')">Hoàn thành</button>
        </form>
      <?php else: ?>
        <p>Chọn bàn để xem chi tiết.</p>
      <?php endif; ?>
    </div>

    <div class="table-grid">
      <?php foreach ($tables as $id => $t):
        if ($filter === 'reserved' && !$t['reserved']) continue;
        if ($filter === 'available' && $t['reserved']) continue;
      ?>
        <form method="post" style="display:inline-block;">
          <input type="hidden" name="action" value="select_table">
          <input type="hidden" name="table_id" value="<?= $id ?>">
          <button type="submit" class="table-btn <?= $t['reserved'] ? 'reserved' : 'available' ?>">
            <?= htmlspecialchars($t['TenBan']) ?><br>
            <small><?= $t['reserved'] ? 'Đang có khách' : 'Trống' ?></small>
          </button>
        </form>
      <?php endforeach; ?>
    </div>
  </div>
</div>
</body>
</html>
