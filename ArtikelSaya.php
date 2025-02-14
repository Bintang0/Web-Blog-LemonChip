<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "kpl";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi Hapus Artikel
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Ambil nama file gambar untuk dihapus
    $query = "SELECT gambar FROM artikel WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if ($data) {
        $gambar = $data['gambar'];
        $gambar_path = "uploads/" . $gambar;

        // Hapus gambar jika ada
        if (file_exists($gambar_path)) {
            unlink($gambar_path);
        }

        // Hapus artikel dari database
        $query = "DELETE FROM artikel WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Artikel berhasil dihapus!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus artikel!');</script>";
        }
    }
}

// Ambil data dari database
$query = "SELECT * FROM artikel ORDER BY id DESC";
$result = $conn->query($query);
?>

<?php require('views/partials/header.php'); ?>

<div class="container mt-4">
    <h2 class="text-center">Manajemen Artikel</h2>

    <!-- Daftar Artikel -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                        <p class="card-text"><?php echo substr(htmlspecialchars($row['isi']), 0, 50) . '...'; ?></p>
                        <p class="text-muted"><?php echo date("d M Y H:i", strtotime($row['tanggal'])); ?></p>
                        <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
                        
                        <!-- Tombol Edit -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>

                        <!-- Modal Edit Artikel -->
                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Artikel</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                            
                                            <div class="mb-3">
                                                <label>Judul Artikel</label>
                                                <input type="text" name="edit_judul" class="form-control" value="<?php echo htmlspecialchars($row['judul']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Tanggal</label>
                                                <input type="datetime-local" name="edit_tanggal" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['tanggal'])); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Isi Artikel</label>
                                                <textarea name="edit_isi" class="form-control" required><?php echo htmlspecialchars($row['isi']); ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label>Upload Gambar (Opsional)</label>
                                                <input type="file" name="edit_gambar" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <a href="ArtikelSaya.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus artikel ini?');">Delete</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require('views/partials/footer.php'); ?>
