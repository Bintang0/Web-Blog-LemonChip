<?php 
require 'functions.php';

// Get article ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: blog.php");
    exit;
}

// Get user info from session
$userInfo = getUserInfo();
$userLogin = $userInfo['nama'];
$userId = $userInfo['userId'];
$isLoggedIn = $userInfo['isLoggedIn'];


if ($isLoggedIn) {
    $sql = "SELECT nama FROM user WHERE UserId = $userId";
    $result = query($sql);
    $userLogin = $result[0]['nama'] ?? 'Guest';
}

// Set timezone and format
date_default_timezone_set('UTC');
$current_time = date('Y-m-d H:i:s');

// Get article details
$sql = "SELECT a.*, c.name as category_name, u.nama as author_name 
        FROM artikel a 
        LEFT JOIN categories c ON a.category_id = c.id 
        LEFT JOIN user u ON a.UserId = u.UserId 
        WHERE a.id = $id AND a.status = 'Dipublish'";
$articles = query($sql);

if (empty($articles)) {
    header("Location: blog.php");
    exit;
}
$article = $articles[0];

// Handle comment submission
if (isset($_POST['submit_comment'])) {
    $comment = trim($_POST['comment']);
    
    if (!empty($comment)) {
        $comment = mysqli_real_escape_string($conn, $comment);
        
        if ($isLoggedIn) {
            $sql = "INSERT INTO comments (artikel_id, isi, nama, UserId) 
                    VALUES ($id, '$comment', '$userLogin', $userId)";
        } else {
            $guestName = trim($_POST['guest_name']);
            if (!empty($guestName)) {
                $guestName = mysqli_real_escape_string($conn, $guestName);
                $sql = "INSERT INTO comments (artikel_id, isi, nama, guest_name) 
                        VALUES ($id, '$comment', '$guestName', '$guestName')";
            }
        }
        
        if (isset($sql)) {
            mysqli_query($conn, $sql);
            header("Location: detail.php?id=$id#comments");
            exit;
        }
    }
}

// Get comments
$sql = "SELECT c.*, 
        CASE WHEN c.UserId IS NOT NULL THEN u.nama ELSE c.guest_name END as display_name,
        CASE WHEN c.UserId IS NOT NULL THEN 'Member' ELSE 'Guest' END as user_type
        FROM comments c 
        LEFT JOIN user u ON c.UserId = u.UserId 
        WHERE c.artikel_id = $id 
        ORDER BY c.tanggal DESC";
$comments = query($sql);

// Get keywords
$keywords = query("SELECT keyword FROM article_keywords WHERE artikel_id = $id");
?>

<?php require("views/partials/header.php") ?>

<div class="container mt-4">

    <!-- Article Section -->
    <div class="card shadow-sm mb-4">
        <!-- Article Image -->
        <div class="position-relative">
            <img src="img/<?= htmlspecialchars($article['gambar']) ?>" class="card-img-top"
                alt="<?= htmlspecialchars($article['judul']) ?>" style="height: 400px; object-fit: cover;">
            <div class="position-absolute bottom-0 start-0 w-100 p-3"
                style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                <h1 class="text-white mb-0"><?= htmlspecialchars($article['judul']) ?></h1>
            </div>
        </div>

        <!-- Article Meta -->
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="me-3">
                    <i class="bi bi-person-circle text-primary fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-0"><?= htmlspecialchars($article['author_name']) ?></h6>
                    <small class="text-muted">
                        <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($article['tanggal'])) ?> |
                        <i class="bi bi-folder2"></i> <?= htmlspecialchars($article['category_name']) ?>
                    </small>
                </div>
            </div>

            <!-- Keywords -->
            <?php if (!empty($keywords)): ?>
            <div class="mb-3">
                <?php foreach($keywords as $keyword): ?>
                <span class="badge bg-secondary me-1 rounded-pill">
                    <i class="bi bi-tag-fill"></i> <?= htmlspecialchars($keyword['keyword']) ?>
                </span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="article-content mb-4">
                <?= nl2br(htmlspecialchars($article['isi'])) ?>
            </div>

            <a href="blog.php" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Blog
            </a>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="card shadow-sm" id="comments">
        <div class="card-header bg-white">
            <h4 class="mb-0">
                <i class="bi bi-chat-square-text"></i>
                Comments <span class="badge bg-primary rounded-pill"><?= count($comments) ?></span>
            </h4>
        </div>
        <div class="card-body">
            <!-- Comment Form -->
            <div class="comment-form mb-4">
                <form action="" method="POST">
                    <?php if (!$isLoggedIn): ?>
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="guest_name" class="form-control" required>
                        </div>
                        <small class="text-muted">Posting as guest</small>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-light">
                        <i class="bi bi-person-circle"></i>
                        Commenting as: <strong><?= htmlspecialchars($userLogin) ?></strong>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Your Comment *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                            <textarea name="comment" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <button type="submit" name="submit_comment" class="btn btn-primary">
                        <i class="bi bi-send"></i> Post Comment
                    </button>
                </form>
            </div>

            <!-- Comments List -->
            <div class="comments-list">
                <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                <div class="comment-item mb-3">
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <?php if ($comment['user_type'] === 'Member'): ?>
                                    <i class="bi bi-person-circle text-primary fs-4 me-2"></i>
                                    <?php else: ?>
                                    <i class="bi bi-person text-secondary fs-4 me-2"></i>
                                    <?php endif; ?>
                                    <div>
                                        <h6 class="mb-0">
                                            <?= htmlspecialchars($comment['display_name']) ?>
                                            <span
                                                class="badge <?= $comment['user_type'] === 'Member' ? 'bg-primary' : 'bg-secondary' ?> ms-2">
                                                <?= $comment['user_type'] ?>
                                            </span>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i>
                                            <?= date('d M Y H:i', strtotime($comment['tanggal'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($comment['isi'])) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-chat-dots text-muted fs-1"></i>
                    <p class="text-muted mt-3">No comments yet. Be the first to comment!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.badge {
    padding: 0.5em 1em;
}

.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.comment-item {
    transition: transform 0.2s;
}

.comment-item:hover {
    transform: translateX(5px);
}

.input-group-text {
    background-color: #f8f9fa;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
}

.input-group .form-control:focus {
    border-color: #dee2e6;
    box-shadow: none;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    margin: 1rem 0;
}

.bg-primary {
    background: linear-gradient(45deg, #007bff, #0056b3) !important;
}
</style>

<?php require("views/partials/footer.php") ?>