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
/* Gaya sama seperti navbar.php */
.navbar {
    background: linear-gradient(90deg, #007bff, #6610f2);
    border-bottom: 3px solid #ffc107;
    transition: all 0.3s ease-in-out;
}

.navbar-brand {
    font-size: 1.8rem;
    font-weight: bold;
    color: #fff !important;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
}
.navbar-brand:hover {
    color: #ffc107 !important;
}

.nav-link {
    font-weight: 500;
    color: #ffffff !important;
    padding: 10px 15px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
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

.logout-link {
    font-weight: bold;
    color: #ff4d4d !important;
}
.logout-link:hover {
    color: #ff6666 !important;
}

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
