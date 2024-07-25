<?php
session_start();
include 'config.php';

$sql = "SELECT * FROM retur_rolling ORDER BY no_tlt, no_sj";
$result = $conn->query($sql);

$retur_rolling = [];
while ($row = $result->fetch_assoc()) {
    $key = $row['no_tlt'] . '-' . $row['no_sj'];
    if (!isset($retur_rolling[$key])) {
        $retur_rolling[$key] = [
            'tanggal' => $row['tanggal'],
            'no_tlt' => $row['no_tlt'],
            'no_sj' => $row['no_sj'],
            'tujuan' => $row['tujuan'],
            'items' => []
        ];
    }
    $retur_rolling[$key]['items'][] = $row;
}

foreach ($retur_rolling as $key => $return) {
    $total_qty = 0;
    foreach ($return['items'] as $item) {
        $total_qty += $item['ukuran_39'] + $item['ukuran_40'] + $item['ukuran_41'] + $item['ukuran_42'] + $item['ukuran_43'] + $item['ukuran_44'] + $item['ukuran_45'];
    }
    $retur_rolling[$key]['total_qty'] = $total_qty;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Retur Rolling Barang</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Data Retur Rolling Barang</h1>
    <button onclick="window.location.href='tambah_retur_rolling.php'">Tambah Retur Rolling Barang</button>
    <div class="arrival-container">
        <?php
        if (count($retur_rolling) > 0) {
            foreach ($retur_rolling as $return) {
                echo "<div class='arrival-item'>";
                echo "<h2>No TLT: " . htmlspecialchars($return['no_tlt']) . " | No SJ: " . htmlspecialchars($return['no_sj']) . "</h2>";
                echo "<p>Tanggal: " . htmlspecialchars($return['tanggal']) . "</p>";
                echo "<p>Tujuan: " . htmlspecialchars($return['tujuan']) . "</p>";
                echo "<p>Total Qty: " . htmlspecialchars($return['total_qty']) . "</p>";
                echo "<ul>";
                foreach ($return['items'] as $item) {
                    $qty = $item['ukuran_39'] + $item['ukuran_40'] + $item['ukuran_41'] + $item['ukuran_42'] + $item['ukuran_43'] + $item['ukuran_44'] + $item['ukuran_45'];
                    echo "<li>";
                    echo "Kode Barang: " . htmlspecialchars($item['kode_barang']) . " | Qty: " . htmlspecialchars($qty) . " | Ukuran 39: " . htmlspecialchars($item['ukuran_39']) . ", 40: " . htmlspecialchars($item['ukuran_40']) . ", 41: " . htmlspecialchars($item['ukuran_41']) . ", 42: " . htmlspecialchars($item['ukuran_42']) . ", 43: " . htmlspecialchars($item['ukuran_43']) . ", 44: " . htmlspecialchars($item['ukuran_44']) . ", 45: " . htmlspecialchars($item['ukuran_45']);
                    echo "<br>Keterangan: " . htmlspecialchars($item['keterangan']);
                    echo "</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada data retur rolling barang.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
