<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa món ăn</title>
    <link rel="stylesheet" href="suamon.css">
</head>
<body>

    <?php
    require_once("ketnoidb.php");
    $db = new KETNOI();

    $mon_an_data = null;
    $danh_sach_loai_arr = [];
    $danh_sach_mon_arr = [];
    $idMonCanSua = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idMon'])) {
        $idMon = $_POST['idMon'];
        $TenMon = $_POST['ten_mon'];
        $idLoai = $_POST['idLoai'];
        $Gia = $_POST['gia'];
        $Size = $_POST['size'];
        $MoTa = $_POST['mo_ta'];
        $HinhAnh = $_POST['hinh_anh']; 
        $TrangThai = $_POST['trang_thai'];

        if ($db->SuaMon($idMon, $TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai)) {
            echo "<script>
                alert('Cập nhật món thành công!');
                window.location.href = 'suamon.php'; 
                </script>";
        } else {
            echo "<script>
                alert('Cập nhật thất bại! Vui lòng thử lại.');
                window.location.href = 'suamon.php?idMon=$idMon'; 
                </script>";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idMon'])) {
        $idMonCanSua = $_GET['idMon'];
        $mon_an_data = $db->LayThongTinMon($idMonCanSua);
        $result_loai = $db->LayDanhSachLoai();
        if ($result_loai) {
            $danh_sach_loai_arr = $result_loai->fetch_all(MYSQLI_ASSOC);
        }
    } else {
        $result_mon = $db->LayDanhSachMon();
        if ($result_mon) {
            $danh_sach_mon_arr = $result_mon->fetch_all(MYSQLI_ASSOC);
        }
    }
    ?>

<div class="Button">
    <a href="thucdon.php" id="back"><b>Quay Lại</b></a>
</div>

    <div class="form-container">
        
        <?php if ($mon_an_data): ?>
        <div class="form-header">
            <h2>Món: <?php echo htmlspecialchars($mon_an_data['TenMon']); ?></h2>
        </div>
        <form action="suamon.php" method="POST">
            <input type="hidden" name="idMon" value="<?php echo $mon_an_data['idMon']; ?>">
            
            <div class="form-body">
                <div class="form-group">
                    <div class="input-wrapper"> 
                        <label for="tenMon">Tên món *</label>
                        <input type="text" id="tenMon" name="ten_mon" value="<?php echo htmlspecialchars($mon_an_data['TenMon']); ?>" required>
                    </div>

                    <div class="input-wrapper">
                        <label for="idLoai">Loại món *</label>
                        <select id="idLoai" name="idLoai" required>
                            <?php foreach ($danh_sach_loai_arr as $loai): ?>
                                <option value="<?php echo $loai['idLoai']; ?>" 
                                    <?php if ($loai['idLoai'] == $mon_an_data['idLoai']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($loai['TenLoai']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-wrapper">
                        <label for="gia">Giá *</label>
                        <input type="number" id="gia" name="gia" value="<?php echo $mon_an_data['Gia']; ?>" required>
                    </div>

                    <div class="input-wrapper">
                        <label for="size">Size</label>
                        <select id="size" name="size">
                            <option value="">-- Chọn size --</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="Nhỏ">Nhỏ</option>
                            <option value="Lớn">Lớn</option>
                        </select><?php echo htmlspecialchars($mon_an_data['Size']); ?>
                    </div>

                    <div class="input-wrapper">
                        <label for="hinhAnh">Hình ảnh (URL)</label>
                        <input type="text" id="hinhAnh" name="hinh_anh" value="<?php echo htmlspecialchars($mon_an_data['HinhAnh']); ?>">
                    </div>

                    <div class="input-wrapper">
                        <label for="moTa">Mô tả</label>
                        <textarea id="moTa" name="mo_ta" rows="3"><?php echo htmlspecialchars($mon_an_data['MoTa']); ?></textarea>
                    </div>

                     <div class="input-wrapper">
                        <label for="trangThai">Trạng thái</label>
                        <select id="trangThai" name="trang_thai">
                            <option value="1" <?php if ($mon_an_data['TrangThai'] == 1) echo 'selected'; ?>>Còn hàng</option>
                            <option value="0" <?php if ($mon_an_data['TrangThai'] == 0) echo 'selected'; ?>>Hết hàng</option>
                        </select>
                    </div>
                    <div class="btn-row">
                        <button type="submit" class="btn-submit">CẬP NHẬT</button>
                        <a href="suamon.php" class="btn-cancel">HỦY</a>
                    </div>               
                </div>
            </div>
        </form>

        <?php else: ?>
        <div class="form-header">
            <h2>Chọn món cần sửa</h2>
        </div>
        <form action="suamon.php" method="GET"> <div class="form-body">
                <div class="form-group">
                    <div class="input-wrapper"> 
                        <label for="idMon">Tên món *</label>
                        <select id="idMon" name="idMon" required>
                            <option value="">-- Vui lòng chọn một món --</option>
                            <?php foreach ($danh_sach_mon_arr as $mon): ?>
                                <option value="<?php echo $mon['idMon']; ?>">
                                    <?php echo htmlspecialchars($mon['TenMon']) . ' (' . htmlspecialchars($mon['Size']) . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">XONG</button>
                </div>
            </div>
        </form>
        <?php endif; ?>

    </div>
</body>
</html>