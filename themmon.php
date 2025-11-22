<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Thêm món ăn</title>
  <link rel="stylesheet" href="themmon.css">
</head>
<body>

  <div class="Button">
    <a href="thucdon.php" id="back"><b>Quay Lại</b></a>
  </div>

  <div class="page-wrapper">
    <div class="page-header">
      <h2 id="pageTitle">Thêm món mới</h2>
    </div>

    <div class="card">
        <?php
        require_once("ketnoidb.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = new KetNoi();
            $TenMon = $_POST['TenMon'];
            $idLoai = $_POST['idLoai'];
            $Gia = $_POST['Gia'];
            $Size = $_POST['Size'];
            $MoTa = $_POST['MoTa'];
            $TrangThai = $_POST['TrangThai'];
            $HinhAnh = "";
            if (!empty($_FILES["HinhAnh"]["name"])) {
                $folder = "loadanh/";
                if (!is_dir($folder)) mkdir($folder);
                $HinhAnh = time() . "_" . $_FILES["HinhAnh"]["name"];
                move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $folder . $HinhAnh);
            }

            if ($db->ThemMon($TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai)) {
                echo "<script>
                      alert('Thêm món thành công!');
                      window.location.href = 'themmon.php';
                    </script>";
            } else {
                echo "<script>
                      alert('Lỗi khi thêm món!');
                      window.location.href = 'themmon.php';
                    </script>";
            }
            $db->DongKetNoi();
        }
        ?>

      <form action ="" method="post" enctype="multipart/form-data" novalidate class="form-inline">

        <div class="form-grid">
          <div class="form-row">
            <label for="TenMon">Tên món *</label>
            <input id="TenMon" name="TenMon" type="text" required placeholder="Tên món">
          </div>

          <div class="form-row">
            <label for="idLoai">Loại món *</label>
            <select id="idLoai" name="idLoai" required>
              <option value="">-- Chọn loại món --</option>
              <option value="1">Trà</option>
              <option value="2">Matcha</option>
              <option value="3">Cà phê</option>
              <option value="4">Trà sữa</option>
              <option value="5">Sữa dừa</option>
              <option value="6">Bánh tráng trộn</option>
              <option value="7">Bánh tráng cuộn</option>
              <option value="8">Trứng cút nướng</option>
              <option value="9">Topping</option>
              <option value="10">Lai rai</option>
              <option value="11">Mồi bén</option>
            </select>
          </div>

          <div class="form-row">
            <label for="Gia">Giá (VNĐ) *</label>
            <input id="Gia" name="Gia" type="number" min="0" step="100" required placeholder="0">
          </div>

          <div class="form-row">
            <label for="Size">Size</label>
                <select id="Size" name="Size">
                    <option value="">-- Chọn size --</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="Nhỏ">Nhỏ</option>
                    <option value="Lớn">Lớn</option>
                </select>
            </div>

          <div class="form-row">
            <label for="HinhAnh">Hình ảnh</label>
            <input id="HinhAnh" name="HinhAnh" type="file" accept="image/*">
          </div>

          <div class="form-row">
            <label for="MoTa">Mô tả</label>
            <textarea id="MoTa" name="MoTa" placeholder="Mô tả ngắn..."></textarea>
          </div>

          <div class="form-row">
            <label for="TrangThai">Trạng thái</label>
            <select id="TrangThai" name="TrangThai">
              <option value="1" selected>Hiện</option>
              <option value="0">Ẩn</option>
            </select>
          </div>
        </div>

        <div class="form-row action-row">
          <button type="submit" class="btn btn-primary">THÊM MÓN</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
