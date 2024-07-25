<?php
include 'config.php';

if (isset($_POST['kode_barang'])) {
    $kode_barang = $_POST['kode_barang'];
    
    $sql = "SELECT ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45 FROM stocks WHERE kode_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $kode_barang);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode([
            'ukuran_39' => '0',
            'ukuran_40' => '0',
            'ukuran_41' => '0',
            'ukuran_42' => '0',
            'ukuran_43' => '0',
            'ukuran_44' => '0',
            'ukuran_45' => '0'
        ]);
    }
}

$conn->close();
?>
