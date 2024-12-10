<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Menampilkan pesan logout jika ada
if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']); // Hapus pesan setelah ditampilkan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siprobat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Membuat sticky footer */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        footer {
            background-color: #343a40;
            color: white;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(90deg, #007bff, #6610f2);
            border-bottom: 3px solid #ffc107;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff !important;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand:hover {
            color: #ffc107 !important;
        }

        .nav-link {
            font-weight: 500;
            color: #ffffff !important;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffc107 !important;
        }

        .nav-link.active {
            background-color: #ffc107;
            color: #000 !important;
            font-weight: bold;
        }

        /* Responsif untuk Mobile */
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
            .nav-link {
                margin-bottom: 5px;
            }
        }

        /* Styling konten agar rata kiri-kanan */
        .text-justify {
            text-align: justify;
            text-justify: inter-word;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="homeuser.php">Siprobat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'homeuser.php' ? 'active' : ''; ?>" href="homeuser.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dataspk_user.php' ? 'active' : ''; ?>" href="dataspk_user.php">Data Supplier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kriteria_user.php' ? 'active' : ''; ?>" href="kriteria_user.php">Kriteria</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'hasilspk_user.php' ? 'active' : ''; ?>" href="hasilspk_user.php">Peringkat Supplier</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin logout dari Siprobat?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <div class="container">
            <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            
            <!-- Menampilkan notifikasi logout jika ada -->
            <?php if (isset($logout_message)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $logout_message; ?>
                </div>
            <?php endif; ?>
            
            <p class="text-justify">
                Selamat datang di Siprobat! Sistem ini bertujuan untuk membantu Anda dalam menentukan keputusan terbaik berdasarkan data yang Anda masukkan, menggunakan metode perhitungan yang terstruktur dan akurat.
            </p>
            
            <!-- Penjelasan Sistem -->
            <h2 class="mt-4">Tentang Siprobat</h2>
            <p class="text-justify">
                Siprobat adalah sebuah alat bantu berbasis web yang memanfaatkan metode *Weighted Product* untuk melakukan analisis terhadap berbagai alternatif keputusan. Dengan sistem ini, Anda dapat dengan mudah mengidentifikasi alternatif terbaik berdasarkan nilai-nilai kriteria yang telah ditentukan.
            </p>
            
            <!-- Fungsi dan Kegunaan -->
            <h3 class="mt-3">Fungsi dan Kegunaan</h3>
            <ul class="text-justify">
                <li><strong>Home:</strong> Menampilkan informasi pengantar serta panduan singkat penggunaan sistem.</li>
                <li><strong>Data Supplier:</strong> Menampilkan daftar alternatif keputusan yang sudah Anda masukkan.</li>
                <li><strong>Input Data:</strong> Formulir untuk memasukkan data alternatif baru ke dalam sistem.</li>
                <li><strong>Kriteria:</strong> Menyediakan fitur untuk menambahkan atau memperbarui kriteria penilaian.</li>
                <li><strong>Peringkat Supplier:</strong> Menyajikan hasil perhitungan berupa peringkat alternatif terbaik.</li>
            </ul>
            
            <!-- Guidelines untuk Menggunakan Sistem -->
            <h3 class="mt-3">Tata Cara Menggunakan Sistem</h3>
            <ol class="text-justify">
                <li>Masuk ke menu <strong>Input Data</strong> untuk menambahkan data alternatif yang akan dianalisis.</li>
                <li>Pastikan kriteria sudah diatur melalui menu <strong>Kriteria</strong> sebelum melanjutkan proses analisis.</li>
                <li>Periksa data alternatif Anda di menu <strong>Data Supplier</strong> untuk memastikan semuanya sudah benar.</li>
                <li>Akses menu <strong>Peringkat Supplier</strong> untuk melihat peringkat alternatif berdasarkan kriteria.</li>
                <li>Gunakan hasil analisis sebagai dasar untuk pengambilan keputusan yang tepat.</li>
            </ol>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-3 text-center">
            <p>&copy; 2024 Siprobat. All Rights Reserved.</p>
            <p>Developed by <a href="#" class="text-white text-decoration-none">Kelompok 6</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
