<?php
include 'config.php';
session_start();

// Menampilkan pesan sukses jika ada (setelah registrasi)
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Hapus pesan setelah ditampilkan
}

$message = ''; // Variabel untuk menyimpan pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input tidak kosong
    if (!empty($username) && !empty($password)) {
        // Jika username adalah admin dan password adalah 12345678
        if ($username === 'admin' && $password === '12345678') {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'admin'; // Menandai sebagai admin
            header('Location: index.php'); // Redirect ke halaman admin
            exit();
        } else {
            // Query untuk mengambil data user lain
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verifikasi password (gunakan password hashing di sistem produksi)
                if ($password === $row['password']) {
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = 'user'; // Menandai sebagai user biasa
                    header('Location: homeuser.php'); // Redirect ke halaman user
                    exit();
                } else {
                    $message = "Password salah!";
                }
            } else {
                $message = "Username tidak ditemukan!";
            }
        }
    } else {
        $message = "Harap isi semua field!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 360px;
            width: 100%;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .register-link {
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        /* Styling untuk notifikasi yang akan muncul sebentar */
        .alert {
            display: none;
            margin-bottom: 15px;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
        }

        .alert.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Menampilkan notifikasi registrasi berhasil jika ada -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success text-center show" id="success-alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <div class="login-container">
        <h2>Login</h2>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <!-- Menampilkan pesan kesalahan jika ada -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
        <p class="mt-3 register-link">Belum punya akun? <a href="register.php">Register</a></p>
    </div>

    <script>
        // Menampilkan notifikasi berhasil dan menghilangkannya setelah beberapa detik
        if (document.getElementById('success-alert')) {
            setTimeout(function() {
                document.getElementById('success-alert').classList.remove('show');
            }, 3000); // Menghilangkan notifikasi setelah 3 detik
        }
    </script>
</body>
</html>
