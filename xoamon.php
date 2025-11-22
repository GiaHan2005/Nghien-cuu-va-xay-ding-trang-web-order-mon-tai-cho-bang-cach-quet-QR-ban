<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xóa món ăn</title>
    <link rel="stylesheet" href="xoamon.css">
</head>
<body>

    <div class="Button">
            <a href="thucdon.php" id="back"><b>Quay Lại</b></a>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2>Xóa món ăn</h2>
        </div>
        <?php
        require_once("ketnoidb.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = new KETNOI();
            $TenMon = $_POST['ten_mon']; 

        if ($db->XoaMon($TenMon)) {
            echo "<script>
                alert('Xóa món thành công!');
                window.location.href = 'menu.php';
                </script>";
        } else {
            echo "<script>
                alert('Không thể xóa món! Có thể tên món không tồn tại.');
                window.location.href = 'xoamon.php';
                </script>";
        }

        $db->DongKetNoi();
        }
        ?>

            
        <form action="" method="POST">    
            <div class="form-body">
                <div class="form-group">
                    <div class="input-wrapper"> 
                        <label for="tenMon">Tên món *</label>
                        <input type="text" id="tenMon" name="ten_mon" placeholder="Tên món" required>
                    </div>
        
                    <button type="submit" class="btn-submit">XÓA MÓN</button>
                </div>
            </div>

        </form>
    </div>

</body>
</html>