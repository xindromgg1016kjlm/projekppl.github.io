<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Koneksi ke database

// Ambil ID alternatif dari parameter URL
$id_alternatif = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cek apakah data alternatif valid
$sql_alternatif = "SELECT * FROM alternatif WHERE id = $id_alternatif";
$result_alternatif = $conn->query($sql_alternatif);
if ($result_alternatif->num_rows == 0) {
    echo "Data tidak ditemukan!";
    exit();
}
$alternatif = $result_alternatif->fetch_assoc();

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_supplier = $_POST['kode_supplier'];  // Ambil kode supplier
    $nama_supplier = $_POST['nama_supplier'];
    $nama_obat = $_POST['nama_obat'];
    $harga = $_POST['harga'];
    $kriteria = $_POST['kriteria'];

    // Update tabel alternatif
    $sql_update = "UPDATE alternatif 
                   SET kode_supplier = '$kode_supplier', nama_supplier = '$nama_supplier', nama_obat = '$nama_obat', harga = '$harga' 
                   WHERE id = $id_alternatif";
    $conn->query($sql_update);

    // Update tabel nilai_alternatif
    foreach ($kriteria as $id_kriteria => $id_subkriteria) {
        $sql_check = "SELECT * FROM nilai_alternatif WHERE id_alternatif = $id_alternatif AND id_kriteria = $id_kriteria";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            // Jika sudah ada, update
            $sql_update_nilai = "UPDATE nilai_alternatif 
                                 SET id_subkriteria = $id_subkriteria 
                                 WHERE id_alternatif = $id_alternatif AND id_kriteria = $id_kriteria";
            $conn->query($sql_update_nilai);
        } else {
            // Jika belum ada, insert
            $sql_insert_nilai = "INSERT INTO nilai_alternatif (id_alternatif, id_kriteria, id_subkriteria) 
                                 VALUES ($id_alternatif, $id_kriteria, $id_subkriteria)";
            $conn->query($sql_insert_nilai);
        }
    }

    header("Location: data_spk.php");
    exit();
}

// Ambil data kriteria dan nilai yang terkait dengan alternatif ini
$sql_kriteria = "SELECT * FROM kriteria";
$result_kriteria = $conn->query($sql_kriteria);

$nilai_alternatif = [];
$sql_nilai = "SELECT * FROM nilai_alternatif WHERE id_alternatif = $id_alternatif";
$result_nilai = $conn->query($sql_nilai);
while ($row = $result_nilai->fetch_assoc()) {
    $nilai_alternatif[$row['id_kriteria']] = $row['id_subkriteria'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Edit Data Supplier</h2>
        <form method="POST">
            <!-- Field Kode Supplier -->
            <div class="mb-3">
                <label for="kode_supplier" class="form-label">Kode Supplier</label>
                <input type="text" id="kode_supplier" name="kode_supplier" class="form-control" 
                       value="<?= htmlspecialchars($alternatif['kode_supplier']) ?>" required>
            </div>

            <!-- Field Nama Supplier -->
            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                <input type="text" id="nama_supplier" name="nama_supplier" class="form-control" 
                       value="<?= htmlspecialchars($alternatif['nama_supplier']) ?>" required>
            </div>

            <!-- Field Nama Obat -->
            <div class="mb-3">
                <label for="nama_obat" class="form-label">Nama Obat</label>
                <input type="text" id="nama_obat" name="nama_obat" class="form-control" 
                       value="<?= htmlspecialchars($alternatif['nama_obat']) ?>" required>
            </div>

            <!-- Field Harga -->
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" class="form-control" 
                       value="<?= htmlspecialchars($alternatif['harga']) ?>" step="0.01" min="0" required>
            </div>

            <!-- Field Kriteria -->
            <?php
            // Query untuk mendapatkan kriteria
            $sql = "SELECT * FROM kriteria WHERE nama_kriteria != 'Harga'"; // Kecualikan kriteria harga
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<div class='mb-3'>";
                echo "<label class='form-label'>" . htmlspecialchars($row['nama_kriteria']) . "</label>";
                $id_kriteria = $row['id'];

                // Query untuk mendapatkan subkriteria berdasarkan kriteria
                $subquery = "SELECT * FROM subkriteria WHERE id_kriteria = $id_kriteria";
                $subresult = $conn->query($subquery);

                echo "<select name='kriteria[$id_kriteria]' class='form-select' required>";
                echo "<option value='' disabled>Pilih Subkriteria</option>";
                while ($subrow = $subresult->fetch_assoc()) {
                    $selected = ($nilai_alternatif[$id_kriteria] == $subrow['id']) ? "selected" : "";
                    echo "<option value='" . $subrow['id'] . "' $selected>" . htmlspecialchars($subrow['keterangan']) . "</option>";
                }
                echo "</select>";
                echo "</div>";
            }
            ?>
            
            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <footer class="bg-dark text-white mt-5">
        <div class="container py-3 text-center">
            <p>&copy; 2024 Siprobat. All Rights Reserved.</p>
            <p>Developed by <a href="#" class="text-white text-decoration-none">Kelompok 6 </a></p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
