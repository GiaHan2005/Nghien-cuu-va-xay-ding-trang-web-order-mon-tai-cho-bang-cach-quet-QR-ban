<?php
include ("ketnoidb.php");
$tt = new KETNOI;
$kq = $tt->hienThiMonAn();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách món ăn</title>
  <link rel="stylesheet" href="thucdon.css">
</head>
<body>
  <header class="topbar">
      <h1 id="title">DANH SÁCH MÓN ĂN</h1>
  </header>

        <div class=button>
                <a href="themmon.php"><button id=them type="submit">THÊM</button></a>
                <a href="suamon.php"><button id=sua type="submit">SỬA</button></a>
                <a href="xoamon.php"><button id=xoa type="submit">XÓA</button></a>
        </div>


      <table>
        <tr>
          <th>ID Món</th>
          <th>Tên Món</th>
          <th>Tên Loại </th>
          <th>Size</th>
          <th>Giá</th>
          <th>Trạng Thái</th>
        </tr>
    <?php
    if ($kq->num_rows > 0) {
                while ($row = $kq->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['idMon']}</td>";
                    echo "<td>{$row['TenMon']}</td>";
                    echo "<td>{$row['TenLoai']}</td>";
                    echo "<td>{$row['Size']}</td>";
                    echo "<td>{$row['Gia']}</td>";
                    echo "<td>{$row['TrangThai']}</td>";
                }
            } else {
                echo "<tr><td colspan='9'>Không có dữ liệu</td></tr>";
            }
    ?>
    </table>
</body>
</html>
