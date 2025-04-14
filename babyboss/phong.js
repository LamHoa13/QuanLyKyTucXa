 //phong
    function addRoom() {
                let table = document.getElementById("roomTable");
                let roomNumber = document.getElementById("roomNumber").value;
                let roomType = document.getElementById("roomType").value;
                let roomStatus = document.getElementById("roomStatus").value;

                if (roomNumber === "") {
                    alert("Vui lòng nhập số phòng");
                    return;
                }

                // Kiểm tra phòng đã tồn tại chưa
                let rows = table.getElementsByTagName("tr");
                for (let i = 0; i < rows.length; i++) {
                    let cells = rows[i].getElementsByTagName("td");
                    if (cells.length > 0 && cells[0].innerText === roomNumber) {
                        alert("Phòng đã tồn tại!");
                        return;
                    }
                }

                // Nếu chưa tồn tại thì thêm mới
                let row = table.insertRow();
                row.insertCell(0).innerText = roomNumber;
                row.insertCell(1).innerText = roomType;
                row.insertCell(2).innerText = roomStatus;

                // Reset form
                document.getElementById("roomNumber").value = "";
                document.getElementById("roomType").value = "Đơn";
                document.getElementById("roomStatus").value = "Trống";
            }

        function updateRoom() {
            let table = document.getElementById("roomTable");
            let roomNumber = document.getElementById("roomNumber").value;
            let roomType = document.getElementById("roomType").value;
            let roomStatus = document.getElementById("roomStatus").value;

            if (roomNumber === "") {
                alert("Vui lòng nhập số phòng để cập nhật.");
                return;
            }

            let rows = table.getElementsByTagName("tr");
            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName("td");
                if (cells.length > 0 && cells[0].innerText === roomNumber) {
                    // Thực hiện cập nhật trước
                    cells[1].innerText = roomType;
                    cells[2].innerText = roomStatus;

                    // Hỏi sau khi đã cập nhật
                    let confirmMore = confirm("Đã cập nhật thành công!\nBạn có muốn tiếp tục cập nhật phòng khác không?");
                    if (!confirmMore) {
                        // Xóa dữ liệu trong form
                        document.getElementById("roomNumber").value = "";
                        document.getElementById("roomType").value = "Đơn";
                        document.getElementById("roomStatus").value = "Trống";
                    }
                    return;
                }
            }

            alert("Phòng không tồn tại.");
        }
        function checkRoomInfo() {
            let roomNumber = document.getElementById("roomNumber").value;
            let table = document.getElementById("roomTable");
            let rows = table.getElementsByTagName("tr");
            
            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName("td");
                if (cells.length > 0 && cells[0].innerText === roomNumber) {
                    alert(`Phòng: ${cells[0].innerText}\nLoại: ${cells[1].innerText}\nTrạng thái: ${cells[2].innerText}`);
                    return;
                }
            }
            alert("Phòng không tồn tại");
        }
        //phong
        function toggleRoomList() {
            let roomSection = document.getElementById("phong");
            let tableContainer = document.getElementById("roomTableContainerPhong");
            if (roomSection && tableContainer) {
                tableContainer.style.display = (tableContainer.style.display === "none") ? "table" : "none";
            }
        }