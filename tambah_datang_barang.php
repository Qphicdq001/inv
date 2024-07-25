<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Datang Barang</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Tambah Datang Barang</h1>
    <form action="proses_datang_barang.php" method="post">
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required><br>

        <label for="no_tlt">No TLT:</label>
        <input type="text" id="no_tlt" name="no_tlt" required><br>

        <label for="no_sj">No SJ:</label>
        <input type="text" id="no_sj" name="no_sj" required><br>

        <label for="pengirim">Pengirim:</label>
        <input type="text" id="pengirim" name="pengirim" required><br>

        <label for="kode_barang">Kode Barang:</label>
        <input type="text" id="kode_barang" name="kode_barang" required><br>

        <label for="nama_barang">Nama Barang:</label>
        <input type="text" id="nama_barang" name="nama_barang" required><br>

        <label for="bruto">Bruto:</label>
        <input type="number" id="bruto" name="bruto" step="0.01" required><br>

        <label for="promo_berlaku">Promo Berlaku:</label>
        <input type="text" id="promo_berlaku" name="promo_berlaku"><br>

        <label for="lokasi">Lokasi:</label>
        <input type="text" id="lokasi" name="lokasi" required><br>

        <label for="ukuran_39">Ukuran 39:</label>
        <input type="number" id="ukuran_39" name="ukuran_39" required><br>

        <label for="ukuran_40">Ukuran 40:</label>
        <input type="number" id="ukuran_40" name="ukuran_40" required><br>

        <label for="ukuran_41">Ukuran 41:</label>
        <input type="number" id="ukuran_41" name="ukuran_41" required><br>

        <label for="ukuran_42">Ukuran 42:</label>
        <input type="number" id="ukuran_42" name="ukuran_42" required><br>

        <label for="ukuran_43">Ukuran 43:</label>
        <input type="number" id="ukuran_43" name="ukuran_43" required><br>

        <label for="ukuran_44">Ukuran 44:</label>
        <input type="number" id="ukuran_44" name="ukuran_44" required><br>

        <label for="ukuran_45">Ukuran 45:</label>
        <input type="number" id="ukuran_45" name="ukuran_45" required><br>

        <label for="keterangan">Keterangan:</label>
        <textarea id="keterangan" name="keterangan"></textarea><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
