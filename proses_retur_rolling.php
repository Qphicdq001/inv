<?php
session_start();
include 'config.php';

$tanggal = $_POST['tanggal'];
$no_tlt = $_POST['no_tlt'];
$no_sj = $_POST['no_sj'];
$tujuan = $_POST['tujuan'];
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$ukuran_39 = $_POST['ukuran_39'];
$ukuran_40 = $_POST['ukuran_40'];
$ukuran_41 = $_POST['ukuran_41'];
$ukuran_42 = $_POST['ukuran_42'];
$ukuran_43 = $_POST['ukuran_43'];
$ukuran_44 = $_POST['ukuran_44'];
$ukuran_45 = $_POST['ukuran_45'];
$keterangan = $_POST['keterangan'];

$sql = "INSERT INTO retur_rolling (tanggal, no_tlt, no_sj, tujuan, kode_barang, ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssss", $tanggal, $no_tlt, $no_sj, $tujuan, $kode_barang, $ukuran_39, $ukuran_40, $ukuran_41, $ukuran_42, $ukuran_43, $ukuran_44, $ukuran_45, $keterangan);

if ($stmt->execute()) {
    $sql = "UPDATE stocks SET ukuran_39 = ukuran_39 - ?, ukuran_40 = ukuran_40 - ?, ukuran_41 = ukuran_41 - ?, ukuran_42 = ukuran_42 - ?, ukuran_43 = ukuran_43 - ?, ukuran_44 = ukuran_44 - ?, ukuran_45 = ukuran_45 - ? WHERE kode_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiiiis", $ukuran_39, $ukuran_40, $ukuran_41, $ukuran_42, $ukuran_43, $ukuran_44, $ukuran_45, $kode_barang);

    if ($stmt->execute()) {
        echo "Stok berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui stok: " . $stmt->error;
    }
} else {
    echo "Gagal menyimpan data retur rolling: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Location: stok.php');
exit();
?>
