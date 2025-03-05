<?php
require 'functions.php';

// Get current page from URL parameter with validation
$page = isset($_GET['page']) ? filter_var($_GET['page'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) : 1;
if ($page === false) $page = 1; // Default to page 1 if invalid

// Validate category parameter
$category = isset($_GET['category']) ? filter_var($_GET['category'], FILTER_VALIDATE_INT) : null;
if ($category === false) $category = null; // Default to null if invalid

// Sanitize search parameter
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
// Limit search length to prevent excessive processing
$search = substr($search, 0, 100);

$perPage = 5; // Limit articles per page

// Use prepared statements for all database queries
try {
    // Build base query
    $countSql = "SELECT COUNT(*) as total
                FROM artikel 
                LEFT JOIN categories ON artikel.category_id = categories.id 
                LEFT JOIN user ON artikel.UserId = user.UserId 
                WHERE artikel.status = 'Dipublish' AND artikel.is_hidden = 0";
    
    $params = [];
    $types = "";
    
    // Add category filter if selected
    if ($category) {
        $countSql .= " AND artikel.category_id = ?";
        $params[] = $category;
        $types .= "i";
    }
    
    // Add search filter if provided
    if ($search) {
        $countSql .= " AND (artikel.judul LIKE ? OR artikel.isi LIKE ? OR artikel.keywords LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "sss";
    }
    
    // Get total count using prepared statement
    $stmt = $conn->prepare($countSql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $total_result = $stmt->get_result();
    $total_row = $total_result->fetch_assoc();
    $total_articles = $total_row['total'];
    $total_pages = ceil($total_articles / $perPage);
    
    // Ensure current page is within valid range
    $page = max(1, min($page, max(1, $total_pages)));
    
    // Main query for articles with pagination
    $sql = "SELECT artikel.*, categories.name as category_name, user.nama as author_name 
            FROM artikel 
            LEFT JOIN categories ON artikel.category_id = categories.id 
            LEFT JOIN user ON artikel.UserId = user.UserId 
            WHERE artikel.status = 'Dipublish' AND artikel.is_hidden = 0";
    
    // Add the same filters as count query
    if ($category) {
        $sql .= " AND artikel.category_id = ?";
    }
    
    if ($search) {
        $sql .= " AND (artikel.judul LIKE ? OR artikel.isi LIKE ? OR artikel.keywords LIKE ?)";
    }
    
    // Add pagination limit
    $sql .= " ORDER BY artikel.tanggal DESC LIMIT ?, ?";
    
    // Add pagination parameters
    $offset = ($page - 1) * $perPage;
    $params[] = $offset;
    $params[] = $perPage;
    $types .= "ii";
    
    // Execute main query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $articles_result = $stmt->get_result();
    
    $articles = [];
    while ($row = $articles_result->fetch_assoc()) {
        $articles[] = $row;
    }
    
    // Get categories for filter using prepared statement
    $stmt = $conn->prepare("SELECT * FROM categories ORDER BY name ASC");
    $stmt->execute();
    $categories_result = $stmt->get_result();
    $categories = [];
    while ($row = $categories_result->fetch_assoc()) {
        $categories[] = $row;
    }
    
} catch (Exception $e) {
    // Handle exceptions
    $error_message = "An error occurred: " . $e->getMessage();
    $articles = [];
    $categories = [];
}
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
                                value="<?= htmlspecialchars($search ?? '') ?>" maxlength="100">
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

    <!-- Display error message if any -->
    <?php if (isset($error_message)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error_message) ?>
    </div>
    <?php endif; ?>

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
    <?php if ($total_pages > 0): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link"
                    href="?page=<?= $page - 1 ?>&category=<?= $category ?>&search=<?= urlencode($search) ?>&csrf_token=<?= generateCSRFToken() ?>">Previous</a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link"
                    href="?page=<?= $i ?>&category=<?= $category ?>&search=<?= urlencode($search) ?>&csrf_token=<?= generateCSRFToken() ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link"
                    href="?page=<?= $page + 1 ?>&category=<?= $category ?>&search=<?= urlencode($search) ?>&csrf_token=<?= generateCSRFToken() ?>">Next</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php require("views/partials/footer.php") ?>