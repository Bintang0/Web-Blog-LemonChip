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
    $sql .= " AND artikel.category_id = " . (int) $category;
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
                                    <!-- Tombol Lihat Detail -->
                                    <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary"
                                        title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 576 512">
                                            <path
                                                d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5l0-377.4c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8L0 454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5l0-370.3c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11L304 456c0 11.4 11.7 19.3 22.4 15.5z" />
                                        </svg>
                                    </a>

                                    <?php if (!$row['is_hidden']): ?>
                                        <!-- Tombol Sembunyikan Artikel -->
                                        <a href="updateStatus.php?action=hide&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"
                                            title="Sembunyikan Artikel"
                                            onclick="return confirm('Yakin ingin menyembunyikan artikel ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="14" width="17.5"
                                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                <path
                                                    d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <!-- Tombol Pulihkan Artikel -->
                                        <a href="updateStatus.php?action=restore&id=<?= $row['id'] ?>"
                                            class="btn btn-sm btn-success" title="Pulihkan Artikel"
                                            onclick="return confirm('Yakin ingin memulihkan artikel ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="14" width="15.75"
                                                viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                <path fill="black"
                                                    d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Tombol Hapus Artikel -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?= $row['id'] ?>" title="Hapus Artikel">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="14" width="12.25"
                                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                            <path fill="#ffffff"
                                                d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                        </svg>
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