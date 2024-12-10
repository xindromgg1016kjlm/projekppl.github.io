<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Buat body dan html menggunakan flexbox */
        html, body {
            height: 100%; /* Pastikan halaman mengisi tinggi penuh */
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Kontainer utama */
        .main-content {
            flex: 1; /* Isi ruang yang tersedia di antara header dan footer */
        }

        /* Footer */
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
        <h2>KRITERIA</h2>
        <!-- Tabel Kriteria -->
        <table class="table table-bordered table-hover mt-4">
            <thead class="table-primary">
                <tr>
                    <th>Kriteria</th>
                    <th>Keterangan</th>
                    <th>Bobot</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>C1</td>
                    <td>Harga</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>C2</td>
                    <td>Tempo Bayar</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>C3</td>
                    <td>Ketepatan Waktu</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>C4</td>
                    <td>Ketepatan Jumlah</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>C5</td>
                    <td>Dukungan Pelayanan</td>
                    <td>1</td>
                </tr>
            </tbody>
        </table>
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
