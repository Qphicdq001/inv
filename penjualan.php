<?php
session_start();
include 'config.php';


$sql = "SELECT * FROM penjualan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .button-container {
            margin-bottom: 20px;
        }
        .button-container button {
            padding: 10px 15px;
            margin-right: 10px;
            cursor: pointer;
        }
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
            table = document.getElementById("salesTable");
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
    <h1>Daftar Penjualan</h1>
    <div class="button-container">
        <button onclick="window.location.href='datang_barang.php'">Datang Barang</button>
        <button onclick="window.location.href='retur_rolling_barang.php'">Retur Rolling</button>
        <button onclick="window.location.href='stock.php'">Stock</button>
        <button onclick="window.location.href='tambah_penjualan.php'">Tambah Penjualan</button>
    </div>
    
    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari berdasarkan artikel, nama artikel, atau lokasi">
    </div>
    <table id="salesTable">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Bon</th>
                <th>Kode Barang</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Netto</th>
                <th>Promo Berlaku</th>
                <th>Kategori</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_bon']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kode_barang']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['size']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['qty']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['netto']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['promo_berlaku']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                    echo "<td><button onclick=\"window.location.href='update_penjualan.php?id=" . $row['id'] . "'\">Update</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Tidak ada data penjualan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
