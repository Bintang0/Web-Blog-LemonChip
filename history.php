<?php require 'functions.php' ?>

<?php
if (!isset($_SESSION['UserId'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['UserId'];

// Set default sorting dan filter
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$visibility = isset($_GET['visibility']) ? $_GET['visibility'] : 'all';

// Build query base
$sql = "SELECT artikel.*, categories.name as category_name 
        FROM artikel 
        LEFT JOIN categories ON artikel.category_id = categories.id 
        WHERE artikel.UserId = ?";

// Add category filter
if ($category !== 'all') {
    $sql .= " AND artikel.category_id = " . (int)$category;
}


// Add visibility filter
if ($visibility !== 'all') {
    $sql .= " AND artikel.is_hidden = " . ($visibility === 'hidden' ? '1' : '0');
}

// Add sorting
switch ($sort) {
    case 'oldest':
        $sql .= " ORDER BY artikel.tanggal ASC";
        break;
    case 'title_asc':
        $sql .= " ORDER BY artikel.judul ASC";
        break;
    case 'title_desc':
        $sql .= " ORDER BY artikel.judul DESC";
        break;
    default: // newest
        $sql .= " ORDER BY artikel.tanggal DESC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Get categories for filter
$categories = query("SELECT * FROM categories ORDER BY name ASC");
?>

<?php require("views/partials/header.php") ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Riwayat Penerbitan Artikel</h2>

    

    <!-- Tabel Artikel -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Preview</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['category_name'] ?? 'Tidak Berkategori') ?></td>
                    <td><?= htmlspecialchars(substr($row['isi'], 0, 100)) ?>...</td>
                    <td>
                        <img src="img/<?= htmlspecialchars($row['gambar']) ?>"
                            alt="<?= htmlspecialchars($row['judul']) ?>"
                            style="width: 100px; height: 75px; object-fit: cover;" class="img-thumbnail">
                    </td>
                    <td><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></td>

                    <td>
                        <span class="badge <?= $row['is_hidden'] ? 'bg-danger' : 'bg-info' ?>">
                            <?= $row['is_hidden'] ? 'Disembunyikan' : 'Ditampilkan' ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary"
                                title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if (!$row['is_hidden']): ?>
                            <a href="updateStatus.php?action=hide&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"
                                title="Sembunyikan Artikel"
                                onclick="return confirm('Yakin ingin menyembunyikan artikel ini?')">
                                <i class="bi bi-eye-slash"></i>
                            </a>
                            <?php else: ?>
                            <a href="updateStatus.php?action=restore&id=<?= $row['id'] ?>"
                                class="btn btn-sm btn-success" title="Pulihkan Artikel"
                                onclick="return confirm('Yakin ingin memulihkan artikel ini?')">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal<?= $row['id'] ?>" title="Hapus Artikel">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus artikel "<?= htmlspecialchars($row['judul']) ?>"?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <a href="deleteArtikel.php?id=<?= $row['id'] ?>"
                                            class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php 
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada riwayat penerbitan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$stmt->close();
$conn->close();
?>

<?php require("views/partials/footer.php") ?>