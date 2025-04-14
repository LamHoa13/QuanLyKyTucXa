<?php
// Kết nối CSDL
$mysqli = new mysqli("localhost", "root", "", "quanlykytucxa");
if ($mysqli->connect_errno) {
    echo "Kết nối MySQL thất bại: " . $mysqli->connect_error;
    exit();
}

// Xử lý form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_thanhtoan'])) {
    $action = $_POST['action_thanhtoan'];
    $mahd = strtoupper(trim($_POST['mahd'] ?? ''));
    $ngaylap = trim($_POST['ngaylap'] ?? '');
    $mssv = trim($_POST['mssv'] ?? '');
    $noidung = trim($_POST['noidung'] ?? '');
    $sotien = (int) trim($_POST['sotien'] ?? '');

    if ($action === 'add') {
        // Kiểm tra mã hóa đơn trùng
        $check_mahd = $mysqli->prepare("SELECT * FROM thanhtoan WHERE mahd = ?");
        $check_mahd->bind_param("s", $mahd);
        $check_mahd->execute();
        $result_mahd = $check_mahd->get_result();
        if ($result_mahd->num_rows > 0) {
            echo "<script>alert('Mã hóa đơn đã tồn tại!!'); window.history.back();</script>";
            exit();
        }
        $check_mahd->close();

        // Thêm sinh viên
        $hd = $mysqli->prepare("INSERT INTO thanhtoan (mahd, ngaylap, mssv, noidung, sotien) VALUES (?, ?, ?, ?, ?)");
        $hd->bind_param("ssssi", $mahd, $ngaylap, $mssv, $noidung, $sotien);
        $hd->execute();
        $hd->close();
        if ($mysqli->error) {
            echo "Error: " . $mysqli->error;
        }

    } 

    // Tránh submit lại, quay về welcome
    header("Location: welcome.php?view=thanh-toan&success=1");
    exit();
}

// Lấy danh sách sinh viên để hiển thị
$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $stmt = $mysqli->prepare("SELECT * FROM thanhtoan WHERE mssv LIKE ? OR mahd LIKE ?");
    $like = "%" . $search . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $ketqua = $stmt->get_result();
    $stmt->close();
} else {
    $ketqua = $mysqli->query("SELECT * FROM thanhtoan");
}
?>
