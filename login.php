<?php
session_start();
header('Content-Type: application/json');
include("ketnoidb.php");
$db = new KETNOI();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $nv = $db->check_login($username, $password);
    if($nv !== false && is_array($nv)){
        $_SESSION['HoVaten'] = $nv['HoVaten'];
        $_SESSION['Username'] = $nv['Username'];
        $_SESSION['idNV'] = $nv['idNV'];
        echo json_encode(['success'=>true]);
        exit;
    }else{
        echo json_encode(['success'=>false,'message'=>'Đăng nhập sai']);
        exit;
    }
}

// Kiểm tra session khi frontend load admin
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_SESSION['Username'])){
        echo json_encode([
            'logged_in'=>true,
            'HoVaten'=>$_SESSION['HoVaten'],
            'Username'=>$_SESSION['Username']
        ]);
    }else{
        echo json_encode(['logged_in'=>false]);
    }
}
