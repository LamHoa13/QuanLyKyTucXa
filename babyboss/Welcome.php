<?php
include("./sinhvien.php");
include("./phong.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phần mềm quản lý ký túc xá</title>
    <link rel="stylesheet" href="qlp.css">
    <link rel="stylesheet" href="qlsv.css">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        .container {
            display: flex;
            width: 100%;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .sidebar ul {
            list-style: none;
            width: 100%;
        }
        .sidebar ul li {
            padding: 12px;
            display: flex;
            align-items: center;
            cursor: pointer;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .sidebar ul li:hover {
            background-color: #34495e;
        }
        .content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #f4f6f8;
        }
        .top-menu {
            background-color: #d2daf0;
            padding: 15px;
            display: flex;
            justify-content: flex-start;
            gap: 20px;
            padding-left: 20px;
        }
        .top-menu span {
            cursor: pointer;
            font-weight: bold;
        }
        .main-content {
            padding: 20px; 
        }
        img{
            width: 60%;
            height: 70%;
        }
        .banner {
            width: 100%;
            height: calc(100vh - 120px);
            overflow: hidden;
        }
        .banner img {
            width: 100%;
            height: 95%;
            object-fit: cover;
            display: block;
        }
        .hidden {
            display: none !important;
        }
        .footer {
        background: linear-gradient(145deg, #67686a, #686a6c);
        padding: 20px;
        text-align: center;
        font-size: 20px;
        color: #ede0e0f8;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 100;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2>Danh Mục</h2>
            <ul>
                <li onclick="showContent('sinh-vien')">Quản Lý Sinh viên</li>
                <li onclick="showContent('phong')">Quản Lý Phòng</li>
                <li onclick="showContent('thanh-toan')">Quản Lý Tài Chính</li>
                <li onclick="confirmLogout()">Đăng xuất</li>
            </ul>
        </aside>
        <main class="content">
            <nav class="top-menu">
                <span>Hệ Thống</span>
                <span>Báo Cáo</span>
                <span>Tìm Kiếm</span>
                <span>Bảo Mật</span>
                <span>Giới Thiệu</span>
            </nav>
            <div class="main-content">
                <section id="default-view">
                    <div class="banner">
                        <img src="truong-dai-hoc-bac-lieu.jpg" alt="Banner">
                    </div>
                </section>
                <section id="sinh-vien" class="hidden">
                    <form method="post">
                        <div class="input">
                            <input type="text" name="masv" placeholder="Mã sinh viên" required>
                            <input type="text" name="hoten" placeholder="Họ tên" required>
                            <input type="text" name="quequan" placeholder="Quê quán" required>
                            <input type="text" name="sdt" placeholder="Số điện thoại" maxlength="10" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                            <select name="chinhsach" required>
                                <option value="0">Không</option>
                                <option value="1">Có</option>
                            </select>

                        </div>
                        <input type="hidden" id="actionInput" name="action" value="">
                        <div class="form-actions">
                            <button type="submit" name="action" value="add" class="add">Thêm</button>
                            <button type="submit" name="action" value="edit" class="edit">Cập Nhật</button>
                        </div>
                    </form>
                    <button class="btn" onclick="toggleStudentList()">Xem Danh Sách Sinh Viên</button>
                    <form method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa các sinh viên đã chọn không?')">
                        <input type="hidden" name="action" value="delete-multi">
                        <table id="studentTableContainer" style="display:none;">
                            <tr>
                                <th></th>
                                <th>Mã SV</th>
                                <th>Họ Tên</th>
                                <th>Quê Quán</th>
                                <th>SĐT</th>
                                <th>Chính Sách</th>
                            </tr>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><input type="checkbox" name="selected[]" value="<?= htmlspecialchars($row['masv']) ?>"></td>
                                <td><?= htmlspecialchars($row['masv']) ?></td>
                                <td><?= htmlspecialchars($row['hoten']) ?></td>
                                <td><?= htmlspecialchars($row['quequan']) ?></td>
                                <td><?= htmlspecialchars($row['sdt']) ?></td>
                                <td><?= ((int)$row['chinhsach'] === 1) ? 'Có' : 'Không' ?></td>

                            </tr>
                            <?php endwhile; ?>
                        </table>
                        <br>
                        <button type="submit" class="delete">Xóa </button>
                    </form>
                </section>
                <section id="phong" class="hidden" style="width: 100%;">
                    <h2 style="text-align: center;">Quản Lý Phòng</h2>
                    <!-- Form thêm mới / cập nhật -->
                    <div style="padding: 20px; background-color: #f9fbfc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 90%; margin: auto; margin-top: 15px;">
                        <form method="POST" action="phong.php" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-between;">
                            <div style="flex: 1 1 45%;">
                                <label>Mã phòng:</label>
                                <input type="text" name="maphong" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                            </div>

                            <div style="flex: 1 1 45%;">
                                <label>Loại phòng:</label>
                                <input type="text" name="loaiphong" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                            </div>

                            <div style="flex: 1 1 45%;">
                                <label>Sức chứa:</label>
                                <input type="number" name="succhua" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                            </div>

                            <div style="flex: 1 1 45%;">
                                <label>Số lượng hiện tại:</label>
                                <input type="number" name="soluong_hientai" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                            </div>

                            <div style="flex: 1 1 45%;">
                                <label>Trạng thái:</label>
                                <input type="text" name="trangthai" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                            </div>

                            <div style="flex: 1 1 100%; text-align: right;">
                                <input type="hidden" name="action_room" value="add">
                                <button type="submit" style="padding: 10px 20px; background-color: #5cb85c; color: white; border: none; border-radius: 6px;">Lưu</button>
                            </div>
                        </form>
                    </div>

                    <!-- Nút xem danh sách phòng -->
                    <button class="btn" onclick="toggleRoomList()" style="margin-top: 20px;">Xem Danh Sách Phòng</button>

                    <!-- Danh sách phòng -->
                    <div id="roomTableContainerPhong" style="display: none; margin-top: 20px; overflow-x: auto; padding: 0; margin: 0;">
                    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                            <thead style="background-color: #f2f2f2;">
                                <tr>
                                    <th>Chọn</th>
                                    <th>Mã phòng</th>
                                    <th>Loại phòng</th>
                                    <th>Sức chứa</th>
                                    <th>Số lượng hiện tại</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_phong->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <input type="radio" name="selected_room" value="<?= htmlspecialchars(json_encode($row)) ?>">
                                    </td>
                                    <td><?= htmlspecialchars($row['maphong']) ?></td>
                                    <td><?= htmlspecialchars($row['loaiphong']) ?></td>
                                    <td><?= (int)$row['succhua'] ?></td>
                                    <td><?= (int)$row['soluong_hientai'] ?></td>
                                    <td><?= htmlspecialchars($row['trangthai']) ?></td>
                                    <td>
                                        <button type="button" onclick='selectAndEdit(<?= json_encode($row) ?>)' style="background-color: gold; color: black; padding: 5px 10px; border-radius: 4px;">Cập nhật</button>
                                        <button type="button" onclick='selectAndDelete("<?= $row['maphong'] ?>")'
                                            style="background-color: red; color: white; padding: 5px 10px; border-radius: 4px; margin-left: 5px;">
                                            Xoá
                                        </button>
                                        <button type="button" onclick='selectAndCheck(<?= json_encode($row) ?>)' style="background-color: #5bc0de; color: white; padding: 5px 10px; border-radius: 4px; margin-left: 5px;">Kiểm tra</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="thanh-toan" class="hidden">
                </section>
            </div>
        </main>
    </div>
    <script>
        
    function setRoomAction(action) {
        document.getElementById('action_room_input').value = action;
    }

    function toggleStudentList() {
        let tableContainer = document.getElementById("studentTableContainer");
        tableContainer.style.display = (tableContainer.style.display === "none") ? "table" : "none";
    }

    function toggleRoomList() {
        let tableContainer = document.getElementById("roomTableContainerPhong");
        tableContainer.style.display = (tableContainer.style.display === "none") ? "table" : "none";
    }
    function selectRadioByMaphong(maphong) {
    const radios = document.querySelectorAll('input[name="selected_room"]');
    radios.forEach(radio => {
        const data = JSON.parse(radio.value);
        if (data.maphong === maphong) {
            radio.checked = true;
        }
    });
}

// Cập nhật: đổ dữ liệu vào form
function selectAndEdit(data) {
    selectRadioByMaphong(data.maphong);

    document.querySelector('input[name="maphong"]').value = data.maphong;
    document.querySelector('input[name="loaiphong"]').value = data.loaiphong;
    document.querySelector('input[name="succhua"]').value = data.succhua;
    document.querySelector('input[name="soluong_hientai"]').value = data.soluong_hientai;
    document.querySelector('input[name="trangthai"]').value = data.trangthai;

    document.querySelector('input[name="action_room"]').value = 'edit';
}

// Xoá
    function selectAndDelete(maphong) {
        if (confirm("Bạn có chắc chắn muốn xóa phòng " + maphong + " không?")) {
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "phong.php";

            var inputMaphong = document.createElement("input");
            inputMaphong.type = "hidden";
            inputMaphong.name = "maphong";
            inputMaphong.value = maphong;
            form.appendChild(inputMaphong);

            var inputAction = document.createElement("input");
            inputAction.type = "hidden";
            inputAction.name = "action_room";
            inputAction.value = "delete";
            form.appendChild(inputAction);

            document.body.appendChild(form);
            form.submit();
        }
    }


// Kiểm tra
    function selectAndCheck(data) {
        selectRadioByMaphong(data.maphong);
        alert(
            `🔍 Thông tin phòng:\n` +
            `• Mã phòng: ${data.maphong}\n` +
            `• Loại phòng: ${data.loaiphong}\n` +
            `• Sức chứa: ${data.succhua}\n` +
            `• Hiện tại: ${data.soluong_hientai}\n` +
            `• Trạng thái: ${data.trangthai}`
        );
    }


    function showContent(id) {
        const contentSections = document.querySelectorAll('.main-content > section');
        contentSections.forEach(section => section.classList.add('hidden'));
        const selectedSection = document.getElementById(id);
        if (selectedSection) {
            selectedSection.classList.remove('hidden');
        } else {
            document.getElementById('default-view').classList.remove('hidden');
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("#sinh-vien form");
        const actionInput = document.querySelector("#actionInput");
        let actionClicked = "";
        form.querySelectorAll("button[type='submit']").forEach(button => {
            button.addEventListener("click", function () {
                actionClicked = this.value;
                if (actionInput) {
                    actionInput.value = this.value;
                }
            });
        });
        form.addEventListener("submit", function () {
            setTimeout(function () {
                if (actionClicked === "add" || actionClicked === "edit") {
                    const actionText = actionClicked === "add" ? "thêm" : "sửa";
                    const confirmMore = confirm(`Đã ${actionText} thành công! Bạn có muốn tiếp tục ${actionText} nữa không?`);
                    if (!confirmMore) {
                        window.location.href = "welcome.php";
                    }
                }
            }, 300);
        });
    });
    </script>
    <footer>
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <div class="contact-info">
                    <p>
                        <i class="fas fa-map-marker-alt"></i>
                        Địa chỉ: 178 Võ Thị Sáu, TP. Bạc Liêu
                    </p>
                    <p>
                        <i class="fas fa-phone"></i>
                        ĐT: 0291.3821 107
                    </p>
                    <p>
                        <i class="fas fa-envelope"></i>
                        tuyensinh@blu.edu.vn
                    </p>
                </div>
            </div>

            <div class="footer-section">
                <h3>Liên kết nhanh</h3>
                <ul class="footer-links">
                    <li><a href="#home">Trang chủ</a></li>
                    <li><a href="#services">Dịch vụ</a></li>
                    <li><a href="#about">Về chúng tôi</a></li>
                    <li><a href="#contact">Liên hệ</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Theo dõi chúng tôi</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
               
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2024 QNP Events. Bảo lưu mọi quyền.</p>
            <p>Thiết kế bởi <a href="#" class="designer-link">QNP Team</a></p>
        </div>
    </div>
    </footer>
</body>
</html>