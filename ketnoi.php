<?php
class KETNOI {
    public $host ='sql310.infinityfree.com';
    public $user = 'if0_40548979';
    public $pass = '0902596241';
    public $dbname = 'if0_40548979_tiemtra';
    private $db;
    public function __construct() {
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname );
        if ($this->db->connect_error) {
            die('Kết nối thất bại: '. $this->db->connect_error);
        }
        $this->db->set_charset("utf8");
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

public function hienThiMonAn($idMon) {
    $sql = "SELECT idMon, TenMon, Size, Gia FROM mon_an WHERE idMon = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $idMon);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
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
