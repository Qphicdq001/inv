<?php
session_start();
include 'config.php';

$sql = "SELECT * FROM stocks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Stok Barang</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("stocksTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none"; 
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <h1>Daftar Stok Barang</h1>
    <div class="button-container">
        <button onclick="window.location.href='datang_barang.php'">Datang Barang</button>
        <button onclick="window.location.href='retur_rolling_barang.php'">Retur Rolling</button>
        <button onclick="window.location.href='penjualan.php'">Penjualan</button>
    </div>
    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari berdasarkan artikel, nama artikel, atau lokasi">
    </div>
    <table id="stocksTable">
        <thead>
            <tr>
                <th>Artikel</th>
                <th>Nama Artikel</th>
                <th>Brutto</th>
                <th>Promo Berlaku</th>
                <th>Netto</th>
                <th>Lokasi</th>
                <th>Ukuran 39</th>
                <th>Ukuran 40</th>
                <th>Ukuran 41</th>
                <th>Ukuran 42</th>
                <th>Ukuran 43</th>
                <th>Ukuran 44</th>
                <th>Ukuran 45</th>
                <th>Qty</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'config.php';
            $sql = "SELECT * FROM stocks";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $total_qty = $row['ukuran_39'] + $row['ukuran_40'] + $row['ukuran_41'] + $row['ukuran_42'] + $row['ukuran_43'] + $row['ukuran_44'] + $row['ukuran_45'];
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['kode_barang']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['bruto']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['promo_berlaku']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['netto']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lokasi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran_39']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran_40']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran_41']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran_42']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran_43']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran_44']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran_45']) . "</td>";
                    echo "<td>" . htmlspecialchars($total_qty) . "</td>";
                    echo "<td><button onclick=\"window.location.href='update_stok.php?id=" . $row['id'] . "'\">Update</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='15'>Tidak ada data stok barang.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
