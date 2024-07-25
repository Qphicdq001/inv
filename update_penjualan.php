<?php
session_start();
include 'config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM penjualan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $no_bon = $_POST['no_bon'];
    $kode_barang = $_POST['kode_barang'];
    $size = $_POST['size'];
    $qty = $_POST['qty'];
    $netto = $_POST['netto'];
    $promo_berlaku = $_POST['promo_berlaku'];
    $kategori = $_POST['kategori'];

    $sql = "UPDATE penjualan SET tanggal = ?, no_bon = ?, kode_barang = ?, size = ?, qty = ?, netto = ?, promo_berlaku = ?, kategori = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssiidssi', $tanggal, $no_bon, $kode_barang, $size, $qty, $netto, $promo_berlaku, $kategori, $id);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
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
    <title>Update Penjualan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Update Penjualan</h1>
    <form action="" method="POST">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($data['tanggal']); ?>" required><br>

        <label for="no_bon">No Bon:</label>
        <input type="text" id="no_bon" name="no_bon" value="<?php echo htmlspecialchars($data['no_bon']); ?>" required><br>

        <label for="kode_barang">Kode Barang:</label>
        <input type="text" id="kode_barang" name="kode_barang" value="<?php echo htmlspecialchars($data['kode_barang']); ?>" required><br>

        <label for="size">Size:</label>
        <input type="number" id="size" name="size" value="<?php echo htmlspecialchars($data['size']); ?>" required><br>

        <label for="qty">Qty:</label>
        <input type="number" id="qty" name="qty" value="<?php echo htmlspecialchars($data['qty']); ?>" required><br>

        <label for="netto">Netto:</label>
        <input type="number" step="0.01" id="netto" name="netto" value="<?php echo htmlspecialchars($data['netto']); ?>" required><br>

        <label for="promo_berlaku">Promo Berlaku:</label>
        <input type="text" id="promo_berlaku" name="promo_berlaku" value="<?php echo htmlspecialchars($data['promo_berlaku']); ?>" required><br>

        <label for="kategori">Kategori:</label>
        <input type="text" id="kategori" name="kategori" value="<?php echo htmlspecialchars($data['kategori']); ?>" required><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
