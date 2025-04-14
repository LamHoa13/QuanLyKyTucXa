<?php
// Kết nối CSDL
$mysqli = new mysqli("localhost", "root", "", "quanlykytucxa");
if ($mysqli->connect_errno) {
    echo "Kết nối MySQL thất bại: " . $mysqli->connect_error;
    exit();
}

// Xử lý form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $masv = trim($_POST['masv'] ?? '');
    $hoten = trim($_POST['hoten'] ?? '');
    $quequan = trim($_POST['quequan'] ?? '');
    $sdt = trim($_POST['sdt'] ?? '');
    $chinhsach = isset($_POST['chinhsach']) && $_POST['chinhsach'] === '1' ? 1 : 0;




    // Cắt bớt số điện thoại nếu quá 10 số
    $sdt = substr($sdt, 0, 10);

    if ($action === 'add') {
        // Kiểm tra mã sinh viên trùng
        $check_masv = $mysqli->prepare("SELECT * FROM sinhvien WHERE masv = ?");
        $check_masv->bind_param("s", $masv);
        $check_masv->execute();
        $result_masv = $check_masv->get_result();
        if ($result_masv->num_rows > 0) {
            echo "<script>alert('Mã sinh viên đã tồn tại!'); window.history.back();</script>";
            exit();
        }
        $check_masv->close();

        // Kiểm tra SĐT trùng
        $check = $mysqli->prepare("SELECT * FROM sinhvien WHERE sdt = ?");
        $check->bind_param("s", $sdt);
        $check->execute();
        $check_result = $check->get_result();
        if ($check_result->num_rows > 0) {
            echo "<script>alert('Số điện thoại đã tồn tại!'); window.history.back();</script>";
            exit();
        }
        $check->close();

        // Thêm sinh viên
        $stmt = $mysqli->prepare("INSERT INTO sinhvien (masv, hoten, quequan, sdt, chinhsach) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $masv, $hoten, $quequan, $sdt, $chinhsach);
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'edit') {
        // Kiểm tra nếu sửa SĐT mà trùng với người khác
        $check = $mysqli->prepare("SELECT * FROM sinhvien WHERE sdt = ? AND masv != ?");
        $check->bind_param("ss", $sdt, $masv);
        $check->execute();
        $check_result = $check->get_result();
        if ($check_result->num_rows > 0) {
            echo "<script>alert('Số điện thoại đã được sử dụng bởi sinh viên khác!'); window.history.back();</script>";
            exit();
        }
        $check->close();

        // Cập nhật thông tin
        $stmt = $mysqli->prepare("UPDATE sinhvien SET hoten=?, quequan=?, sdt=?, chinhsach=? WHERE masv=?");
        $stmt->bind_param("sssss", $hoten, $quequan, $sdt, $chinhsach, $masv);
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'delete') {
        // Xóa 1 sinh viên
        $stmt = $mysqli->prepare("DELETE FROM sinhvien WHERE masv = ?");
        $stmt->bind_param("s", $masv);
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'delete-multi') {
        // Xóa nhiều sinh viên
        if (!empty($_POST['selected']) && is_array($_POST['selected'])) {
            $placeholders = implode(',', array_fill(0, count($_POST['selected']), '?'));
            $types = str_repeat('s', count($_POST['selected']));
            $stmt = $mysqli->prepare("DELETE FROM sinhvien WHERE masv IN ($placeholders)");
            $stmt->bind_param($types, ...$_POST['selected']);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Tránh submit lại, quay về welcome
    header("Location: Welcome.php");
    exit();
}

// Lấy danh sách sinh viên để hiển thị
$result = $mysqli->query("SELECT * FROM sinhvien");
?>
