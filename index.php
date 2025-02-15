<?php require ('functions.php');?>
<?php 
$all = query('SELECT * FROM artikel WHERE status="Dipublish" ORDER BY tanggal DESC LIMIT 2');

// Get featured articles
$featured_articles = query("SELECT artikel.*, categories.name as category_name, user.nama as author_name 
                          FROM artikel 
                          LEFT JOIN categories ON artikel.category_id = categories.id 
                          LEFT JOIN user ON artikel.UserId = user.UserId 
                          WHERE artikel.status = 'Dipublish' 
                          AND artikel.is_hidden = 0 
                          ORDER BY artikel.tanggal DESC 
                          LIMIT 3");

// Get latest articles
$latest_articles = query("SELECT artikel.*, categories.name as category_name, user.nama as author_name 
                         FROM artikel 
                         LEFT JOIN categories ON artikel.category_id = categories.id 
                         LEFT JOIN user ON artikel.UserId = user.UserId 
                         WHERE artikel.status = 'Dipublish' 
                         AND artikel.is_hidden = 0 
                         ORDER BY artikel.tanggal DESC 
                         LIMIT 6");

// Get categories with article count
$categories = query("SELECT c.*, COUNT(a.id) as article_count 
                    FROM categories c 
                    LEFT JOIN artikel a ON c.id = a.category_id 
                    AND a.status = 'Dipublish' 
                    AND a.is_hidden = 0 
                    GROUP BY c.id 
                    ORDER BY c.name ASC");
?>

<?php require('views/partials/header.php') ?>

<style>
.hero-section {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/hero-bg.jpg');
    background-size: cover;
    background-position: center;
    height: 500px;
    color: white;
}

.article-card {
    transition: transform 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.datetime-display {
    font-family: 'Courier New', monospace;
    background: rgba(0, 0, 0, 0.7);
    padding: 10px 20px;
    border-radius: 5px;
    margin-top: 20px;
    display: inline-block;
}

.user-welcome {
    background: rgba(0, 0, 0, 0.7);
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.category-badge {
    font-size: 0.8rem;
    padding: 5px 10px;
    margin-right: 5px;
    background-color: #007bff;
    color: white;
    border-radius: 15px;
}
</style>


<!-- CAROUSEL -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card bg-dark text-white" style="width: 100vw; margin: auto;">
            <!-- Carousel di dalam card -->
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="img/1.jpg" class="w-100" alt="Slide 1" style="object-fit: cover; opacity: 0.6;">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="img/2.jpg" class="w-100" alt="Slide 2" style="object-fit: cover; opacity: 0.6;">
                    </div>
                    <div class="carousel-item">
                        <img src="img/3.jpg" class="w-100" alt="Slide 3" style="object-fit: cover; opacity: 0.6;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!-- Overlay text -->
            <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                <h1 class="card-title display-4">Welcome to Our Blog</h1>
                <p class="card-text lead">Discover interesting articles and stay updated with the latest content</p>
                <p class="card-text">
                    <?php echo date('l, F j, Y'); ?> |
                    <span id="current-time"><?php echo date('H:i:s'); ?></span>
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Featured Articles -->
<div class="container my-5">
    <h2 class="text-center mb-4">
        <i class="bi bi-star"></i> Featured Articles
    </h2>
    <div class="row">
        <?php foreach ($featured_articles as $article): ?>
        <div class="col-md-4 mb-4">
            <div class="card article-card h-100">
                <img src="img/<?= htmlspecialchars($article['gambar']) ?>" class="card-img-top"
                    alt="<?= htmlspecialchars($article['judul']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($article['judul']) ?></h5>
                    <p class="card-text text-muted small">
                        <i class="bi bi-person"></i> <?= htmlspecialchars($article['author_name']) ?> |
                        <i class="bi bi-calendar"></i> <?= date('M d, Y', strtotime($article['tanggal'])) ?>
                    </p>
                    <p class="card-text"><?= htmlspecialchars(substr($article['isi'], 0, 100)) ?>...</p>
                    <a href="detail.php?id=<?= $article['id'] ?>" class="btn btn-primary">
                        <i class="bi bi-book"></i> Read More
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Categories and Latest Articles -->
<div class="container my-5">
    <div class="row">
        <!-- Categories -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-tags"></i> Categories
                    </h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($categories as $category): ?>
                        <a href="blog.php?category=<?= $category['id'] ?>"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-folder"></i>
                                <?= htmlspecialchars($category['name']) ?>
                            </span>
                            <span class="badge bg-primary rounded-pill">
                                <?= $category['article_count'] ?>
                            </span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Articles -->
        <div class="col-md-8">
            <h3 class="mb-4">
                <i class="bi bi-clock-history"></i> Latest Articles
            </h3>
            <?php foreach ($latest_articles as $article): ?>
            <div class="card mb-3 article-card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="img/<?= htmlspecialchars($article['gambar']) ?>" class="img-fluid rounded-start"
                            alt="<?= htmlspecialchars($article['judul']) ?>" style="height: 100%; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['judul']) ?></h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-person"></i> <?= htmlspecialchars($article['author_name']) ?> |
                                <i class="bi bi-calendar"></i> <?= date('M d, Y', strtotime($article['tanggal'])) ?>
                                |
                                <i class="bi bi-tag"></i> <?= htmlspecialchars($article['category_name']) ?>
                            </p>
                            <p class="card-text"><?= htmlspecialchars(substr($article['isi'], 0, 150)) ?>...</p>
                            <a href="detail.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-primary">
                                Read More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php require('views/partials/footer.php') ?>

<script>
// Update current time
function updateTime() {
    const timeElement = document.getElementById('current-time');
    const now = new Date();
    timeElement.textContent = now.toLocaleTimeString();
}

setInterval(updateTime, 1000);
</script>