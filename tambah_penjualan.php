<?php
session_start();
include 'config.php';

$sql = "SELECT kode_barang FROM stocks";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $no_bon = $_POST['no_bon'];
    $kode_barang = $_POST['kode_barang'];
    $size = $_POST['size'];
    $qty = $_POST['qty'];
    $netto = $_POST['netto'];
    $promo_berlaku = $_POST['promo_berlaku'];
    $kategori = $_POST['kategori'];

    $sql = "INSERT INTO penjualan (tanggal, no_bon, kode_barang, size, qty, netto, promo_berlaku, kategori) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssiiiss', $tanggal, $no_bon, $kode_barang, $size, $qty, $netto, $promo_berlaku, $kategori);

    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penjualan</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function fetchSizesAndDetails() {
            var kodeBarang = document.getElementById("kode_barang").value;
            var sizeSelect = document.getElementById("size");
            var nettoInput = document.getElementById("netto");
            var promoInput = document.getElementById("promo_berlaku");

            sizeSelect.innerHTML = '<option value="">Pilih Ukuran</option>';
            document.getElementById("qty").innerHTML = '<option value="">Pilih Qty</option>';

            if (kodeBarang) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "get_sizes.php?kode_barang=" + kodeBarang, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var data = JSON.parse(xhr.responseText);
                        var sizes = data.sizes;
                        nettoInput.value = data.netto;
                        promoInput.value = data.promo_berlaku;
                        sizes.forEach(function (size) {
                            var option = document.createElement("option");
                            option.value = size.size;
                            option.text = size.size + " (Qty: " + size.qty + ")";
                            option.dataset.qty = size.qty;
                            sizeSelect.add(option);
                        });
                    }
                };
                xhr.send();
            }
        }

        function fetchQty() {
            var sizeSelect = document.getElementById("size");
            var selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
            var availableQty = selectedOption.dataset.qty;
            var qtySelect = document.getElementById("qty");

            qtySelect.innerHTML = '<option value="">Pilih Qty</option>';

            if (availableQty) {
                for (var i = 1; i <= availableQty; i++) {
                    var option = document.createElement("option");
                    option.value = i;
                    option.text = i;
                    qtySelect.add(option);
                }
            }
        }
    </script>
</head>
<body>
    <h1>Tambah Penjualan</h1>
    <form action="" method="POST">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required><br>

        <label for="no_bon">No Bon:</label>
        <input type="text" id="no_bon" name="no_bon" required><br>

        <label for="kode_barang">Kode Barang:</label>
        <select id="kode_barang" name="kode_barang" onchange="fetchSizesAndDetails()" required>
            <option value="">Pilih Kode Barang</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['kode_barang'] . "'>" . $row['kode_barang'] . "</option>";
                }
            } else {
                echo "<option value=''>Tidak ada data</option>";
            }
            ?>
        </select><br>

        <label for="size">Size:</label>
        <select id="size" name="size" onchange="fetchQty()" required>
            <option value="">Pilih Ukuran</option>
        </select><br>

        <label for="qty">Qty:</label>
        <select id="qty" name="qty" required>
            <option value="">Pilih Qty</option>
        </select><br>

        <label for="netto">Netto:</label>
        <input type="number" step="0.01" id="netto" name="netto" required><br>

        <label for="promo_berlaku">Promo Berlaku:</label>
        <input type="text" id="promo_berlaku" name="promo_berlaku" required><br>

        <label for="kategori">Kategori:</label>
        <input type="text" id="kategori" name="kategori" required><br>

        <button type="submit">Tambah</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
