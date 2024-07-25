<?php
session_start();
include 'config.php';


$sql = "SELECT * FROM arrivals ORDER BY no_tlt, no_sj";
$result = $conn->query($sql);


$arrivals = [];
while ($row = $result->fetch_assoc()) {
    $key = $row['no_tlt'] . '-' . $row['no_sj'];
    if (!isset($arrivals[$key])) {
        $arrivals[$key] = [
            'tanggal' => $row['tanggal'],
            'no_tlt' => $row['no_tlt'],
            'no_sj' => $row['no_sj'],
            'pengirim' => $row['pengirim'],
            'items' => []
        ];
    }
    $arrivals[$key]['items'][] = $row;
}


foreach ($arrivals as $key => $arrival) {
    $total_qty = 0;
    foreach ($arrival['items'] as $item) {
        $total_qty += $item['ukuran_39'] + $item['ukuran_40'] + $item['ukuran_41'] + $item['ukuran_42'] + $item['ukuran_43'] + $item['ukuran_44'] + $item['ukuran_45'];
    }
    $arrivals[$key]['total_qty'] = $total_qty;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Datang Barang</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Data Datang Barang</h1>
    <button onclick="window.location.href='tambah_datang_barang.php'">Tambah Datang Barang</button>
    <div class="arrival-container">
        <?php
        if (count($arrivals) > 0) {
            foreach ($arrivals as $arrival) {
                echo "<div class='arrival-item'>";
                echo "<h2>No TLT: " . $arrival['no_tlt'] . " | No SJ: " . $arrival['no_sj'] . "</h2>";
                echo "<p>Tanggal: " . $arrival['tanggal'] . "</p>";
                echo "<p>Pengirim: " . $arrival['pengirim'] . "</p>";
                echo "<p>Total Qty: " . $arrival['total_qty'] . "</p>";
                echo "<ul>";
                foreach ($arrival['items'] as $item) {
                    $qty = $item['ukuran_39'] + $item['ukuran_40'] + $item['ukuran_41'] + $item['ukuran_42'] + $item['ukuran_43'] + $item['ukuran_44'] + $item['ukuran_45'];
                    echo "<li>";
                    echo "Kode Barang: " . $item['kode_barang'] . " | Qty: " . $qty . " | Ukuran 39: " . $item['ukuran_39'] . ", 40: " . $item['ukuran_40'] . ", 41: " . $item['ukuran_41'] . ", 42: " . $item['ukuran_42'] . ", 43: " . $item['ukuran_43'] . ", 44: " . $item['ukuran_44'] . ", 45: " . $item['ukuran_45'];
                    echo "<br>Keterangan: " . $item['keterangan'];
                    echo "</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada data datang barang.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
