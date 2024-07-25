<?php
session_start();
include 'config.php';

$kode_barang_query = "SELECT DISTINCT kode_barang FROM stocks";
$kode_barang_result = $conn->query($kode_barang_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $no_tlt = $_POST['no_tlt'];
    $no_sj = $_POST['no_sj'];
    $tujuan = $_POST['tujuan'];
    $kode_barang = $_POST['kode_barang'];
    $ukuran_39 = $_POST['ukuran_39'];
    $ukuran_40 = $_POST['ukuran_40'];
    $ukuran_41 = $_POST['ukuran_41'];
    $ukuran_42 = $_POST['ukuran_42'];
    $ukuran_43 = $_POST['ukuran_43'];
    $ukuran_44 = $_POST['ukuran_44'];
    $ukuran_45 = $_POST['ukuran_45'];
    $keterangan = $_POST['keterangan'];

    $error_message = '';
    if ($ukuran_39 < 0) $error_message .= "Ukuran 39 tidak boleh negatif. ";
    if ($ukuran_40 < 0) $error_message .= "Ukuran 40 tidak boleh negatif. ";
    if ($ukuran_41 < 0) $error_message .= "Ukuran 41 tidak boleh negatif. ";
    if ($ukuran_42 < 0) $error_message .= "Ukuran 42 tidak boleh negatif. ";
    if ($ukuran_43 < 0) $error_message .= "Ukuran 43 tidak boleh negatif. ";
    if ($ukuran_44 < 0) $error_message .= "Ukuran 44 tidak boleh negatif. ";
    if ($ukuran_45 < 0) $error_message .= "Ukuran 45 tidak boleh negatif. ";

    if ($error_message) {
        echo $error_message;
        exit();
    }

    $stok_query = "SELECT ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45 FROM stocks WHERE kode_barang = ?";
    $stok_stmt = $conn->prepare($stok_query);
    $stok_stmt->bind_param('s', $kode_barang);
    $stok_stmt->execute();
    $stok_result = $stok_stmt->get_result();
    $stok = $stok_result->fetch_assoc();

    if ($ukuran_39 > $stok['ukuran_39']) $error_message .= "Ukuran 39 melebihi stok. ";
    if ($ukuran_40 > $stok['ukuran_40']) $error_message .= "Ukuran 40 melebihi stok. ";
    if ($ukuran_41 > $stok['ukuran_41']) $error_message .= "Ukuran 41 melebihi stok. ";
    if ($ukuran_42 > $stok['ukuran_42']) $error_message .= "Ukuran 42 melebihi stok. ";
    if ($ukuran_43 > $stok['ukuran_43']) $error_message .= "Ukuran 43 melebihi stok. ";
    if ($ukuran_44 > $stok['ukuran_44']) $error_message .= "Ukuran 44 melebihi stok. ";
    if ($ukuran_45 > $stok['ukuran_45']) $error_message .= "Ukuran 45 melebihi stok. ";

    if ($error_message) {
        echo $error_message;
        exit();
    }

    $sql = "INSERT INTO retur_rolling (tanggal, no_tlt, no_sj, tujuan, kode_barang, ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45, keterangan) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param('sssssssssssss', $tanggal, $no_tlt, $no_sj, $tujuan, $kode_barang, $ukuran_39, $ukuran_40, $ukuran_41, $ukuran_42, $ukuran_43, $ukuran_44, $ukuran_45, $keterangan);

    if ($stmt->execute()) {
        $update_sql = "UPDATE stocks SET 
            ukuran_39 = ukuran_39 - ?, 
            ukuran_40 = ukuran_40 - ?, 
            ukuran_41 = ukuran_41 - ?, 
            ukuran_42 = ukuran_42 - ?, 
            ukuran_43 = ukuran_43 - ?, 
            ukuran_44 = ukuran_44 - ?, 
            ukuran_45 = ukuran_45 - ? 
            WHERE kode_barang = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param('iiiiiiis', $ukuran_39, $ukuran_40, $ukuran_41, $ukuran_42, $ukuran_43, $ukuran_44, $ukuran_45, $kode_barang);

        if ($update_stmt->execute()) {
            $check_sql = "SELECT ukuran_39, ukuran_40, ukuran_41, ukuran_42, ukuran_43, ukuran_44, ukuran_45 FROM stocks WHERE kode_barang = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param('s', $kode_barang);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $updated_stok = $check_result->fetch_assoc();

            if (
                $updated_stok['ukuran_39'] == 0 &&
                $updated_stok['ukuran_40'] == 0 &&
                $updated_stok['ukuran_41'] == 0 &&
                $updated_stok['ukuran_42'] == 0 &&
                $updated_stok['ukuran_43'] == 0 &&
                $updated_stok['ukuran_44'] == 0 &&
                $updated_stok['ukuran_45'] == 0
            ) {
                $delete_sql = "DELETE FROM stocks WHERE kode_barang = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param('s', $kode_barang);
                $delete_stmt->execute();
                $delete_stmt->close();
            }

            $check_stmt->close();
            echo "Stok berhasil diperbarui.";
        } else {
            echo "Gagal memperbarui stok: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Retur Rolling Barang</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kode_barang').select2();

            $('#kode_barang').change(function() {
                var kodeBarang = $(this).val();
                if (kodeBarang) {
                    $.ajax({
                        url: 'get_ukuran.php',
                        type: 'POST',
                        data: { kode_barang: kodeBarang },
                        dataType: 'json',
                        success: function(data) {
                            $('#ukuran_39').val(data.ukuran_39);
                            $('#ukuran_40').val(data.ukuran_40);
                            $('#ukuran_41').val(data.ukuran_41);
                            $('#ukuran_42').val(data.ukuran_42);
                            $('#ukuran_43').val(data.ukuran_43);
                            $('#ukuran_44').val(data.ukuran_44);
                            $('#ukuran_45').val(data.ukuran_45);
                        }
                    });
                } else {
                    $('#ukuran_39').val('0');
                    $('#ukuran_40').val('0');
                    $('#ukuran_41').val('0');
                    $('#ukuran_42').val('0');
                    $('#ukuran_43').val('0');
                    $('#ukuran_44').val('0');
                    $('#ukuran_45').val('0');
                }
            });
        });
    </script>
</head>
<body>
    <h1>Tambah Retur Rolling Barang</h1>
    <form action="" method="POST">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required><br>

        <label for="no_tlt">No TLT:</label>
        <input type="text" id="no_tlt" name="no_tlt" required><br>

        <label for="no_sj">No SJ:</label>
        <input type="text" id="no_sj" name="no_sj" required><br>

        <label for="tujuan">Tujuan:</label>
        <input type="text" id="tujuan" name="tujuan"><br>

        <label for="kode_barang">Kode Barang:</label>
        <select id="kode_barang" name="kode_barang" required>
            <option value="">Pilih Kode Barang</option>
            <?php while ($row = $kode_barang_result->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['kode_barang']); ?>"><?php echo htmlspecialchars($row['kode_barang']); ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="ukuran_39">Ukuran 39:</label>
        <input type="number" id="ukuran_39" name="ukuran_39" value="0" min="0"><br>

        <label for="ukuran_40">Ukuran 40:</label>
        <input type="number" id="ukuran_40" name="ukuran_40" value="0" min="0"><br>

        <label for="ukuran_41">Ukuran 41:</label>
        <input type="number" id="ukuran_41" name="ukuran_41" value="0" min="0"><br>

        <label for="ukuran_42">Ukuran 42:</label>
        <input type="number" id="ukuran_42" name="ukuran_42" value="0" min="0"><br>

        <label for="ukuran_43">Ukuran 43:</label>
        <input type="number" id="ukuran_43" name="ukuran_43" value="0" min="0"><br>

        <label for="ukuran_44">Ukuran 44:</label>
        <input type="number" id="ukuran_44" name="ukuran_44" value="0" min="0"><br>

        <label for="ukuran_45">Ukuran 45:</label>
        <input type="number" id="ukuran_45" name="ukuran_45" value="0" min="0"><br>

        <label for="keterangan">Keterangan:</label>
        <textarea id="keterangan" name="keterangan"></textarea><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
