<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM stocks WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $bruto = $_POST['bruto'];
    $promo_berlaku = $_POST['promo_berlaku'];
    $lokasi = $_POST['lokasi'];

    if (strpos($promo_berlaku, '%') !== false) {
        $promo_value = rtrim($promo_berlaku, '%');
        $netto = $bruto - ($bruto * $promo_value / 100);
    } elseif (strpos($promo_berlaku, 'SP') !== false) {
        $promo_value = str_replace('SP', '', $promo_berlaku);
        $netto = $promo_value;
    } else {
        $netto = $bruto;
    }

    $sql = "UPDATE stocks SET bruto = '$bruto', promo_berlaku = '$promo_berlaku', netto = '$netto', lokasi = '$lokasi' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: stok.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stok</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Update Stok Barang</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="bruto">Bruto:</label>
        <input type="number" name="bruto" value="<?php echo $row['bruto']; ?>" required>
        <label for="promo_berlaku">Promo Berlaku:</label>
        <input type="text" name="promo_berlaku" value="<?php echo $row['promo_berlaku']; ?>" required>
        <label for="lokasi">Lokasi:</label>
        <input type="text" name="lokasi" value="<?php echo $row['lokasi']; ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
