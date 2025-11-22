
<?php
class KETNOI {
    public $host = 'localhost';
    public $user = 'root';
    public $pass = '';
    public $dbname = 'tiemtra3';
    public $db;

    public function __construct() {
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->db->connect_error) {
            die('Kết nối thất bại: ' . $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
    }

    //  Kiểm tra đăng nhập
    public function check_login($username, $password) {
        $sql = "SELECT * FROM nhan_vien WHERE Username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $rowNV = $result->fetch_assoc()) {
            // so sánh mật khẩu mã hóa
            if (password_verify($password, $rowNV['MatKhau'])) {
                return $rowNV;
            }
        }
        return false;
    }

    //  Thêm món
    public function ThemMon($TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai) {
        $sql = "INSERT INTO mon_an (TenMon, idLoai, Gia, Size, MoTa, HinhAnh, TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siisssi", $TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai);
        return $stmt->execute();
    }

    //  Xóa món theo Tên
    public function XoaMon($TenMon) {
        $sql = "DELETE FROM mon_an WHERE TenMon = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $TenMon);
        return $stmt->execute();
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
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idMon);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Sửa món ăn
    public function SuaMon($idMon, $TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai) {
        $sql = "UPDATE mon_an 
                SET TenMon = ?, idLoai = ?, Gia = ?, Size = ?, MoTa = ?, HinhAnh = ?, TrangThai = ?
                WHERE idMon = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siisssii", $TenMon, $idLoai, $Gia, $Size, $MoTa, $HinhAnh, $TrangThai, $idMon);
        return $stmt->execute();
    }

    //  Hiển thị món ăn (JOIN)
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
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $MaQR, $idBan);
        return $stmt->execute();
    }

    //  Lấy kết nối DB (nếu cần)
    public function getConnection() {
        return $this->db;
    }

    //  Thêm nhân viên
    public function themNhanVien($HoVaten, $Username, $ChucVu, $HinhThuc, $SoDienThoai, $MatKhau) {
        $hash = password_hash($MatKhau, PASSWORD_DEFAULT);
        $sql = "INSERT INTO nhan_vien (HoVaten, Username, ChucVu, HinhThuc, SoDienThoai, MatKhau)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssss", $HoVaten, $Username, $ChucVu, $HinhThuc, $SoDienThoai, $hash);
        return $stmt->execute();
    }

    //  Xóa nhân viên
    public function xoaNhanVien($idNV) {
        $sql = "DELETE FROM nhan_vien WHERE idNV = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idNV);
        return $stmt->execute();
    }

    //  Lưu đơn hàng (sửa lỗi chèn SQL trực tiếp)
    public function luuDonHang($idBan, $tongTien, $ghiChu, $chiTietMon) {
        $sqlDon = "INSERT INTO don_hang (idBan, TongTien, GhiChu, TrangThai, ThoiGian)
                   VALUES (?, ?, ?, 0, NOW())";
        $stmt = $this->db->prepare($sqlDon);
        $stmt->bind_param("iis", $idBan, $tongTien, $ghiChu);

        if ($stmt->execute()) {
            $idDon = $this->db->insert_id;

            // Lưu chi tiết đơn hàng
            foreach ($chiTietMon as $m) {
                $sqlCT = "INSERT INTO chi_tiet_don (idDonHang, idMon, SoLuong, ThanhTien, GhiChu, TrangThai)
                          VALUES (?, ?, ?, ?, ?, 0)";
                $stmtCT = $this->db->prepare($sqlCT);
                $stmtCT->bind_param("iiiis", $idDon, $m['idMon'], $m['SoLuong'], $m['TongTien'], $m['GhiChu']);
                $stmtCT->execute();
            }

            // Cập nhật trạng thái bàn
            $sqlBan = "UPDATE ban_an SET TrangThai = 1 WHERE idBan = ?";
            $stmtBan = $this->db->prepare($sqlBan);
            $stmtBan->bind_param("i", $idBan);
            $stmtBan->execute();

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
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idBan);
        $stmt->execute();
        $res = $stmt->get_result();

        $data = [];
        while ($r = $res->fetch_assoc()) {
            $data[] = $r;
        }
        return $data;
    }

     function suaNhanVien($idNV, $hoTen, $chucVu, $hinhThuc, $sdt) {
        $sql = "UPDATE nhan_vien 
                SET HoVaten = ?, ChucVu = ?, HinhThuc = ?, SoDienThoai = ? 
                WHERE idNV = ?";
        
        $stmt = $this->db->prepare($sql);
        // "ssssi" = string, string, string, string, integer
        $stmt->bind_param("ssssi", $hoTen, $chucVu, $hinhThuc, $sdt, $idNV);
        
        return $stmt->execute(); // Trả về true nếu thành công
    }

    function layMotNhanVien($id) {
        $sql = "SELECT idNV, HoVaten, ChucVu, HinhThuc, SoDienThoai FROM nhan_vien WHERE idNV = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id); // "i" = integer
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về 1 mảng dữ liệu của nhân viên
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
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isi", $trangthai, $ghichu, $idBan);
        $stmt->execute();
        $stmt->close();
    }

    public function hoanThanhBan($idBan) {
        // Cập nhật đơn hàng
        $stmt = $this->db->prepare("UPDATE don_hang SET TrangThai = 1 WHERE idBan = ? AND TrangThai = 0");
        $stmt->bind_param("i", $idBan);
        $stmt->execute();
        $stmt->close();

        // Cập nhật bàn về trạng thái trống
        $stmt2 = $this->db->prepare("UPDATE ban_an SET TrangThai = 0, GhiChu = NULL WHERE idBan = ?");
        $stmt2->bind_param("i", $idBan);
        $stmt2->execute();
        $stmt2->close();
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
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idBan);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        $stmt->close();
        return $rows;
    }

    // ================== HỖ TRỢ HIỂN THỊ ĐƠN HÀNG ==================
public function getTenBan($idBan) {
    $sql = "SELECT TenBan FROM ban_an WHERE idBan = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $idBan);
    $stmt->execute();
    $res = $stmt->get_result();
    $tenBan = '';
    if ($row = $res->fetch_assoc()) {
        $tenBan = $row['TenBan'];
    }
    $stmt->close();
    return $tenBan;
}

public function getDonHangTheoBan($idBan) {
    $sql = "SELECT d.idDonHang, d.ThoiGian, d.TongTien, d.TrangThai,
               c.idMon, m.TenMon, c.SoLuong, c.ThanhTien, c.GhiChu
            FROM don_hang d
            JOIN chi_tiet_don c ON d.idDonHang = c.idDonHang
            JOIN mon_an m ON c.idMon = m.idMon
            WHERE d.idBan = ? AND d.TrangThai = 0
            ORDER BY d.idDonHang DESC, c.idCTDH ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $idBan);
    $stmt->execute();
    $res = $stmt->get_result();

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

    $stmt->close();
    return $donHangs;
}

// ================== LẤY THÔNG TIN MÓN ĂN ==================
    public function getMonById($idMon) {
        $sql = "SELECT idMon, TenMon, Size, Gia FROM mon_an WHERE idMon = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idMon);
        $stmt->execute();
        $result = $stmt->get_result();
        $mon = $result->fetch_assoc();
        $stmt->close();
        return $mon;
    }

    // ================== TẠO ĐƠN HÀNG ==================
    public function createDonHang($idBan, $tongTien, $ghiChu) {
        $sql = "INSERT INTO don_hang (idBan, TongTien, GhiChu, TrangThai) VALUES (?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ids", $idBan, $tongTien, $ghiChu);
        $stmt->execute();
        $idDonHang = $stmt->insert_id;
        $stmt->close();
        return $idDonHang;
    }

    // THÊM CHI TIẾT ĐƠN 
    public function addChiTietDon($idDonHang, $idMon, $idNV, $soLuong, $dongia, $thanhTien, $ghiChu) {
        $sql = "INSERT INTO chi_tiet_don (idDonHang, idMon, idNV, SoLuong, DonGia, ThanhTien, GhiChu)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $kq = $this->db->prepare($sql);
        $kq->bind_param("iiiidds", $idDonHang, $idMon, $idNV, $soLuong, $dongia, $thanhTien, $ghiChu);
        $kq->execute();
        $kq->close();
    }

    // ================== CẬP NHẬT TRẠNG THÁI BÀN ==================
    public function updateTrangThaiBan($idBan, $trangThai) {
        $sql = "UPDATE ban_an SET TrangThai = ? WHERE idBan = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $trangThai, $idBan);
        $stmt->execute();
        $stmt->close();
    }

    // Xóa đơn hàng và chi tiết đơn theo id bàn
public function xoaDonHangTheoBan($idBan) {
    // Lấy danh sách idDonHang
    $stmt = $this->db->prepare("SELECT idDonHang FROM don_hang WHERE idBan = ?");
    $stmt->bind_param("i", $idBan);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $idDonHang = $row['idDonHang'];
        $delCT = $this->db->prepare("DELETE FROM chi_tiet_don WHERE idDonHang = ?");
        $delCT->bind_param("i", $idDonHang);
        $delCT->execute();
        $delCT->close();
    }
    $stmt->close();

    // Xóa đơn hàng chính
    $delDH = $this->db->prepare("DELETE FROM don_hang WHERE idBan = ?");
    $delDH->bind_param("i", $idBan);
    $delDH->execute();
    $delDH->close();
}
public function setDonHangHoanThanh($tableId) {
    $sql = "UPDATE don_hang SET TrangThai = 1 WHERE idBan = ? AND TrangThai = 0";
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
}
?>
