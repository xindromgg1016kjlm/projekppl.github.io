<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Koneksi ke database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS untuk tata letak footer selalu di bawah */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Konten Utama -->
    <div class="container mt-5 main-content">
        <h2 class="mb-4">Data Supplier Obat-Obatan</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Nama Obat</th>
                    <th>Harga (Rp)</th>
                    <?php
                    // Query untuk menampilkan kriteria selain harga
                    $sql_kriteria = "SELECT * FROM kriteria WHERE nama_kriteria != 'Harga'";
                    $result_kriteria = $conn->query($sql_kriteria);

                    $kriteria_ids = []; // Menyimpan ID kriteria
                    while ($row = $result_kriteria->fetch_assoc()) {
                        $kriteria_ids[] = $row['id'];
                        echo "<th>" . htmlspecialchars($row['nama_kriteria']) . "</th>";
                    }
                    ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data alternatif
                $sql_alternatif = "SELECT * FROM alternatif";
                $result_alternatif = $conn->query($sql_alternatif);
                $no = 1;

                while ($row_alternatif = $result_alternatif->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row_alternatif['kode_supplier']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_alternatif['nama_supplier']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_alternatif['nama_obat']) . "</td>";
                    echo "<td>" . number_format($row_alternatif['harga'], 2, ',', '.') . "</td>";

                    // Menampilkan nilai subkriteria berdasarkan kriteria
                    foreach ($kriteria_ids as $id_kriteria) {
                        $sql_nilai = "SELECT subkriteria.keterangan 
                                      FROM nilai_alternatif 
                                      JOIN subkriteria ON nilai_alternatif.id_subkriteria = subkriteria.id 
                                      WHERE nilai_alternatif.id_alternatif = " . $row_alternatif['id'] . " 
                                        AND nilai_alternatif.id_kriteria = $id_kriteria";
                        $result_nilai = $conn->query($sql_nilai);
                        $nilai = $result_nilai->fetch_assoc();

                        echo "<td>" . htmlspecialchars($nilai['keterangan'] ?? '-') . "</td>";
                    }

                    // Aksi Edit dan Hapus
                    echo "<td>
                            <a href='edit_spk.php?id=" . $row_alternatif['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_data.php?id=" . $row_alternatif['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container py-3">
            <p>&copy; 2024 Siprobat. All Rights Reserved.</p>
            <p>Developed by <a href="#" class="text-white text-decoration-none">Kelompok 6</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
