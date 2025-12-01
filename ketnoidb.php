
<?php
class KETNOI {
    public $host ='sql310.infinityfree.com';
    public $user = 'if0_40548979';
    public $pass = '0902596241';
    public $dbname = 'if0_40548979_tiemtra';
    public $db;

    public function __construct() {
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->db->connect_error) {
            die('Kết nối thất bại: ' . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
    }

    //  Kiểm tra đăng nhập
    public function check_login($Username, $Matkhau) {
        $sql = "SELECT idNV, HoVaten, Username, MatKhau FROM nhan_vien WHERE Username = ? AND MatKhau = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("ss", $Username, $Matkhau);
        $kq->execute();
        $result = $kq->get_result();
        $nv = $result->fetch_assoc();

        if ($nv) {
            return $nv;   
        }
        return false; 
    }

    //  Thêm món
    public function ThemMon($TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai) {
        $sql = "INSERT INTO mon_an (TenMon, idLoai, Gia, Size, MoTa, HinhAnh, TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("siisssi", $TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai);
        return $kq->execute();
    }

    //  Xóa món theo Tên
    public function XoaMon($TenMon) {
        $sql = "DELETE FROM mon_an WHERE TenMon = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("s", $TenMon);
        return $kq->execute();
    }

    //  Lấy danh sách món
    public function LayDanhSachMon() {
        $sql = "SELECT idMon, TenMon, Size FROM mon_an ORDER BY TenMon";
        return $this->db->query($sql);
    }

    //  Lấy danh sách loại
    public function LayDanhSachLoai() {
        $sql = "SELECT idLoai, TenLoai FROM loai_mon_an ORDER BY TenLoai";
        return $this->db->query($sql);
    }

    //  Lấy thông tin món theo ID
    public function LayThongTinMon($idMon) {
        $sql = "SELECT * FROM mon_an WHERE idMon = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("i", $idMon);
        $kq->execute();
        $result = $kq->get_result();
        return $result->fetch_assoc();
    }

    // Sửa món ăn
    public function SuaMon($idMon, $TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai) {
        $sql = "UPDATE mon_an 
                SET TenMon = ?, idLoai = ?, Gia = ?, Size = ?, MoTa = ?, HinhAnh = ?, TrangThai = ?
                WHERE idMon = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("siisssii", $TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai, $idMon);
        return $kq->execute();
    }

    //  Hiển thị món ăn 
    public function hienThiMonAn() {
        $sql = "SELECT * FROM mon_an 
                JOIN loai_mon_an ON loai_mon_an.idLoai = mon_an.idLoai";
        return $this->db->query($sql);
    }

    //  Lấy danh sách nhân viên
    public function LayDanhSachNV() {
        $sql = "SELECT idNV, HoVaten, ChucVu, HinhThuc, SoDienThoai FROM nhan_vien ORDER BY idNV";
        return $this->db->query($sql);
    }

    //  Lấy danh sách bàn
    public function LayDanhSachBan() {
        $sql = "SELECT idBan, TenBan, MaQR FROM ban_an ORDER BY idBan";
        return $this->db->query($sql);
    }

    //  Lưu mã QR của bàn
    public function LuuMaQRBan($idBan, $MaQR) {
        $sql = "UPDATE ban_an SET MaQR = ? WHERE idBan = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("si", $MaQR, $idBan);
        return $kq->execute();
    }

    //  Lấy kết nối DB 
    public function getConnection() {
        return $this->db;
    }
    public function DongKetNoi() {
        if ($this->db) {
            $this->db->close();
        }
    }
    //  Thêm nhân viên
    public function themNhanVien($HoVaten, $Username, $ChucVu, $HinhThuc, $SoDienThoai, $MatKhau) {
        $sql = "INSERT INTO nhan_vien (HoVaten, Username, ChucVu, HinhThuc, SoDienThoai, MatKhau)
                VALUES (?, ?, ?, ?, ?, ?)";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("ssssss", $HoVaten, $Username, $ChucVu, $HinhThuc, $SoDienThoai, $MatKhau);
        return $kq->execute();
    }

    //  Xóa nhân viên
    public function xoaNhanVien($idNV) {
        $sql = "DELETE FROM nhan_vien WHERE idNV = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("i", $idNV);
        return $kq->execute();
    }

    //  Lưu đơn hàng 
    public function luuDonHang($idBan, $tongTien, $ghiChu, $chiTietMon) {
        $sqlDon = "INSERT INTO don_hang (idBan, TongTien, GhiChu, TrangThai, ThoiGian)
                   VALUES (?, ?, ?, 0, NOW())";
        $kq = $this->db->prepare($sqlDon);
        $kq->bind_param("iis", $idBan, $tongTien, $ghiChu);

        if ($kq->execute()) {
            $idDon = $this->db->insert_id;

            // Lưu chi tiết đơn hàng
            foreach ($chiTietMon as $m) {
                $sqlCT = "INSERT INTO chi_tiet_don (idDonHang, idMon, SoLuong, ThanhTien, GhiChu, TrangThai)
                          VALUES (?, ?, ?, ?, ?, 0)";
                $kqCT = $this->db->prepare($sqlCT);
                $kqCT->bind_param("iiiis", $idDon, $m['idMon'], $m['SoLuong'], $m['TongTien'], $m['GhiChu']);
                $kqCT->execute();
            }

            $sqlBan = "UPDATE ban_an SET TrangThai = 1 WHERE idBan = ?";
            $kqBan = $this->db->prepare($sqlBan);
            $kqBan->bind_param("i", $idBan);
            $kqBan->execute();

            return true;
        }
        return false;
    }

    //  Lấy đơn hàng theo bàn
    public function getDonTheoBan($idBan) {
        $sql = "SELECT c.*, m.TenMon, m.Gia, b.TenBan 
                FROM chi_tiet_don c
                JOIN don_hang d ON c.idDonHang = d.idDonHang
                JOIN mon_an m ON c.idMon = m.idMon
                JOIN ban_an b ON d.idBan = b.idBan
                WHERE d.idBan = ? AND d.TrangThai = 0";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("i", $idBan);
        $kq->execute();
        $don = $kq->get_result();

        $data = [];
        while ($r = $don->fetch_assoc()) {
            $data[] = $r;
        }
        return $data;
    }

    function suaNhanVien($idNV, $hoTen, $username, $chucVu, $hinhThuc, $sdt, $matKhau) {
        if (empty($matKhau)) {
        $sql = "UPDATE nhan_vien 
                SET HoVaten = ?, ChucVu = ?, HinhThuc = ?, SoDienThoai = ? 
                WHERE idNV = ?";
        
        $kq = $this->db->prepare($sql);
        $kq->bind_param("sssssi", $hoTen, $username, $chucVu, $hinhThuc, $sdt, $idNV);
        } 
        else {
        $sql = "UPDATE nhan_vien 
                SET HoVaten = ?, Username = ?, ChucVu = ?, HinhThuc = ?, SoDienThoai = ?, MatKhau = ?
                WHERE idNV = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("ssssssi", $hoTen, $username, $chucVu, $hinhThuc, $sdt, $matKhau, $idNV);
    }
    return $kq->execute();
}

    function layMotNhanVien($id) {
        $sql = "SELECT idNV, HoVaten, Username, ChucVu, HinhThuc, SoDienThoai FROM nhan_vien WHERE idNV = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("i", $id);
        $kq->execute();
        $result = $kq->get_result();
        return $result->fetch_assoc(); 
    }
    public function hienThiLoaiMonAn(){
        $sql ="SELECT *
               FROM loai_mon_an";
        $result = $this->db->query($sql);
        $list = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
        }
        return $list;
    }

    public function hienThiTra(){
        $sql = "SELECT *
                FROM mon_an
                WHERE TrangThai = 1 AND idLoai = 1";
        $result = $this->db->query($sql);
        $list = [];
        if ($result && $result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $list[] = $row;
            }
        }
        return $list;
    }

    public function hienThiMatcha(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 2";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiCaPhe(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 3";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiTraSua(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 4";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiSuaDua(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 5";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiBanhTrangTron(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 6";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiBanhTrangCuon(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 7";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiTrungCutNuong(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 8";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiLaiRai(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 10";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiMoiBen(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 11";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function hienThiTopping(){
            $sql = "SELECT *
                    FROM mon_an
                    WHERE TrangThai = 1 AND idLoai = 9";
            $result = $this->db->query($sql);
            $list = [];
            if ($result && $result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $list[] = $row;
                }
            }
            return $list;
        }

    public function LayTrangThaiDonHangGanNhat() {
        $sql = "SELECT TrangThai, ThoiGian FROM don_hang ORDER BY idDonHang DESC LIMIT 1";
        $result = $this->db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return [
                'trangThai' => (int)($row['TrangThai'] ?? 0),
                'thoiGian' => $row['ThoiGian'] ?? date("Y-m-d H:i:s")
            ];
        }
        
        return [
            'trangThai' => 0,
            'thoiGian' => date("Y-m-d H:i:s")
        ];
    }

     // QUẢN LÝ BÀN 
    public function getDanhSachBan() {
        $tables = [];
        $sql = "SELECT idBan, TenBan, MaQR, TrangThai, GhiChu FROM ban_an ORDER BY idBan";
        $res = $this->db->query($sql);
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $tables[intval($r['idBan'])] = [
                    'id' => intval($r['idBan']),
                    'TenBan' => $r['TenBan'],
                    'reserved' => intval($r['TrangThai']) === 1,
                    'note' => $r['GhiChu'] ?? ''
                ];
            }
        }
        return $tables;
    }

    public function capNhatBan($idBan, $trangthai, $ghichu) {
        $sql = "UPDATE ban_an SET TrangThai = ?, GhiChu = ? WHERE idBan = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("isi", $trangthai, $ghichu, $idBan);
        $kq->execute();
        $kq->close();
    }

    public function hoanThanhBan($idBan) {
        $sql = "UPDATE don_hang SET TrangThai = 1 WHERE idBan = ? AND TrangThai = 0";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("i", $idBan);
        $kq->execute();
        $kq->close();

        $sql = "UPDATE ban_an SET TrangThai = 0, GhiChu = NULL WHERE idBan = ?";
        $kq2 = $this->db->prepare($sql);
        $kq2->bind_param("i", $idBan);
        $kq2->execute();
        $kq2->close();
    }

    public function resetTatCaBan() {
        $this->db->query("UPDATE ban_an SET TrangThai = 0, GhiChu = NULL");
        $this->db->query("UPDATE don_hang SET TrangThai = 1 WHERE TrangThai = 0");
    }

    public function getChiTietDonTheoBan($idBan) {
        $rows = [];
        $sql = "SELECT c.idCTDH, m.TenMon, c.SoLuong, c.ThanhTien, c.GhiChu AS GhiChuCT, d.GhiChu AS GhiChuDon
                FROM chi_tiet_don c
                JOIN don_hang d ON c.idDonHang = d.idDonHang
                LEFT JOIN mon_an m ON c.idMon = m.idMon
                WHERE d.idBan = ? AND d.TrangThai = 0
                ORDER BY c.idCTDH";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("i", $idBan);
        $kq->execute();
        $chitietdon = $kq->get_result();
        while ($r = $chitietdon->fetch_assoc()) {
            $rows[] = $r;
        }
        $kq->close();
        return $rows;
    }

    // HỖ TRỢ HIỂN THỊ ĐƠN HÀNG
public function getTenBan($idBan) {
    $sql = "SELECT TenBan FROM ban_an WHERE idBan = ?";
    $kq = $this->db->prepare($sql);
    $kq->bind_param("i", $idBan);
    $kq->execute();
    $res = $kq->get_result();
    $tenBan = '';
    if ($row = $res->fetch_assoc()) {
        $tenBan = $row['TenBan'];
    }
    $kq->close();
    return $tenBan;
}

public function getDonHangTheoBan($idBan) {
    $sql = "SELECT d.idDonHang, d.ThoiGian, d.TongTien, d.TrangThai,
               c.idMon, m.TenMon, c.SoLuong, c.ThanhTien, c.GhiChu
            FROM don_hang d
            JOIN chi_tiet_don c ON d.idDonHang = c.idDonHang
            JOIN mon_an m ON c.idMon = m.idMon
            WHERE d.idBan = ?
            ORDER BY d.idDonHang DESC, c.idCTDH ASC";
    $kq = $this->db->prepare($sql);
    $kq->bind_param("i", $idBan);
    $kq->execute();
    $res = $kq->get_result();

    $donHangs = [];
    while ($row = $res->fetch_assoc()) {
        $idDon = $row['idDonHang'];
        if (!isset($donHangs[$idDon])) {
            $donHangs[$idDon] = [
                'ThoiGian' => $row['ThoiGian'],
                'TongTien' => $row['TongTien'],
                'TrangThai' => $row['TrangThai'],
                'Mon' => []
            ];
        }
        $donHangs[$idDon]['Mon'][] = [
            'TenMon' => $row['TenMon'],
            'SoLuong' => $row['SoLuong'],
            'ThanhTien' => $row['ThanhTien'],
            'GhiChu' => $row['GhiChu']
        ];
    }

    $kq->close();
    return $donHangs;
}

// LẤY THÔNG TIN MÓN ĂN 
    public function getMonById($idMon) {
        $sql = "SELECT idMon, TenMon, Size, Gia FROM mon_an WHERE idMon = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("i", $idMon);
        $kq->execute();
        $result = $kq->get_result();
        $mon = $result->fetch_assoc();
        $kq->close();
        return $mon;
    }

    // TẠO ĐƠN HÀNG
    public function createDonHang($idBan, $tongTien, $ghiChu) {
        $sql = "INSERT INTO don_hang (idBan, TongTien, GhiChu, TrangThai) VALUES (?, ?, ?, 0)";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("ids", $idBan, $tongTien, $ghiChu);
        $kq->execute();
        $idDonHang = $kq->insert_id;
        $kq->close();
        return $idDonHang;
    }

    // THÊM CHI TIẾT ĐƠN 
    public function addChiTietDon($idDonHang, $idMon, $idNV, $soLuong, $dongia, $thanhTien, $ghiChu, $trangthai) {
        $sql = "INSERT INTO chi_tiet_don (idDonHang, idMon, idNV, SoLuong, DonGia, ThanhTien, GhiChu, TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("iiiiddss", $idDonHang, $idMon, $idNV, $soLuong, $dongia, $thanhTien, $ghiChu, $trangthai);
        $kq->execute();
        $kq->close();
    }

    // CẬP NHẬT TRẠNG THÁI BÀN
    public function updateTrangThaiBan($idBan, $trangThai) {
        $sql = "UPDATE ban_an SET TrangThai = ? WHERE idBan = ?";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("ii", $trangThai, $idBan);
        $kq->execute();
        $kq->close();
    }

    // Xóa đơn hàng và chi tiết đơn theo id bàn
public function xoaDonHangTheoBan($idBan) {
    // Lấy danh sách idDonHang
    $sql = "SELECT idDonHang FROM don_hang WHERE idBan = ?";
    $kq = $this->db->prepare($sql);
    $kq->bind_param("i", $idBan);
    $kq->execute();
    $result = $kq->get_result();

    while ($row = $result->fetch_assoc()) {
        $idDonHang = $row['idDonHang'];
        $sql = "DELETE FROM chi_tiet_don WHERE idDonHang = ?";
        $delCT = $this->db->prepare($sql);
        $delCT->bind_param("i", $idDonHang);
        $delCT->execute();
        $delCT->close();
    }
    $kq->close();

    // Xóa đơn hàng chính
    $sql = "DELETE FROM don_hang WHERE idBan = ?";
    $delDH = $this->db->prepare($sql);
    $delDH->bind_param("i", $idBan);
    $delDH->execute();
    $delDH->close();
}
public function setDonHangHoanThanh($tableId) {
    $sql = "UPDATE don_hang SET TrangThai = 0 WHERE idBan = ? ";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $tableId);
    return $stmt->execute();
}
public function layChiTietMon($idMon) {
        $sql = "SELECT * FROM mon_an WHERE idMon = $idMon";
        $result =$this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
}



 // ĐẾM NHÂN VIÊN 
        public function demNhanVien() {
            $sql = "SELECT COUNT(*) AS tong FROM nhan_vien";
            $result = $this->db->query($sql);
            if ($result && $row = $result->fetch_assoc()) {
                return $row['tong'];
            }
            return 0;
        }

        // ĐẾM TỔNG ĐƠN HÀNG
        public function demDonHang() {
            $homNay = date("Y-m-d");
            $sql = "SELECT COUNT(*) AS tong FROM don_hang WHERE DATE(ThoiGian) = '$homNay'";
            $result = $this->db->query($sql);
            if ($result && $row = $result->fetch_assoc()) {
                return $row['tong'];
            }
            return 0;
        }

       function xacDinhCa($time = null) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        if ($time === null) {
            $time = date("H:i");
        }

    list($h, $m) = explode(":", $time);
    $totalMinutes = $h * 60 + $m;

    $startA = 8 * 60;    
    $endA   = 15 * 60;   
    $startB = 15 * 60;   
    $endB   = 22 * 60;  

    if ($totalMinutes >= $startA && $totalMinutes < $endA) {
        return "A";
    } elseif ($totalMinutes >= $startB && $totalMinutes < $endB) {
        return "B";
    } else {
        return "Không thuộc ca nào";
    }
}


        // ĐẾM SỐ BÀN ĐANG PHỤC VỤ 
        public function demSoBan() {
            $sql = "SELECT COUNT(*) AS tong FROM ban_an WHERE TrangThai = 1";
            $result = $this->db->query($sql);
            if ($result && $row = $result->fetch_assoc()) {
                return $row['tong'];
            }
            return 0;
        }

}
?>

