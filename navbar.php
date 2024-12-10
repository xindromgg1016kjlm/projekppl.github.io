<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Siprobat</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'data_spk.php' ? 'active' : ''; ?>" href="data_spk.php">Data Supplier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'input_data.php' ? 'active' : ''; ?>" href="input_data.php">Input Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kriteria.php' ? 'active' : ''; ?>" href="kriteria.php">Kriteria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'hasil_spk.php' ? 'active' : ''; ?>" href="hasil_spk.php">Peringkat Supplier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
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

<style>
/* Navigasi dengan Gradient */
.navbar {
    background: linear-gradient(90deg, #007bff, #6610f2); /* Gradient warna biru ke ungu */
    border-bottom: 3px solid #ffc107; /* Garis bawah berwarna kuning */
    transition: all 0.3s ease-in-out;
}

/* Brand Logo */
.navbar-brand {
    font-size: 1.8rem;
    font-weight: bold;
    color: #fff !important;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
}
.navbar-brand:hover {
    color: #ffc107 !important; /* Warna hover logo */
}

/* Link Navigasi */
.nav-link {
    font-weight: 500;
    color: #ffffff !important;
    padding: 10px 15px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
}

/* Hover pada Link */
.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffc107 !important; /* Kuning cerah saat hover */
}

/* Aktif Link */
.nav-link.active {
    background-color: #ffc107;
    color: #000 !important; /* Hitam untuk kontras */
    font-weight: bold;
}

/* Link Logout */
.logout-link {
    font-weight: bold;
    color: #ff4d4d !important; /* Merah cerah */
}
.logout-link:hover {
    color: #ff6666 !important; /* Hover logout */
}

/* Responsif */
@media (max-width: 768px) {
    .navbar-nav {
        text-align: center;
    }
    .nav-link {
        margin-bottom: 5px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
