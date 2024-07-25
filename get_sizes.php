<?php
include 'config.php';

if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];

    
    $sql = "SELECT ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45, netto, promo_berlaku FROM stocks WHERE kode_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $kode_barang);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = array();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data['sizes'] = array();
        foreach ($row as $key => $value) {
            if (strpos($key, 'ukuran_') !== false && $value > 0) {
                $data['sizes'][] = array('size' => str_replace('ukuran_', '', $key), 'qty' => $value);
            }
        }
        $data['netto'] = $row['netto'];
        $data['promo_berlaku'] = $row['promo_berlaku'];
    }
    echo json_encode($data);
}
$conn->close();
?>
