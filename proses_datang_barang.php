<?php
session_start();
include 'config.php';

$tanggal = $_POST['tanggal'];
$no_tlt = $_POST['no_tlt'];
$no_sj = $_POST['no_sj'];
$pengirim = $_POST['pengirim'];
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$bruto = $_POST['bruto'];
$promo_berlaku = $_POST['promo_berlaku'];
$lokasi = $_POST['lokasi'];
$ukuran_39 = $_POST['ukuran_39'];
$ukuran_40 = $_POST['ukuran_40'];
$ukuran_41 = $_POST['ukuran_41'];
$ukuran_42 = $_POST['ukuran_42'];
$ukuran_43 = $_POST['ukuran_43'];
$ukuran_44 = $_POST['ukuran_44'];
$ukuran_45 = $_POST['ukuran_45'];
$keterangan = $_POST['keterangan'];

$sql = "INSERT INTO arrivals (tanggal, no_tlt, no_sj, pengirim, kode_barang, ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssss", $tanggal, $no_tlt, $no_sj, $pengirim, $kode_barang, $ukuran_39, $ukuran_40, $ukuran_41, $ukuran_42, $ukuran_43, $ukuran_44, $ukuran_45, $keterangan);
$stmt->execute();

$sql = "SELECT * FROM stocks WHERE kode_barang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode_barang);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $sql = "UPDATE stocks SET ukuran_39 = ukuran_39 + ?, ukuran_40 = ukuran_40 + ?, ukuran_41 = ukuran_41 + ?, ukuran_42 = ukuran_42 + ?, ukuran_43 = ukuran_43 + ?, ukuran_44 = ukuran_44 + ?, ukuran_45 = ukuran_45 + ?, lokasi = ? WHERE kode_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $ukuran_39, $ukuran_40, $ukuran_41, $ukuran_42, $ukuran_43, $ukuran_44, $ukuran_45, $lokasi, $kode_barang);
    $stmt->execute();
} else {
    $netto = $bruto;
    if (strpos($promo_berlaku, '%') !== false) {
        $discount = rtrim($promo_berlaku, '%');
        $netto = $bruto - ($bruto * $discount / 100);
    } elseif (strpos($promo_berlaku, 'SP') === 0) {
        $netto = (int)substr($promo_berlaku, 2);
    }

    $sql = "INSERT INTO stocks (kode_barang, nama_barang, bruto, promo_berlaku, netto, ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45, lokasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $kode_barang, $nama_barang, $bruto, $promo_berlaku, $netto, $ukuran_39, $ukuran_40, $ukuran_41, $ukuran_42, $ukuran_43, $ukuran_44, $ukuran_45, $lokasi);
    $stmt->execute();
}

$conn->close();

header('Location: stok.php');
exit();
?>
