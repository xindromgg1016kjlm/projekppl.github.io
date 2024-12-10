<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: #212529;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
</head>
<body>
    <?php include 'navbar_user.php'; ?>

    <main class="container mt-5">
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
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Siprobat. All Rights Reserved.</p>
            <p>Developed by <a href="#" class="text-white text-decoration-none">Kelompok 6</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
