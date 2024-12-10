<?php
session_start();
include 'config.php'; // Pastikan file config.php berisi koneksi ke database

// Menampilkan pesan notifikasi jika ada
if (isset($_SESSION['success_message'])) {
    echo "<div id='success-message' class='alert alert-success text-center'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo "<div id='error-message' class='alert alert-danger text-center'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Password langsung diambil tanpa hashing

    // Mengecek apakah username sudah ada di database
    $sql_check = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Jika username sudah ada
        $_SESSION['error_message'] = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Blokir registrasi dengan username "admin" dan password "12345678"
        if ($username === 'admin' && $password === '12345678') {
            $_SESSION['error_message'] = "Username dan password ini tidak diizinkan untuk registrasi.";
        } else {
            // Query untuk memasukkan data
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if ($conn->query($sql) === TRUE) {
                // Simpan pesan keberhasilan dalam sesi
                $_SESSION['success_message'] = "Registrasi berhasil! Silakan login.";
                // Redirect ke login.php setelah registrasi berhasil
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('gambarobat.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .register-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 360px;
            width: 100%;
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-register {
            background-color: #007bff;
            color: white;
        }

        .btn-register:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        /* Styling untuk posisi notifikasi */
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: 80%;
            max-width: 500px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-register w-100">Register</button>
        </form>
        <p class="mt-3 login-link">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>

    <script>
        // Fungsi untuk menampilkan notifikasi sebentar
        function showNotification(id) {
            const notification = document.getElementById(id);
            notification.style.display = 'block'; // Menampilkan notifikasi
            setTimeout(function() {
                notification.style.display = 'none'; // Menyembunyikan notifikasi setelah 3 detik
            }, 3000); // 3000 ms = 3 detik
        }

        // Menampilkan notifikasi jika ada
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "showNotification('success-message');";
        }

        if (isset($_SESSION['error_message'])) {
            echo "showNotification('error-message');";
        }
        ?>
    </script>
</body>
</html>
