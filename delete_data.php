<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Koneksi ke database

// Ambil ID alternatif dari parameter URL
$id_alternatif = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cek apakah ID alternatif valid
if ($id_alternatif > 0) {
    // Menghapus data dari tabel nilai_alternatif terlebih dahulu (jika ada)
    $sql_delete_nilai = "DELETE FROM nilai_alternatif WHERE id_alternatif = $id_alternatif";
    $conn->query($sql_delete_nilai);

    // Menghapus data dari tabel alternatif
    $sql_delete_alternatif = "DELETE FROM alternatif WHERE id = $id_alternatif";
    if ($conn->query($sql_delete_alternatif)) {
        // Redirect ke halaman data_spk setelah berhasil menghapus data
        header("Location: data_spk.php");
        exit();
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak valid.";
}
?>
