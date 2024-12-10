<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Inisialisasi variabel pencarian
$search = isset($_POST['search']) ? trim($_POST['search']) : '';

// Mengambil bobot kriteria
$sql_kriteria = "SELECT * FROM kriteria";
$result_kriteria = $conn->query($sql_kriteria);
if (!$result_kriteria) {
    die("Query failed: " . $conn->error);
}

$bobot = [];
$tipe_kriteria = [];
$total_bobot = 0;
while ($row = $result_kriteria->fetch_assoc()) {
    $bobot[$row['id']] = $row['bobot'];
    $tipe_kriteria[$row['id']] = isset($row['tipe']) ? $row['tipe'] : 'Benefit';
    $total_bobot += $row['bobot'];
}

foreach ($bobot as $id_kriteria => $nilai_bobot) {
    $bobot[$id_kriteria] = $nilai_bobot / $total_bobot;
}

$sql_alternatif = "SELECT * FROM alternatif WHERE nama_supplier LIKE ? OR nama_obat LIKE ?";
$stmt = $conn->prepare($sql_alternatif);
$search_param = '%' . $search . '%';
$stmt->bind_param('ss', $search_param, $search_param);
$stmt->execute();
$result_alternatif = $stmt->get_result();

$alternatif = [];
while ($row = $result_alternatif->fetch_assoc()) {
    $id_alternatif = $row['id'];
    $alternatif[$id_alternatif] = [
        'kode_supplier' => $row['kode_supplier'],
        'nama_supplier' => $row['nama_supplier'],
        'nama_obat' => $row['nama_obat'],
        'harga' => $row['harga'],
        'nilai' => []
    ];

    $sql_nilai = "SELECT nilai_alternatif.id_kriteria, subkriteria.nilai 
                  FROM nilai_alternatif 
                  JOIN subkriteria ON nilai_alternatif.id_subkriteria = subkriteria.id 
                  WHERE nilai_alternatif.id_alternatif = $id_alternatif";
    $result_nilai = $conn->query($sql_nilai);
    while ($nilai = $result_nilai->fetch_assoc()) {
        $alternatif[$id_alternatif]['nilai'][$nilai['id_kriteria']] = $nilai['nilai'];
    }
}

$hasil_wp = [];
$total_wp = 0;

foreach ($alternatif as $id_alternatif => $data) {
    $skor_wp = 1;
    $harga = $data['harga'];
    $bobot_harga = $bobot[1];

    if ($tipe_kriteria[1] == 'Cost') {
        $skor_wp *= pow($harga, -$bobot_harga);
    } else {
        $skor_wp *= pow($harga, $bobot_harga);
    }

    foreach ($bobot as $id_kriteria => $bobot_kriteria) {
        if ($id_kriteria != 1) {
            $nilai_subkriteria = $data['nilai'][$id_kriteria] ?? 1;
            $bobot_efektif = ($tipe_kriteria[$id_kriteria] === 'Cost') ? -$bobot_kriteria : $bobot_kriteria;
            $skor_wp *= pow($nilai_subkriteria, $bobot_efektif);
        }
    }

    $hasil_wp[$id_alternatif] = $skor_wp;
    $total_wp += $skor_wp;
}

foreach ($hasil_wp as $id_alternatif => $skor_wp) {
    $hasil_wp[$id_alternatif] = [
        'skor_wp' => $skor_wp,
        'normalisasi' => $total_wp > 0 ? $skor_wp / $total_wp : 0
    ];
}

arsort($hasil_wp);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringkat Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
    <?php include 'navbar.php'; ?>

    <main class="container mt-5">
        <h2>Peringkat Supplier</h2>

        <form method="POST" action="" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari Nama Supplier atau Obat" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Nama Obat</th>
                    <?php
                    $counter = 1;
                    foreach ($bobot as $id_kriteria => $bobot_kriteria) {
                        echo "<th>C" . $counter++ . "</th>";
                    }
                    ?>
                    <th>Normalisasi</th>
                    <th>Peringkat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $peringkat = 1;
                foreach ($hasil_wp as $id_alternatif => $data) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($alternatif[$id_alternatif]['kode_supplier']) . "</td>";
                    echo "<td>" . htmlspecialchars($alternatif[$id_alternatif]['nama_supplier']) . "</td>";
                    echo "<td>" . htmlspecialchars($alternatif[$id_alternatif]['nama_obat']) . "</td>";

                    $counter = 1;
                    foreach ($bobot as $id_kriteria => $bobot_kriteria) {
                        if ($counter == 1) {
                            echo "<td>" . number_format($alternatif[$id_alternatif]['harga'], 1, ',', '.') . "</td>";
                        } else {
                            $nilai_subkriteria = $alternatif[$id_alternatif]['nilai'][$id_kriteria] ?? '-';
                            echo "<td>" . htmlspecialchars($nilai_subkriteria) . "</td>";
                        }
                        $counter++;
                    }

                    echo "<td>" . number_format($data['normalisasi'], 9, ',', '.') . "</td>";
                    echo "<td>" . $peringkat++ . "</td>";
                    echo "</tr>";
                }
                ?>
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
