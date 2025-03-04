<?php
require 'functions.php';

// Get current page from URL parameter
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1; // Memastikan page >= 1
$category = isset($_GET['category']) ? (int) $_GET['category'] : null; // Memastikan category adalah integer atau null
$search = isset($_GET['search']) ? trim($_GET['search']) : ''; // Memastikan search di-trim dan aman
$perPage = 5; // Limit articles per page

// Build base query
$sql = "SELECT artikel.*, categories.name as category_name, user.nama as author_name 
        FROM artikel 
        LEFT JOIN categories ON artikel.category_id = categories.id 
        LEFT JOIN user ON artikel.UserId = user.UserId 
        WHERE artikel.status = 'Dipublish' AND artikel.is_hidden = 0";

// Add category filter if selected
if ($category) {
    $sql .= " AND artikel.category_id = " . (int) $category;
}

// Add search filter if provided
if ($search) {
    $sql .= " AND (artikel.judul LIKE '%" . $conn->real_escape_string($search) . "%' 
              OR artikel.isi LIKE '%" . $conn->real_escape_string($search) . "%'
              OR artikel.keywords LIKE '%" . $conn->real_escape_string($search) . "%')";
}

// Batas panjang search untuk mencegah query berat
if (strlen($search) > 100) { // Batas maksimal 100 karakter
    $search = substr($search, 0, 100);
}

// Get total articles for pagination
$total_result = $conn->query($sql);
$total_articles = $total_result->num_rows;
$total_pages = ceil($total_articles / $perPage);

// Ensure current page is within valid range
$page = max(1, min($page, $total_pages));

// Add pagination limit
$offset = ($page - 1) * $perPage;
$sql .= " ORDER BY artikel.tanggal DESC LIMIT $offset, $perPage";

$articles = query($sql);
$categories = query("SELECT * FROM categories ORDER BY name ASC");
?>

<?php require("views/partials/header.php") ?>

<div class="container mt-4">


    <!-- Search and Filter Section -->
    <div class="container">
        <div class="row mb-4 justify-content-center">
            <div class="col-md-8">
                <form action="" method="GET" class="d-flex gap-2 justify-content-center">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <div class="row justify-content-center" style="width: 100%;">
                        <div class="col-md-5 mb-2 mb-md-0">
                            <input type="text" name="search" class="form-control" placeholder="Search articles..."
                                value="<?= htmlspecialchars($search ?? '') ?>">
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($category == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 mb-md-0">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                        <?php if ($search || $category): ?>
                            <div class="col-md-2">
                                <a href="blog.php" class="btn btn-secondary w-100">
                                    <i class="bi bi-x-circle"></i> Clear
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Articles Grid -->
    <div class="row">
        <?php if (count($articles) > 0): ?>
            <?php foreach ($articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="img/<?= htmlspecialchars($article['gambar']) ?>" class="card-img-top"
                            alt="<?= htmlspecialchars($article['judul']) ?>" style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars($article['judul']) ?>
                            </h5>

                            <p class="card-text text-muted small">
                                <i class="bi bi-person"></i>
                                <?= htmlspecialchars($article['author_name']) ?> |
                                <i class="bi bi-calendar"></i>
                                <?= date('M d, Y', strtotime($article['tanggal'])) ?> |
                                <i class="bi bi-tag"></i>
                                <?= htmlspecialchars($article['category_name'] ?? 'Uncategorized') ?>
                            </p>

                            <?php if (!empty($article['keywords'])): ?>
                                <div class="mb-2">
                                    <?php foreach (explode(',', $article['keywords']) as $keyword): ?>
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars(trim($keyword)) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <p class="card-text">
                                <?= htmlspecialchars(substr($article['isi'], 0, 150)) ?>...
                            </p>
                        </div>

                        <div class="card-footer bg-white border-top-0">
                            <a href="detail.php?id=<?= $article['id'] ?>" class="btn btn-primary btn-sm">
                                Read More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> No articles found.
                    <?php if ($search || $category): ?>
                        <br>Try different search terms or categories.
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?page=<?= $page - 1 ?>&category=<?= $category ?>&search=<?= urlencode($search) ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $i ?>&category=<?= $category ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?page=<?= $page + 1 ?>&category=<?= $category ?>&search=<?= urlencode($search) ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>


</div>
</div>
<?php require("views/partials/footer.php") ?>



<script>
    // Update current time
    function updateTime() {
        const timeElement = document.getElementById('current-time');
        const now = new Date();
        timeElement.textContent = now.toLocaleTimeString();
    }

    setInterval(updateTime, 1000);

    // Add loading indicator for page transitions
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (!link.hasAttribute('data-bs-toggle')) {
                document.body.style.cursor = 'wait';
            }
        });
    });
</script>