<?php
$mysqli = new mysqli("localhost", "root", "", "quanlykytucxa");
if ($mysqli->connect_errno) {
    echo "Kết nối MySQL thất bại: " . $mysqli->connect_error;
    exit();
}

// Xử lý thêm, cập nhật và xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maphong = $_POST['maphong'] ?? '';
    $loaiphong = $_POST['loaiphong'] ?? '';
    $succhua = $_POST['succhua'] ?? 0;
    $soluong_hientai = $_POST['soluong_hientai'] ?? 0;
    $trangthai = $_POST['trangthai'] ?? '';
    $action = $_POST['action_room'] ?? '';

    if ($action === 'add' && $maphong && $loaiphong) {
        $stmt = $mysqli->prepare("INSERT INTO phong (maphong, loaiphong, succhua, soluong_hientai, trangthai) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiis", $maphong, $loaiphong, $succhua, $soluong_hientai, $trangthai);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'edit' && $maphong) {
        $stmt = $mysqli->prepare("UPDATE phong SET loaiphong=?, succhua=?, soluong_hientai=?, trangthai=? WHERE maphong=?");
        $stmt->bind_param("siiss", $loaiphong, $succhua, $soluong_hientai, $trangthai, $maphong);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete' && $maphong) {
        $stmt = $mysqli->prepare("DELETE FROM phong WHERE maphong=?");
        $stmt->bind_param("s", $maphong);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: Welcome.php!@#");
    exit();
}

// Lấy danh sách phòng
$result_phong = $mysqli->query("SELECT * FROM phong");
?>
