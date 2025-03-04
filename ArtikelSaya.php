<?php require 'functions.php'; ?>
<?php

// Cek apakah user sudah login
if (!isset($_SESSION['UserId'])) {
    header("Location: login.php");
    exit;
}

$userid = $_SESSION['UserId'];

// Cek apakah sesi login ada
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Query untuk mengambil artikel dengan kategorinya dan keywords
$sql = "SELECT artikel.*, categories.name as category_name 
        FROM artikel 
        LEFT JOIN categories ON artikel.category_id = categories.id 
        WHERE artikel.UserId = ?
        ORDER BY artikel.tanggal DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

// Get categories for dropdown
$categories = query("SELECT * FROM categories ORDER BY name ASC");
?>


<?php require("views/partials/header.php") ?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-center">Manajemen Artikel</h2>
        </div>
    </div>

    <!-- Tombol Tambah Artikel -->
    <div class="text-center mb-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addArticleModal">
            <i class="bi bi-plus-circle"></i> Tambah Artikel Baru
        </button>
        <a class="btn btn-primary" href="history.php">
            <i class="bi bi-clock-history"></i> Riwayat Penerbitan
        </a>
    </div>

    <!-- Modal Tambah Artikel -->
    <div class="modal fade" id="addArticleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahArtikel.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" name="category_id" id="category" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keywords" class="form-label">Keywords</label>
                            <input type="text" class="form-control" id="keywords" name="keywords"
                                placeholder="Contoh: teknologi, programming, web">
                            <small class="text-muted">Pisahkan dengan koma (,)</small>
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Artikel</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept=".jpg,.jpeg,.png"
                                required>
                            <div id="gambarPreview" class="mt-2"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Articles -->
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="img/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top article-image"
                    alt="<?= htmlspecialchars($row['judul']) ?>" style="height: 200px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>

                    <p class="card-text text-muted small">
                        <i class="bi bi-calendar"></i>
                        <?= date('d M Y H:i', strtotime($row['tanggal'])) ?>
                    </p>

                    <p class="card-text text-muted small">
                        <i class="bi bi-tag"></i>
                        <?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?>
                    </p>

                    <?php if (!empty($row['keywords'])): ?>
                    <div class="mb-2">
                        <?php foreach (explode(',', $row['keywords']) as $keyword): ?>
                        <span class="badge bg-secondary">
                            <?= htmlspecialchars(trim($keyword)) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <p class="card-text">
                        <?= htmlspecialchars(substr($row['isi'], 0, 100)) ?>...
                    </p>

                    <div class="d-flex gap-2 justify-content-center">
                        <!-- Tombol Baca -->
                        <a href="detail.php?id=<?= $row['id'] ?>"
                            class="btn btn-primary btn-sm d-flex align-items-center gap-2 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-book" viewBox="0 0 576 512">
                                <path
                                    d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5l0-377.4c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8L0 454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5l0-370.3c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11L304 456c0 11.4 11.7 19.3 22.4 15.5z" />
                            </svg>
                            <span>Baca</span>
                        </a>

                        <!-- Tombol Edit -->
                        <button type="button" class="btn btn-warning btn-sm d-flex align-items-center gap-2 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="14" width="14" viewBox="0 0 512 512">
                                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="black"
                                    d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                            </svg>
                            <span>Edit</span>
                        </button>

                        <!-- Tombol Hapus -->
                        <button type="button" class="btn btn-danger btn-sm d-flex align-items-center gap-2 shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" height="14" width="12.25" viewBox="0 0 448 512">
                                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Artikel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="updateArtikel.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul"
                                    value="<?= htmlspecialchars($row['judul']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"
                                        <?= ($category['id'] == $row['category_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Keywords</label>
                                <input type="text" class="form-control" name="keywords"
                                    value="<?= htmlspecialchars($row['keywords'] ?? '') ?>">
                                <small class="text-muted">Pisahkan dengan koma (,)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Isi Artikel</label>
                                <textarea class="form-control" name="isi" rows="5" required><?=
                                            htmlspecialchars($row['isi'])
                                            ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gambar Saat Ini</label>
                                <div class="current-image-container">
                                    <img src="img/<?= htmlspecialchars($row['gambar']) ?>"
                                        class="img-thumbnail current-image" alt="Current Image">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Update Gambar (Optional)</label>
                                <input type="file" class="form-control" name="gambar" accept=".jpg,.jpeg,.png">
                                <div class="new-image-preview mt-2"></div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus artikel "<strong><?= htmlspecialchars($row['judul']) ?></strong>"?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a href="deleteArtikel.php?id=<?= $row['id'] ?>" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada artikel yang dibuat. Silakan tambah artikel baru.
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
?>

<?php require("views/partials/footer.php") ?>

<style>
.article-image {
    transition: transform 0.3s ease;
}

.article-image:hover {
    transform: scale(1.05);
}

.current-image-container {
    text-align: center;
    margin: 10px 0;
    background: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
}

.current-image {
    max-height: 200px;
    width: auto;
}

.badge {
    margin-right: 5px;
    margin-bottom: 5px;
}

.new-image-preview img {
    max-height: 200px;
    width: auto;
    margin-top: 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Preview for edit article images
    document.querySelectorAll('input[type="file"][name="gambar"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const preview = this.nextElementSibling;
            preview.innerHTML = '';

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    preview.appendChild(img);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Validate image upload
    function validateImage(input) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if (input.files && input.files[0]) {
            const file = input.files[0];

            if (file.size > maxSize) {
                alert('File terlalu besar! Maksimal ukuran file adalah 5MB.');
                input.value = '';
                return false;
            }

            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung! Gunakan JPG, JPEG, atau PNG.');
                input.value = '';
                return false;
            }

            return true;
        }
    }

    // Add validation to all image inputs
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            validateImage(this);
        });
    });
});
</script>