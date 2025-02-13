<?php require('functions.php') ?>

<?php
// Get the ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    echo "Artikel tidak ditemukan.";
    exit;
}

// Fetch the data from the database based on the ID
$sql = "SELECT artikel.id, artikel.judul, artikel.tanggal, artikel.isi, artikel.gambar, user.nama 
        FROM artikel 
        JOIN user ON artikel.UserId = user.UserId 
        WHERE artikel.id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Artikel tidak ditemukan.";
    exit;
}

$conn->close();
?>

<?php require('views/partials/header.php') ?>

    <!-- ISI -->
     
    <div class="container mt-5">
    <a href="index.php" class="" style="text-decoration: none;"><svg xmlns="http://www.w3.org/2000/svg" height="20" width="15.5" viewBox="0 0 448 512" style="margin-right: 10px;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>Kembali ke Beranda</a>
        <h1 class="h2" style="margin-top: 30px;"><?php echo htmlspecialchars($row['judul']); ?></h1>
        <p>Oleh <strong><a href="penulis.php?id=<?php echo htmlspecialchars($row['UserId'] ?? ''); ?>" style="text-decoration: none; color: blue;"><?php echo htmlspecialchars($row['nama'] ?? ''); ?></a></strong> Pada <?php echo htmlspecialchars($row['tanggal'] ?? ''); ?></p>
        <img src="img/<?php echo htmlspecialchars($row['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['judul']); ?>">
        <p><?php echo nl2br(htmlspecialchars($row['isi'])); ?></p>


        <!-- KOMENTAR -->
        <div class="comments mt-5">
            <h2>Comments</h2>
            <!-- Comment form -->
            <form action="submit_comment.php" method="post">
                <input type="hidden" name="artikel_id" value="<?php echo $row['id']; ?>">
                <div class="form-group">
                    <label for="comment">Your Comment:</label>
                    <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <!-- Display comments -->
            <?php
            // Connect to the database again to fetch comments
            $conn = new mysqli('localhost', 'root', '', 'kpl');
            $sql = "SELECT * FROM comments WHERE artikel_id = $id ORDER BY tanggal DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($comment = $result->fetch_assoc()) {
                    echo "<div class='comment mt-4'>";
                    echo "<p><strong>" . htmlspecialchars($comment['nama']) . "</strong> <small>" . htmlspecialchars($comment['tanggal']) . "</small></p>";
                    echo "<p>" . nl2br(htmlspecialchars($comment['isi'])) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

<?php require('views/partials/footer.php') ?>