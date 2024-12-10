<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $kode_supplier = $_POST['kode_supplier']; 
    $nama_supplier = $_POST['nama_supplier'];
    $nama_obat = $_POST['nama_obat'];
    $harga = $_POST['harga'];
    $kriteria = $_POST['kriteria'];

    // Insert data ke tabel alternatif
    $sql = "INSERT INTO alternatif (kode_supplier, nama_supplier, nama_obat, harga) 
            VALUES ('$kode_supplier', '$nama_supplier', '$nama_obat', '$harga')";
    $conn->query($sql);
    $id_alternatif = $conn->insert_id;

    // Insert nilai alternatif untuk masing-masing kriteria
    foreach ($kriteria as $id_kriteria => $id_subkriteria) {
        $sql = "INSERT INTO nilai_alternatif (id_alternatif, id_kriteria, id_subkriteria) 
                VALUES ($id_alternatif, $id_kriteria, $id_subkriteria)";
        $conn->query($sql);
    }

    header("Location: data_spk.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2>Input Data Alternatif</h2>
        <form method="POST">
            <!-- Input Kode Supplier -->
            <div class="mb-3">
                <label for="kode_supplier" class="form-label">Kode Supplier</label>
                <input type="text" id="kode_supplier" name="kode_supplier" class="form-control" required>
            </div>

            <!-- Input Nama Supplier -->
            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                <input type="text" id="nama_supplier" name="nama_supplier" class="form-control" required>
            </div>

            <!-- Input Nama Obat -->
            <div class="mb-3">
                <label for="nama_obat" class="form-label">Nama Obat</label>
                <input type="text" id="nama_obat" name="nama_obat" class="form-control" required>
            </div>

            <!-- Input Harga -->
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" class="form-control" step="0.01" min="0" required>
            </div>

            <!-- Input Kriteria -->
            <?php
            $sql = "SELECT * FROM kriteria WHERE nama_kriteria != 'Harga'";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<div class='mb-3'>";
                echo "<label class='form-label'>" . htmlspecialchars($row['nama_kriteria']) . "</label>";
                $id_kriteria = $row['id'];

                $subquery = "SELECT * FROM subkriteria WHERE id_kriteria = $id_kriteria";
                $subresult = $conn->query($subquery);

                echo "<select name='kriteria[$id_kriteria]' class='form-select' required>";
                echo "<option value='' disabled selected>Pilih Subkriteria</option>";
                while ($subrow = $subresult->fetch_assoc()) {
                    echo "<option value='" . $subrow['id'] . "'>" . htmlspecialchars($subrow['keterangan']) . "</option>";
                }
                echo "</select>";
                echo "</div>";
            }
            ?>
            
            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-3 text-center">
            <p>&copy; 2024 Siprobat. All Rights Reserved.</p>
            <p>Developed by <a href="#" class="text-white text-decoration-none"> Kelompok 6 </a></p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
