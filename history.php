<?php require 'functions.php' ?>

<?php
if (!isset($_SESSION['UserId'])) {
    // Jika user belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['UserId']; // Ambil UserId dari session

// Ambil artikel berdasarkan UserId
$sql = "SELECT * FROM artikel WHERE UserId = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php require("views/partials/header.php") ?>

<div class="container mt-4">
    <h2 class="text-center">Riwayat Penerbitan Artikel</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Isi</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Riwayat Penerbitan</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['judul']); ?></td>
                            <td><?php echo htmlspecialchars($row['isi']); ?></td>
                            <td><img src="img/<?php echo htmlspecialchars($row['gambar']); ?>" style="width: 100px; height: 75px; object-fit: cover;"></td>
                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                            <td>
                                <?php
                                // Menentukan status berdasarkan kolom 'status' (contoh: aktif atau tidak)
                                if ($row['status'] == 'Dipublish') {
                                    echo '<span class="badge bg-success">Dipublish</span>';
                                } else {
                                    echo '<span class="badge bg-warning">Draft</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada riwayat penerbitan.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require("views/partials/footer.php") ?>
