<?php
    include("ketnoidb.php");
    $tt = new KETNOI;
    $soNV = $tt->demNhanVien();
    $ttt = new KETNOI;
    $soDH = $ttt->demDonHang();
    $caa = new KETNOI;
    $ca = $caa->xacDinhCa();
    $ttttt = new KETNOI;
    $tongBan = $ttttt->demSoBan();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang chủ</title>
  <link rel="stylesheet" href="trangchu.css">
</head>
<body>
    <header class="topbar">
        <h1 id="title">TRANG CHỦ</h1>
    </header>

    <section id="overview">
        <div class="card purple">
          <div class="icon">👥</div>
          <div class="info">
            <h2 id="soNhanVien">
                <?php
                    echo number_format($soNV);
                ?>
            </h2>
            <p>Nhân viên đang làm</p>
          </div>
        </div>

        <div class="card green">
          <div class="icon">🛒</div>
          <div class="info">
            <h2 id="soDonHang">
                <?php
                    echo number_format($soDH);
                ?>
            </h2>
            <p>Tổng đơn hàng</p>
          </div>
        </div>

        <div class="card orange">
          <div class="icon">🍽️</div>
          <div class="info">
            <h2 id="banDangPV">
                <?php
                    echo number_format($tongBan);
                ?>
            </h2>
            <p>Bàn đang phục vụ</p>
          </div>
        </div>

        <div class="card teal">
          <div class="icon"></div>
          <div class="info">
            <h2 id="Ca">
                <?php
                    echo "Ca: " . $ca;
                ?>
            </h2>
            <p>Đang làm việc</p>
          </div>
        </div>
      </section>

     <section id="rules">
          <h2> NỘI QUY NHÂN VIÊN</h2>
          <div class="rules-box">
            <ol>
              <li>Luôn phục vụ khách hàng với thái độ lịch sự, niềm nở.</li>
              <li>Giữ gìn vệ sinh quầy, bàn, khu vực làm việc luôn sạch sẽ.</li>
              <li>Không sử dụng điện thoại cá nhân trong giờ làm việc (trừ khi cần thiết).</li>
              <li>Tuân thủ quy định về đồng phục và thời gian làm việc.</li>
              <li>Báo cáo ngay cho quản lý khi có sự cố xảy ra.</li>
              <li>Luôn hỗ trợ đồng nghiệp khi cần — tinh thần đồng đội là trên hết </li>
            </ol>
          </div>
     </section>

</body>
</html>
